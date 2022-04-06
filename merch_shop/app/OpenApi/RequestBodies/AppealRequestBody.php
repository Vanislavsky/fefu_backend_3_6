<?php

namespace App\OpenApi\RequestBodies;

use App\Models\Appeal;
use App\OpenApi\Schemas\AppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class AppealRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('AppealCreate')
            ->description('Appeal data')
            ->content(
                MediaType::json()->schema(AppealSchema::ref())
            );
    }
}
