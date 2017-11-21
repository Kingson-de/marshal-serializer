<?php

declare(strict_types=1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\Object;

/**
 * Concrete Mapper classes MUST implement a "map" function that must return an array or null.
 * The reason of not having an abstract function for the "map" function is type hinting.
 */
abstract class Mapper {

    protected function object(Mapper $mapper, ...$data): Object {
        return new Object($mapper, ...$data);
    }

    protected function collection(Mapper $mapper, ...$data): Collection {
        return new Collection($mapper, ...$data);
    }
}
