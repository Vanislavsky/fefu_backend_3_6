<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return  $this->hasMany(Product::class);
    }

    public static function getTreeProductsBuilder(Collection $categories): Builder
    {
        if ($categories->isEmpty()) {
            throw new \Exception('categories is empty');
        }
        $categoryIds = [];
        $collectCategoryIds = function (ProductCategory $category) use (&$categoryIds, &$collectCategoryIds) {
            $categoryIds[] = $category->id;
            foreach ($category->children as  $childCategory) {
              $collectCategoryIds($childCategory);
            }
        };

        foreach ($categories as $category) {
            $collectCategoryIds($category);
        }

        return Product::query()->whereIn('product_category_id', $categoryIds);
    }
}
