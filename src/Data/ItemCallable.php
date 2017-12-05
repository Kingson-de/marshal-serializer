<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class ItemCallable extends AbstractCallableDataStructure {

    /**
     * @inheritdoc
     */
    public function build() {
        return $this->getMappingFunction()(...$this->getData());
    }
}
