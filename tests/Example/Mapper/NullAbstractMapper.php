<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\Mapper;

use KingsonDe\Marshal\AbstractMapper;

class NullAbstractMapper extends AbstractMapper {

    public function map() {
        return null;
    }
}
