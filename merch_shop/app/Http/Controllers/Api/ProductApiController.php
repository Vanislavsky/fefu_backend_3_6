<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\Api\CatalogApiFormRequest;
use App\Http\Resources\ShowProductResource;
use App\Models\ProductAttribute;
use App\OpenApi\Parameters\ListProductParameters;
use App\OpenApi\Parameters\ShowProductParameters;
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
    #[OpenApi\Parameters(factory: ListProductParameters::class)]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: EmptyCategoriesResponse::class, statusCode: 422)]
    public function index(CatalogApiFormRequest $request)
    {
        $requestData = $request->validated();
        $query = ProductCategory::query()->with('children', 'products');

        if (!isset($requestData['category_slug'])) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $requestData['category_slug']);
        }

        $categories = $query->get();
        try {
            $products = ProductCategory::getTreeProductsBuilder($categories);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }

        $appliedFilters = $requestData['filters'] ?? [];
        ProductFilter::apply($products, $appliedFilters);

        if (isset($requestData['search_query'])) {
            $products->search($requestData['search_query']);
        }

        $sortMode = $requestData['sort_mode'] ?? null;
        if ($sortMode === 'price_asc') {
            $products->orderBy('price');
        } else if ($sortMode === 'price_desc') {
            $products->orderBy('price', 'desc');
        }

        return ListProductResource::collection(
            $products->orderBy('products.id')->paginate()
        );
    }

    /**
     * Display the specified resource
     *
     * @param string $slug
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['product'])]
    #[OpenApi\Parameters(factory: ShowProductParameters::class)]
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
