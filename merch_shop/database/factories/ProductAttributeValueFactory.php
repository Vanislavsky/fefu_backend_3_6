<?php

namespace Database\Factories;

use App\Enums\ProductAttributeType;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributeValue>
 */
class ProductAttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
       return [];
    }

    public function product(int $productId): self
    {
        return $this->state(function () use ($productId) {
           return [
               'product_id' => $productId,
           ];
        });
    }

    public function attribute(ProductAttribute $productAttribute): self
    {
        switch ($productAttribute->type) {
            case  ProductAttributeType::STRING:
                $value = $this->faker->realTextBetween(10, 50);
                break;
            case ProductAttributeType::NUMERIC:
                $value = random_int(1, 1000);
                break;
            case ProductAttributeType::BOOLEAN:
                $value = $this->faker->boolean;
                break;
            default:
                $value = '';
                break;

        }

        return $this->state(function () use ($productAttribute, $value) {
            return [
                'product_attribute_id' => $productAttribute->id,
                'value' => $value,
            ];
        });
    }
}
