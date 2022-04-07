<?php

namespace App\OpenApi\Parameters;

use App\OpenApi\Schemas\AppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class AppealParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('name')
                ->required(true)
                ->schema(Schema::string()->maxLength(100)),
            Parameter::query()
                ->name('phone')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('mail')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('message')
                ->required(true)
                ->schema(Schema::string()->maxLength(1000)),

        ];
    }
}
