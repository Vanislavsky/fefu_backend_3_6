<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class ErrorCreateOrderSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('ErrorOrderData')
            ->properties(
                Schema::string('message'),
                Schema::array('details')->items(Schema::object()->properties(
                    Schema::string('name')->nullable(),
                    Schema::string('phone')->nullable(),
                    Schema::string('message')->nullable(),
                    Schema::string('city')->nullable(),
                    Schema::string('street')->nullable(),
                    Schema::string('house')->nullable(),
                    Schema::string('apartment')->nullable(),
                ))
            );
    }
}
