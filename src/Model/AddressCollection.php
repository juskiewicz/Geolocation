<?php
namespace Juskiewicz\Geolocation\Model;

use Juskiewicz\Geolocation\Model\Address;

class AddressCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var Address[]
     */
    private $addresses;

    /**
     * @param Address[] $addresses
     */
    public function __construct(array $addresses = [])
    {
        $this->addresses = array_values($addresses);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->all());
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->addresses);
    }

    /**
     * @return Address[]
     */
    public function all() : array
    {
        return $this->addresses;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->addresses[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->addresses[$offset]) ? $this->addresses[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->addresses[] = $value;
        } else {
            $this->addresses[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->addresses[$offset]);
    }
}