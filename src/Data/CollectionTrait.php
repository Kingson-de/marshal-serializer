<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

trait CollectionTrait {

    public function build(): array {
        $output = [];

        $data = $this->getData();
        /** @var \Traversable $modelCollection */
        $modelCollection = \array_shift($data);

        foreach ($modelCollection as $model) {
            $item = $this->mapData($model, ...$data);

            if (!\is_array($item)) {
                continue;
            }

            $output[] = $item;
        }

        return $output;
    }

    abstract protected function getData(): array;

    /**
     * @param mixed $model
     * @param array $data
     * @return array|null
     */
    abstract protected function mapData($model, ...$data);
}