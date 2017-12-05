<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

class CollectionCallable extends AbstractCallableDataStructure {

    /**
     * @inheritdoc
     */
    public function build() {
        $output = [];

        $data = $this->getData();
        /** @var \Traversable $modelCollection */
        $modelCollection = \array_shift($data);

        foreach ($modelCollection as $model) {
            $item = $this->getMappingFunction()($model, ...$data);

            if (!\is_array($item)) {
                continue;
            }

            $output[] = $item;
        }

        return $output;
    }
}
