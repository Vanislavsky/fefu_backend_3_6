<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\ErrorAppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorCreatedAppealResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Invalid response')->content(
            MediaType::json()->schema(ErrorAppealSchema::ref()));
    }
}
