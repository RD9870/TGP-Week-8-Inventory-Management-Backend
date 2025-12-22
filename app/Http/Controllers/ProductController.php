<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $products = Product::with(['subcategory', 'manufacture', 'importCompany']) ->paginate(10);

    return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
    $data = $request->validated();

    $data['isStockLow'] = $request->quantity < 10;

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $product = Product::with(['subcategory', 'manufacture', 'importCompany'])->find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json($product);
}


    /**
     * Update the specified resource in storage.
     */
  public function update(UpdateProductRequest $request, string $id)
{
    $product = Product::findOrFail($id);

    $data = $request->validated();

    if (array_key_exists('quantity', $data)) {
        $data['isStockLow'] = $data['quantity'] < 10;
    }

    $product->update($data);

    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $product = Product::findOrFail($id);

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ], 200);
}

}
