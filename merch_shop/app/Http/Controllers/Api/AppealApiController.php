<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Requests\AppealFormRequest;
use App\Models\Appeal;
use App\OpenApi\Parameters\AppealParameters;
use App\OpenApi\RequestBodies\AppealRequestBody;
use App\OpenApi\Responses\ErrorCreatedAppealResponse;
use App\OpenApi\Responses\SuccessCreatedAppealResponse;
use App\Sanitizers\PhoneSanitizer;
use Illuminate\Contracts\Support\Responsable;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use function response;

#[OpenApi\PathItem]
class AppealApiController extends Controller
{
    /**
     * Display the specified resource
     *
     * @param AppealFormRequest
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['appeal'])]
    #[OpenApi\Response(factory: SuccessCreatedAppealResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorCreatedAppealResponse::class, statusCode: 422)]
    #[OpenApi\RequestBody(factory: AppealRequestBody::class)]
    public function send(AppealFormRequest $request)
    {
        $data = $request->validated();

        $appeal = new Appeal();
        $appeal->name = $data['name'];
        $appeal->phone = PhoneSanitizer::sanitize($data['phone']);
        $appeal->email = $data['email'];
        $appeal->message = $data['message'];
        $appeal->save();

        return response()->json([
            "message" => "appeal record created"
        ]);
    }
}
