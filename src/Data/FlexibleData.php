<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class FlexibleData implements DataStructure, \ArrayAccess, \Iterator {

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $position = 0;

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function build() {
        return $this->data;
    }

    /**
     * @param string|int $key
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function get($key) {
        if (!array_key_exists($key, $this->data)) {
            throw new \OutOfBoundsException("No value set for $key.");
        }

        return $this->find($key);
    }

    /**
     * @param string|int $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function find($key, $defaultValue = null) {
        if (!array_key_exists($key, $this->data)) {
            return $defaultValue;
        }

        if (\is_scalar($this->data[$key])) {
            return $this->data[$key];
        }

        if (\is_array($this->data[$key])) {
            return new FlexibleData($this->data[$key]);
        }

        return $this->data[$key];
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function &offsetGet($offset) {
        return $this->data[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value) {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function current() {
        return new FlexibleData($this->data[$this->position]);
    }

    /**
     * @inheritdoc
     */
    public function next() {
        ++$this->position;
    }

    /**
     * @inheritdoc
     */
    public function key() {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function valid() {
        return isset($this->data[$this->position]);
    }

    /**
     * @inheritdoc
     */
    public function rewind() {
        $this->position = 0;
    }
}
