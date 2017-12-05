<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

interface DataStructure {

    /**
     * @return array|null
     */
    public function build();
}
