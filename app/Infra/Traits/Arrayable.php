<?php

namespace App\Infra\Traits;

trait Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @param bool $enumWithName Sets directly the value for enums.
     *                           <br> true: enum = ['name' => $name, 'value' => $value ]
     *                           <br> false: enum = value
     * @return array
     */
    public function toArray(bool $enumWithName = false): array
    {
        $result = [];

        foreach (get_object_vars($this) as $key => $value) {
            $data = $this->getValueAsArray($value, $enumWithName);
            $result[$key] = $data;
        }

        return $result;
    }

    private function getValueAsArray(mixed $value, bool $enumWithName): mixed
    {
        if (is_array($value)) {
            return $this->processArray($value, $enumWithName);
        }

        if (is_object($value)) {
            if (method_exists($value, 'toArray')) {
                return $value->toArray();
            }

            if (method_exists($value, 'value')) {
                return $value->value();
            }

            if (method_exists($value, 'toValue')) {
                return $value->toValue();
            }

            // Works for Enums, and other objects that have that properties
            if ($this->hasNameAndValueProperties($value)) {
                return $enumWithName
                    ? ['name' => $value->name, 'value' => $value->value]
                    : $value->value;
            }
        }

        return $value;
    }

    private function processArray(array $array, bool $enumWithName): array
    {
        $result = [];

        foreach ($array as $index => $value) {
            $result[$index] = $this->getValueAsArray($value, $enumWithName);
        }

        return $result;
    }

    private function hasNameAndValueProperties(mixed $value): bool
    {
        return property_exists($value, 'name')
            && property_exists($value, 'value');
    }
}
