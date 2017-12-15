<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class Item extends AbstractDataStructure {

    /**
     * @inheritdoc
     */
    public function build() {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->getMapper()->map(...$this->getData());
    }
}
