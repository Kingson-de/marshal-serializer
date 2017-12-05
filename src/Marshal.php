<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\CollectionCallable;
use KingsonDe\Marshal\Data\DataStructure;
use KingsonDe\Marshal\Data\Item;
use KingsonDe\Marshal\Data\ItemCallable;

class Marshal {

    /**
     * @param DataStructure $dataStructure
     * @return array|null
     */
    public static function serialize(DataStructure $dataStructure) {
        $rawResponse = $dataStructure->build();

        return static::process($rawResponse);
    }

    public static function serializeItem(AbstractMapper $mapper, ...$data) {
        $item = new Item($mapper, ...$data);

        return static::serialize($item);
    }

    public static function serializeItemCallable(callable $mappingFunction, ...$data) {
        $item = new ItemCallable($mappingFunction, ...$data);

        return static::serialize($item);
    }

    public static function serializeCollection(AbstractMapper $mapper, ...$data) {
        $item = new Collection($mapper, ...$data);

        return static::serialize($item);
    }

    public static function serializeCollectionCallable(callable $mappingFunction, ...$data) {
        $item = new CollectionCallable($mappingFunction, ...$data);

        return static::serialize($item);
    }

    /**
     * @param array|null $rawResponse
     * @return array|null
     */
    private static function process($rawResponse) {
        if (!\is_array($rawResponse)) {
            return null;
        }

        $response = [];

        foreach ($rawResponse as $property => $value) {
            if ($value instanceof DataStructure) {
                $response[$property] = static::serialize($value);
                continue;
            }

            if (\is_array($value)) {
                $response[$property] = static::process($value);
                continue;
            }

            $response[$property] = $value;
        }

        return $response;
    }
}
