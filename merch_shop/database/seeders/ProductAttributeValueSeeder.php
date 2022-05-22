<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductAttributeValue::query()->delete();

        $products = Product::get();
        $attributes = ProductAttribute::get();
        $categoryIds = ProductCategory::pluck('id')->all();

        /** @var Generator $faker */
        $faker = app(Generator::class);
        $attributesIdsByCategoryId = [];
        foreach ($categoryIds as $categoryId) {
            $attributesIdsByCategoryId[$categoryId] = $faker->randomElements($attributes, rand(3, 15));
        }

        foreach ($products as $product) {
            foreach ($attributesIdsByCategoryId[$product->product_category_id] as $attribute) {
                if ($faker->boolean(90)) {
                    ProductAttributeValue::factory()->product($product->id)->attribute($attribute)->create();
                }
            }
        }
    }
}
