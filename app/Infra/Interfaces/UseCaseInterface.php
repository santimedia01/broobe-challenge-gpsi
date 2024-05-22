<?php

namespace App\Infra\Interfaces;

interface UseCaseInterface
{
    /**
     * Run the use case.
     *
     * @param mixed ...$params
     * @return mixed
     */
    public function run(...$params): mixed;
}
