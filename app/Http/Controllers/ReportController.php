<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\purchase_details;
use App\Models\sale_details;
use App\Models\expenses;
use App\Models\stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the Profit and Loss report.
     *
     * @param Request $request
     * @return View
     */
    public function profitLoss(Request $request): View
    {
        $from = $request->input('from', firstDayOfMonth());
        $to = $request->input('to', lastDayOfMonth());

        // Get all products
        $products = products::active()->get();
        $productBreakdown = [];

        $totalSales = 0.0;
        $totalPurchases = 0.0;
        $totalOpeningStockValue = 0.0;
        $totalClosingStockValue = 0.0;

        foreach ($products as $product) {
            $id = $product->id;

            // 1. Sales during the period
            $sales = sale_details::where('product_id', $id)
                ->whereBetween('date', [$from, $to]);
            $qtySold = (float) $sales->sum('qty');
            $salesAmount = (float) $sales->sum('amount');
            $totalSales += $salesAmount;

            // 2. Purchases during the period
            $purchases = purchase_details::where('product_id', $id)
                ->whereBetween('date', [$from, $to]);
            $qtyPurchased = (float) $purchases->sum('qty');
            $purchasesAmount = (float) $purchases->sum('amount');
            $totalPurchases += $purchasesAmount;

            // 3. Opening Stock at start date (strictly before $from)
            $openingCr = (float) stock::where('product_id', $id)->where('date', '<', $from)->sum('cr');
            $openingDb = (float) stock::where('product_id', $id)->where('date', '<', $from)->sum('db');
            $openingQty = $openingCr - $openingDb;

            // Calculate opening average purchase price up to the day before $from
            $fromPrevious = Carbon::parse($from)->subDay()->format('Y-m-d');
            $openingPrice = $this->avgPurchasePriceUpTo($fromPrevious, $id);
            $openingValue = $openingQty * $openingPrice;
            $totalOpeningStockValue += $openingValue;

            // 4. Closing Stock at end date (up to and including $to)
            $closingCr = (float) stock::where('product_id', $id)->where('date', '<=', $to)->sum('cr');
            $closingDb = (float) stock::where('product_id', $id)->where('date', '<=', $to)->sum('db');
            $closingQty = $closingCr - $closingDb;

            // Calculate closing average purchase price up to $to
            $closingPrice = $this->avgPurchasePriceUpTo($to, $id);
            $closingValue = $closingQty * $closingPrice;
            $totalClosingStockValue += $closingValue;

            // 5. Calculate COGS for this product
            // COGS = Opening Value + Purchases Value - Closing Value
            $cogs = $openingValue + $purchasesAmount - $closingValue;
            $grossProfit = $salesAmount - $cogs;

            $productBreakdown[] = [
                'product' => $product,
                'opening_qty' => $openingQty,
                'opening_price' => $openingPrice,
                'opening_value' => $openingValue,
                'qty_purchased' => $qtyPurchased,
                'purchases_amount' => $purchasesAmount,
                'qty_sold' => $qtySold,
                'sales_amount' => $salesAmount,
                'closing_qty' => $closingQty,
                'closing_price' => $closingPrice,
                'closing_value' => $closingValue,
                'cogs' => $cogs,
                'gross_profit' => $grossProfit,
            ];
        }

        // Total COGS = Opening Stock Value + Purchases - Closing Stock Value
        $totalCogs = $totalOpeningStockValue + $totalPurchases - $totalClosingStockValue;
        $totalGrossProfit = $totalSales - $totalCogs;

        // 6. Expenses during the period grouped by category
        $expensesByCategory = expenses::select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('date', [$from, $to])
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $totalExpenses = (float) expenses::whereBetween('date', [$from, $to])->sum('amount');
        $netProfit = $totalGrossProfit - $totalExpenses;

        return view('finance.reports.profit_loss', compact(
            'from',
            'to',
            'productBreakdown',
            'totalSales',
            'totalPurchases',
            'totalOpeningStockValue',
            'totalClosingStockValue',
            'totalCogs',
            'totalGrossProfit',
            'expensesByCategory',
            'totalExpenses',
            'netProfit'
        ));
    }

    /**
     * Helper to get average purchase price up to a specific date.
     * Uses '2000-01-01' as start date to filter using existing avgPurchasePrice helper.
     *
     * @param string $date
     * @param int $id
     * @return float
     */
    private function avgPurchasePriceUpTo(string $date, int $id): float
    {
        $price = avgPurchasePrice('2000-01-01', $date, $id);
        if ($price <= 0) {
            $price = avgPurchasePrice('all', 'all', $id);
        }

        return (float) $price;
    }
}
