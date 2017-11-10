<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper;

use KingsonDe\ResponseMapper\Data\DataStructure;

class Renderer {

    /**
     * @param DataStructure $dataStructure
     * @return array|null
     */
    public static function createData(DataStructure $dataStructure) {
        $rawResponse = $dataStructure->build();

        return static::process($rawResponse);
    }

    /**
     * @param array|null $rawResponse
     * @return array|null
     */
    private static function process($rawResponse) {
        if (!is_array($rawResponse)) {
            return null;
        }

        $response = [];

        foreach ($rawResponse as $property => $value) {
            if ($value instanceof DataStructure) {
                $response[$property] = static::createData($value);
                continue;
            }

            if (is_array($value)) {
                $response[$property] = static::process($value);
                continue;
            }

            $response[$property] = $value;
        }

        return $response;
    }
}
