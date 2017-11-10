<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Data;

class Collection extends DataStructure {

    /**
     * @return array
     */
    public function build() {
        $mapper   = $this->getMapper();
        $response = [];

        $data            = $this->getData();
        $modelCollection = reset($data);

        foreach ($modelCollection as $model) {
            $item = call_user_func([$mapper, 'map'], $model);

            if (!is_array($item)) {
                continue;
            }

            $response[] = $item;
        }

        return $response;
    }
}
