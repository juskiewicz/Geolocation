<?php
namespace Juskiewicz\Geolocation\Http;

use GuzzleHttp\Client as GuzzleClient;
use Juskiewicz\Geolocation\Http\Exception\{
    InvalidCredentials,
    InvalidServerResponse,
    QuotaExceeded
};

class AbstractHttp
{
    /**
     * @var GuzzleClient
     */
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    /**
     * Get URL and return contents. If content is empty, an exception will be thrown.
     *
     * @param string $url
     * @return string
     * @throws InvalidCredentials
     * @throws InvalidServerResponse
     * @throws QuotaExceeded
     */
    protected function getUrlContents(string $url) : string
    {
        $response = $this->getHttpClient()->get(
            $url,
            ['future' => true]
        );

        $statusCode = $response->getStatusCode();
        if (401 === $statusCode || 403 === $statusCode) {
            throw new InvalidCredentials();
        } elseif (429 === $statusCode) {
            throw new QuotaExceeded();
        } elseif ($statusCode >= 300) {
            throw InvalidServerResponse::create((string) $url, $statusCode);
        }

        $body = (string) $response->getBody();
        if (empty($body)) {
            throw InvalidServerResponse::emptyResponse((string) $url);
        }

        return $body;
    }

    /**
     * Decode the response content and validate it to make sure it does not have any errors.
     *
     * @param string $url
     * @param string $content
     * @return mixed result form json_decode()
     * @throws InvalidCredentials
     * @throws InvalidServerResponse
     * @throws QuotaExceeded
     */
    protected function validateResponse(string $url, $content)
    {
        $json = json_decode($content);

        // API error
        if (!isset($json)) {
            throw InvalidServerResponse::create($url);
        }
        if ('REQUEST_DENIED' === $json->status && 'The provided API key is invalid.' === $json->error_message) {
            throw new InvalidCredentials(sprintf('API key is invalid %s', $url));
        }
        if ('REQUEST_DENIED' === $json->status) {
            throw new InvalidServerResponse(
                sprintf('API access denied. Request: %s - Message: %s', $url, $json->error_message)
            );
        }
        if ('OVER_QUERY_LIMIT' === $json->status) {
            throw new QuotaExceeded(sprintf('Daily quota exceeded %s', $url));
        }
        if ('ZERO_RESULTS' === $json->status) {
            throw InvalidServerResponse::emptyResponse($url);
        }

        return $json;
    }

    /**
     * @return GuzzleClient
     */
    protected function getHttpClient() : GuzzleClient
    {
        return $this->client;
    }
}