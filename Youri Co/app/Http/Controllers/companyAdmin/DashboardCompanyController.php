<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Auth; // Import Auth Facade
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Staff;

use App\Models\Purchase;
use App\Models\Sales;

class DashboardCompanyController extends Controller
{
 public function index(Request $request)
{
    $userId = Auth::user()->id;

    // Cache key
    $cacheKey = 'dashboard_data_' . $userId;

    $dashboardData = Cache::remember($cacheKey, 300, function () use ($userId) {
        $currentMonth = now()->month;

        // Precompute totals
        $totalSales = Sales::where('created_by', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_amount');

        $totalExpenses = Expense::where('created_by', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount');

        $totalPurchases = Purchase::where('created_by', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->sum('cost');

        // Filters
        $dateRanges = [
            'today' => now()->startOfDay(),
            'thisWeek' => now()->startOfWeek(),
            'thisMonth' => now()->startOfMonth(),
            'thisYear' => now()->startOfYear(),
        ];

        $data = [];
        foreach ($dateRanges as $key => $startDate) {
            $data[$key] = [
                'sales' => Sales::where('created_by', $userId)
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('total_amount'),
                'receive' => Sales::where('created_by', $userId)
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('cash_received'),
                'due' => Sales::where('created_by', $userId)
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('balance'),
                'expense' => Expense::where('created_by', $userId)
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('amount'),
                'purchase' => Purchase::where('created_by', $userId)
                    ->whereBetween('created_at', [$startDate, now()])
                    ->sum('cost'),
            ];

            $data[$key]['profit'] = $data[$key]['sales'] - ($data[$key]['expense'] + $data[$key]['purchase']);
        }

        // Get Yearly Report Data (Sales and Amount Received per Month)
        $yearlySalesData = [];
        $yearlyReceivedData = [];
        for ($month = 1; $month <= 12; $month++) {
            $yearlySalesData[] = Sales::where('created_by', $userId)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount');

            $yearlyReceivedData[] = Sales::where('created_by', $userId)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->sum('cash_received');
        }

        return [
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'totalPurchases' => $totalPurchases,
            'data' => $data,
            'yearlySalesData' => $yearlySalesData,
            'yearlyReceivedData' => $yearlyReceivedData
        ];
    });

    // Get counts (not cached as these might change frequently)
    $customerCount = Customer::where('created_by', $userId)->count();
    $staffCount = Staff::where('created_by', $userId)->count();
    $orderCount = Sales::where('created_by', $userId)->count();
    $delieverOrderCount = Sales::where('created_by', $userId)->where('status', 4)->count();

    return view('companyAdmin.dashboard', array_merge(
        [
            'customerCount' => $customerCount,
            'staffCount' => $staffCount,
            'orderCount' => $orderCount,
            'delieverOrderCount' => $delieverOrderCount,
        ],
        $dashboardData
    ));
}



}
