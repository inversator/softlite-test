<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;

class ProductService
{
    public function create(ProductDTO $data): Product
    {
        return Product::create($data->toArray());
    }

    public function update(ProductDTO $data, Product $product): Product
    {
        $product->update($data->toArray());
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
