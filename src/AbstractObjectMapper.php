<?php
declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\FlexibleData;

abstract class AbstractObjectMapper {

    /**
     * @param FlexibleData $flexibleData
     * @param mixed[] $additionalData
     * @return mixed
     */
    abstract public function map(FlexibleData $flexibleData, ...$additionalData);

    /**
     * @param AbstractObjectMapper $mapper
     * @param FlexibleData $flexibleData
     * @param mixed[] $additionalData
     * @return mixed
     */
    public function item(
        AbstractObjectMapper $mapper,
        FlexibleData $flexibleData,
        ...$additionalData
    ) {
        return $mapper->map($flexibleData, ...$additionalData);
    }

    /**
     * @param AbstractObjectMapper $mapper
     * @param FlexibleData $flexibleData
     * @param mixed[] ...$additionalData
     * @return array
     */
    public function collection(
        AbstractObjectMapper $mapper,
        FlexibleData $flexibleData,
        ...$additionalData
    ): array {
        $data = [];

        foreach ($flexibleData as $item) {
            $data[] = $mapper->map($item, ...$additionalData);
        }

        return $data;
    }
}
