<?php

class ArrayLikeObject implements ArrayAccess
{

    private $pool = array();


    public function __construct(array $array)
    {
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $item = new self($item);
            }
            $this->{$key} = $item;
            $this->pool[] = $key;
        }
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_array($value)) {
            $value = new self($value);
        }
        $this->pool[] = $offset;
        $this->{$offset} = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $resultArray = array();
        foreach ($this->pool as $key) {
            $item = $this->{$key};
            if ($item instanceof self ) {
                $item = $item->toArray();
            }
            $resultArray[$key] = $item;
        }
        return $resultArray;
    }
}