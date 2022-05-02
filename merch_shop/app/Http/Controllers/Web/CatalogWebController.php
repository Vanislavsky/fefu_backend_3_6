<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;

class CatalogWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $slug = null)
    {
        $query = ProductCategory::query()->with('children');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        return view('catalog.catalog', ['categories' => $query->get()]);
    }
}
