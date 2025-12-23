<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Receipt_items;
use App\Models\Product;

class ProfitController extends Controller
{
    public function detailedProfits()
    {
        $profits = Receipt_items::with('product')->get()->map(function($item) {
            $profit = ($item->product->price - $item->product->stock->cost_price) * $item->quantity;
            return [
                'product' => $item->product->name,
                'quantity_sold' => $item->quantity,
                'profit' => $profit
            ];
        });

        return response()->json($profits);
    }

    public function monthlyProfitRate()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $receipts = Receipt::whereMonth('created_at', $currentMonth)
                           ->whereYear('created_at', $currentYear)
                           ->get();

        $totalProfit = 0;

        foreach ($receipts as $receipt) {
            foreach ($receipt->items as $item) {
                $totalProfit += ($item->product->price - $item->product->stock->cost_price) * $item->quantity;
            }
        }

        return response()->json([
            'month' => $currentMonth,
            'year' => $currentYear,
            'total_profit' => $totalProfit
        ]);
    }
}
