<?php

namespace App\Infra\DataObjects;

use App\Infra\Traits\Arrayable;

class ErrorResponse
{
    use Arrayable;

    protected readonly bool $success;

    public function __construct(
        protected readonly int $code = 1000,
        protected readonly string $message = 'General Error',
        protected readonly array $errors = [],
    ) {
        $this->success = false;
    }

    public static function from(
        int $code = 1000,
        string $message = 'General Error',
        array $errors = []
    ): self  {
        return new self($code, $message, $errors);
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
