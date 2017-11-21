<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper;

use KingsonDe\ResponseMapper\Data\Collection;
use KingsonDe\ResponseMapper\Data\Object;

abstract class Mapper {

//    /**
//     * @param mixed
//     * @return array|null
//     */
//    abstract public function map();

    protected function object(Mapper $mapper, ...$data): Object {
        return new Object($mapper, ...$data);
    }

    protected function collection(Mapper $mapper, ...$data): Collection {
        return new Collection($mapper, ...$data);
    }
}
