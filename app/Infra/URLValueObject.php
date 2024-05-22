<?php

namespace App\Infra;

class URLValueObject extends StringValueObject
{
    protected function prepare(string $value): string
    {
        if (!preg_match('/^https?:\/\//i', $value)) {
            $value = 'http://' . $value;
        }

        return $value;
    }
}
