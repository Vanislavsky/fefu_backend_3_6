<?php

namespace App\Http\Controllers\Web;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\CatalogFormRequest;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\Product;
use App\Models\ProductCategory;

class CatalogWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(CatalogFormRequest $request, string $slug = null)
    {
        $requestData = $request->validated();
        $query = ProductCategory::query()->with('children', 'products');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        $categories = $query->get();
        try {
            $products = ProductCategory::getTreeProductsBuilder($categories);
        } catch (\Exception $exception) {
            abort(422, $exception->getMessage());
        }

        $filters = ProductFilter::build($products, $requestData['filters'] ?? []);
        ProductFilter::apply($products, $requestData['filters'] ?? []);

        if (isset($requestData['search_query'])) {
            $products->search($requestData['search_query']);
        }

        $sortMode = $requestData['sort_mode'] ?? null;
        if ($sortMode === 'price_asc') {
            $products->orderBy('price');
        } else if ($sortMode === 'price_desc') {
            $products->orderBy('price', 'desc');
        }

        return view('catalog.catalog', ['categories' => $categories,
            'products' => $products->orderBy('products.id')->paginate(),
            'filters' => $filters]);
    }
}
