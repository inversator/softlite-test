<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Events\ProductDeleted;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @param  ProductService  $productService
     */
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            ProductCollectionResource::collection(Product::all()->load('category', 'country', 'user')),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws UnknownProperties
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->toDTO());
        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json(
            new ProductResource($product->load('user', 'country', 'category')),
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws UnknownProperties
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updatedProduct = $this->productService->update($request->toDTO(), $product);
        return response()->json(new ProductResource($updatedProduct), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
    }

    /**
     * Dropdown list
     */
    public function dropdown()
    {
        $approvedProducts = Product::where('status', ProductStatus::Approved)->get(['id', 'name']);

        return response()->json(
            $approvedProducts,
        );
    }
}
