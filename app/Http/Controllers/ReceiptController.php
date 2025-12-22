<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function store(Request $request)
    {
        //code الي id
        $request->validate([
    'items' => 'required|array|min:1',
    'items.*.product_id' => 'required|integer', // بدل string
    'items.*.quantity' => 'required|integer|min:1',
]);


        $cashierId = auth()->id();

        // تجميع نفس المنتجات
       $groupedItems = [];
foreach ($request->items as $item) {
    $productId = $item['product_id'];
    if (!isset($groupedItems[$productId])) {
        $groupedItems[$productId] = 0;
    }
    $groupedItems[$productId] += $item['quantity'];
}

        DB::beginTransaction();

        try {
            $totalReceipt = 0;

            // إنشاء الفاتورة
            $receipt = Receipt::create([
                'cashier_id' => $cashierId,
                'total' => 0,
            ]);

           foreach ($groupedItems as $productId => $quantity) {
    $product = Product::find($productId);

    if (!$product) {
        DB::rollBack();
        return response()->json([
            'message' => "Product with ID {$productId} not found"
        ], 404);
    }

    $stock = Stock::where('product_id', $productId)->first();

    if (!$stock) {
        DB::rollBack();
        return response()->json([
            'message' => "Stock record not found for product {$product->name}"
        ], 404);
    }

    if ($stock->quantity < $quantity) {
        DB::rollBack();
        return response()->json([
            'message' => "Not enough stock for product {$product->name}"
        ], 400);
    }

    $itemTotal = $product->price * $quantity;
    $totalReceipt += $itemTotal;

    // إنشاء عنصر الفاتورة
    $receipt->items()->create([
        'product_id' => $productId,
        'quantity' => $quantity,
        'total' => $itemTotal,
    ]);

    // خصم الكمية من المخزون
    $stock->decrement('quantity', $quantity);

    if ($stock->quantity < $stock->minimum) {
        $stock->isStockLow = true;
        $stock->save();
    }
}

            // تحديث إجمالي الفاتورة
            $receipt->update([
                'total' => $totalReceipt
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Receipt created successfully',
                'receipt' => $receipt->load('items')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
