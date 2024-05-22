<?php

namespace App\Infra;

abstract class StringValueObject
{
    public function __construct(
        protected string $value
    ) {
        $this->value = $this->prepare($value);
    }

    /**
     * Creates new Instance from primitive String
     *
     * @param string $value
     * @return self
     */
    public static function from(string $value): static
    {
        return new static($value);
    }

    /**
     * Prepares the String Value.
     * Override it when needed.
     *
     * @param string $value
     * @return string
     */
    protected function prepare(string $value): string
    {
        return $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
