<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Example\Mapper;

use KingsonDe\ResponseMapper\Mapper;

class NullMapper extends Mapper {

    public function map() {
        return null;
    }
}
