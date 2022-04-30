<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\SuccessLogoutSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SuccessLogoutResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('success logout')->content(
            MediaType::json()->schema(SuccessLogoutSchema::ref()));
    }
}
