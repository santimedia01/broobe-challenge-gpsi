<?php

namespace App\Infra\Traits;

use BackedEnum;
use UnitEnum;

trait EnumHelper
{
    /**
     * Get an array of flatten values of an enum array.
     *
     * @param (BackedEnum|UnitEnum)[] $enums
     * @return array
     */
    public static function getFlattenValues(array $enums): array
    {
        return array_map(fn ($enum) => $enum->value, static::getEnumArrayFromArrayValues($enums));
    }

    /**
     * Get an array of enums of the current type from plain values or instances of the enum.
     *
     * @param array $valuesOrEnums
     * @return array
     */
    public static function getEnumArrayFromArrayValues(array $valuesOrEnums): array
    {
        $enumClass = self::class;

        return array_map(function ($valueOrEnum) use ($enumClass) {
            if ($valueOrEnum instanceof $enumClass) {
                return $valueOrEnum;
            } else {
                return self::from($valueOrEnum);
            }
        }, $valuesOrEnums);
    }
}
