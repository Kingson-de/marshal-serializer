<?php

declare(strict_types=1);

namespace KingsonDe\Marshal\Data;

class Collection extends DataStructure {

    /**
     * @return array
     */
    public function build(): array {
        $mapper = $this->getMapper();
        $output = [];

        $data = $this->getData();
        /** @var \Traversable $modelCollection */
        $modelCollection = array_shift($data);

        foreach ($modelCollection as $model) {
            $item = $mapper->map($model, ...$data);

            if (!\is_array($item)) {
                continue;
            }

            $output[] = $item;
        }

        return $output;
    }
}
