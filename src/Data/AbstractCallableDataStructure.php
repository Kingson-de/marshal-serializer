<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

abstract class AbstractCallableDataStructure implements DataStructure {

    /**
     * @var callable
     */
    private $mappingFunction;

    /**
     * @var array
     */
    private $data;

    public function __construct(callable $mappingFunction, ...$data) {
        $this->mappingFunction = $mappingFunction;
        $this->data            = $data;
    }

    public function getMappingFunction(): callable {
        return $this->mappingFunction;
    }

    public function getData(): array {
        return $this->data;
    }
}
