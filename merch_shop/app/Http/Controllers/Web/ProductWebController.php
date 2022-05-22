<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use function abort;
use function view;

class ProductWebController extends Controller
{
    public function index(string $slug)
    {
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->first();

        if ($product === null) {
            abort(404);
        }



        return view('product.index', ['product' => $product]);
    }
}
