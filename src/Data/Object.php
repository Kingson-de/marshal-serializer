<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Data;

class Object extends DataStructure {

    /**
     * @return array|null
     */
    public function build() {
        $mapper   = $this->getMapper();
        return call_user_func_array([$mapper, 'map'], $this->getData());
    }
}
