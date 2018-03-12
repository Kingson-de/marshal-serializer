<?php
declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\FlexibleData;

abstract class AbstractObjectMapper {

    /**
     * @param FlexibleData $flexibleData
     * @return mixed
     */
    abstract public function map(FlexibleData $flexibleData);

    /**
     * @param AbstractObjectMapper $mapper
     * @param FlexibleData $flexibleData
     * @return mixed
     */
    public function item(AbstractObjectMapper $mapper, FlexibleData $flexibleData) {
        return $mapper->map($flexibleData);
    }

    public function collection(AbstractObjectMapper $mapper, FlexibleData $flexibleData): array {
        $data = [];

        foreach ($flexibleData as $item) {
            $data[] = $mapper->map($item);
        }

        return $data;
    }
}
