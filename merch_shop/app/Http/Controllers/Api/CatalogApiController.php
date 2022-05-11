<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\OpenApi\Responses\CatalogResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ProductCategoryResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CatalogApiController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['catalog'])]
    #[OpenApi\Response(factory: CatalogResponse::class, statusCode: 200)]
    public function index()
    {
        return ProductCategoryResource::collection(
            ProductCategory::query()->paginate(5)
        );
    }

    /**
     * Display the specified resource
     *
     * @param string $slug
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['catalog'])]
    #[OpenApi\Response(factory: ProductCategoryResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return new ProductCategoryResource(
            ProductCategory::query()->where('slug', $slug)->firstOrFail()
        );
    }
}
