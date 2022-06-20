<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\ErrorCreateOrderSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorCreateOrderResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Invalid order data')->content(
            MediaType::json()->schema(ErrorCreateOrderSchema::ref()));
    }
}
