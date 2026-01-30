<?php

namespace App\Http\Controllers\companyAdmin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use Auth;

class TimelineReportController extends Controller
{
    public function index()
    {
        $orders = Sales::where('created_by', Auth::user()->id)->get();
        return view('companyAdmin.reports.timeline-report', compact('orders'));
    }
    
  public function fetchOrder(Request $request)
{
    $saleId = $request->input('sale_id');

    $order = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
        ->select(
            'sales.*', 
            'customers.name as customer'
        )
        ->where('sales.id', $saleId) // Use where instead of find
        ->first();

    if ($order) {
        return response()->json(['order' => $order]);
    } else {
        return response()->json(['order' => null]);
    }
}


}
