<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Resources\ShowProductResource;
use App\OpenApi\Responses\EmptyCategoriesResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ListProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowProductResponse;
use Illuminate\Contracts\Support\Responsable;
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
    #[OpenApi\Response(factory: EmptyCategoriesResponse::class, statusCode: 422)]
    public function index(Request $request)
    {
        $slug = $request->query('category_slug');
        $query = ProductCategory::query()->with('children', 'products');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        $categories = $query->get();
        try {
            $products = ProductCategory::getTreeProductsBuilder($categories)
                ->orderBy('id')
                ->paginate();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
        return ListProductResource::collection(
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
    public function show(Request $request)
    {
        $slug = $request->query('product_slug');
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->firstOrFail();

        return new ShowProductResource(
            $product
        );
    }
}
