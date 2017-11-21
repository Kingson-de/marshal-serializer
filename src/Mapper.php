<?php

declare(strict_types=1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\Item;

/**
 * Concrete Mapper classes MUST implement a "map" function that must return an array or null.
 * The reason of not having an abstract function for the "map" function is type hinting.
 */
abstract class Mapper {

    protected function item(Mapper $mapper, ...$data): Item {
        return new Item($mapper, ...$data);
    }

    protected function collection(Mapper $mapper, ...$data): Collection {
        return new Collection($mapper, ...$data);
    }
}
