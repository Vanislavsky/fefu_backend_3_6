<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowProductResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['product'])]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $query = ProductCategory::query()->with('children', 'products');

        $categories = $query->get();
        $products = ProductCategory::getTreeProductsBuilder($categories)
            ->orderBy('id')
            ->paginate();

        return ProductResource::collection(
            $products
        );
    }

    /**
     * Display the specified resource
     *
     * @param string $slug
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['product'])]
    #[OpenApi\Response(factory: ShowProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->firstOrFail();

        return new ProductResource(
            $product
        );
    }
}
