<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Data;

use KingsonDe\ResponseMapper\Mapper;

abstract class DataStructure {

    /**
     * @var Mapper
     */
    private $mapper;

    /**
     * @var mixed[]
     */
    private $data;

    /**
     * @param Mapper $mapper
     * @param array $data
     */
    public function __construct(Mapper $mapper, ...$data) {
        $this->mapper = $mapper;
        $this->data   = $data;
    }

    protected function getMapper() {
        return $this->mapper;
    }

    protected function getData() {
        return $this->data;
    }

    /**
     * @return array|null
     */
    abstract public function build();
}
