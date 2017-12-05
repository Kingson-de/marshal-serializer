<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

use KingsonDe\Marshal\AbstractMapper;

abstract class AbstractDataStructure implements DataStructure {

    /**
     * @var AbstractMapper
     */
    private $mapper;

    /**
     * @var mixed[]
     */
    private $data;

    /**
     * @param AbstractMapper $mapper
     * @param array $data
     */
    public function __construct(AbstractMapper $mapper, ...$data) {
        $this->mapper = $mapper;
        $this->data   = $data;
    }

    protected function getMapper(): AbstractMapper {
        return $this->mapper;
    }

    protected function getData(): array {
        return $this->data;
    }
}
