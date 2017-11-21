<?php

declare(strict_types=1);

namespace KingsonDe\Marshal\Example\Mapper;

use KingsonDe\Marshal\Mapper;

class NullMapper extends Mapper {

    public function map() {
        return null;
    }
}
