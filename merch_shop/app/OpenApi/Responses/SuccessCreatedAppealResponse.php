<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\SuccessAppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SuccessCreatedAppealResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('appeal record created')->content(
            MediaType::json()->schema(SuccessAppealSchema::ref()));
    }
}
