<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\EmptyCategoriesSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class EmptyCategoriesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->description('Empty categories')->content(
            MediaType::json()->schema(EmptyCategoriesSchema::ref()));
    }
}
