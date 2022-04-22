<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\ErrorAuthSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorAuthResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Invalid login')->content(
            MediaType::json()->schema(ErrorAuthSchema::ref()));
    }
}
