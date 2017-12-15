<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class CollectionCallable extends AbstractCallableDataStructure {

    use CollectionTrait;

    /**
     * @inheritdoc
     */
    protected function mapData($model, ...$data) {
        return $this->getMappingFunction()($model, ...$data);
    }
}
