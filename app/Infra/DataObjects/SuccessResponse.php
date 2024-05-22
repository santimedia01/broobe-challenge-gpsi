<?php

namespace App\Infra\DataObjects;

use App\Infra\Traits\Arrayable;

class SuccessResponse
{
    use Arrayable;

    protected readonly bool $success;

    public function __construct()
    {
        $this->success = true;
    }

    public static function from(): self
    {
        return new self();
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
