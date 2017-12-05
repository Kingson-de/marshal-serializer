<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\CollectionCallable;
use KingsonDe\Marshal\Data\Item;
use KingsonDe\Marshal\Data\ItemCallable;

/**
 * Concrete Mapper classes MUST implement a "map" function that must return an array or null.
 * The reason of not having an abstract function for the "map" function is type hinting.
 */
abstract class AbstractMapper {

    protected function item(AbstractMapper $mapper, ...$data): Item {
        return new Item($mapper, ...$data);
    }

    protected function itemCallable(callable $mappingFunction, ...$data): ItemCallable {
        return new ItemCallable($mappingFunction, ...$data);
    }

    protected function collection(AbstractMapper $mapper, ...$data): Collection {
        return new Collection($mapper, ...$data);
    }

    protected function collectionCallable(callable $mappingFunction, ...$data): CollectionCallable {
        return new CollectionCallable($mappingFunction, ...$data);
    }
}
