<?php

namespace App\Enums;

class AbstractEnum
{
    public static function getConstants(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }
}
