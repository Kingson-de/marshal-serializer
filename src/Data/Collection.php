<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class Collection extends AbstractDataStructure {

    use CollectionTrait;

    /**
     * @inheritdoc
     */
    protected function mapData($model, ...$data) {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->getMapper()->map($model, ...$data);
    }
}
