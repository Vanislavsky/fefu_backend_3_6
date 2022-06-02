<?php

namespace App\Enums;

abstract class AbstractEnum
{
    public static function getConstants(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }
}
