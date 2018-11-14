<?php

namespace Juskiewicz\Geolocation\Http\Exception;

final class InvalidServerResponse extends \RuntimeException
{
    /**
     * @param string $query
     * @param int    $code
     *
     * @return InvalidServerResponse
     */
    public static function create(string $query, int $code = 0) : self
    {
        return new self(sprintf('Server returned an invalid response (%d) for query "%s". We could not parse it.', $code, $query));
    }

    /**
     * @param string $query
     *
     * @return InvalidServerResponse
     */
    public static function emptyResponse(string $query) : self
    {
        return new self(sprintf('Server returned an empty response for query "%s".', $query));
    }
}