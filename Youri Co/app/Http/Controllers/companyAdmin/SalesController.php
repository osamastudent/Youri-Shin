<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Zone;
use App\Models\Items;
use App\Models\Sales;
use App\Models\Staff;
use App\Models\User;
use App\Services\FirebaseService;
use GuzzleHttp\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode; 
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Auth;
use DB; 


class SalesController extends Controller
{
  public function index(Request $request)
{
    $staffs = Staff::where('created_by', Auth::user()->id)->get();

    $query = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
        ->join('zone', 'zone.id', '=', 'customers.zone_id')
        ->select(
            'sales.*',
            'customers.name as customer_name',
            'customers.phone_number as phone_number',
            'customers.address as address',
            'zone.name as zone'
        )
        ->where('sales.created_by', Auth::user()->id);

    // Date filters (unchanged)
    if ($request->filled('from_date')) {
        $query->whereDate('sales.created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('sales.created_at', '<=', $request->to_date);
    }

    // ✅ Correct status filter that supports status = 0
    // Use has() + explicit check for empty string so "0" works.
    if ($request->has('status') && $request->status !== null && $request->status !== '') {
        // If your statuses are stored as integers, cast to int to be safe:
        $status = is_numeric($request->status) ? (int) $request->status : $request->status;
        $query->where('sales.status', $status);
    }

    // Order by latest (unchanged)
    $query->orderBy('sales.created_at', 'DESC');

    // Paginate and preserve filters in links
    $sales = $query->paginate(10)->appends($request->all());

    return view('companyAdmin.sales.index', compact('sales', 'staffs'));
}



    
    public function show($id)
    {
        $sale = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('zone', 'zone.id', '=', 'customers.zone_id')
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'customers.phone_number as phone_number',
                'customers.address as address',
                'zone.name as zone'
            )
            ->where('sales.id', $id)
            ->firstOrFail();
    
        return view('companyAdmin.sales.show', compact('sale'));
    }
    
    public function printInvoice ($id)
    {
        $sale = Sales::join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('zone', 'zone.id', '=', 'customers.zone_id')
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'customers.phone_number as phone_number',
                'customers.address as address',
                'zone.name as zone'
            )
            ->where('sales.id', $id)
            ->firstOrFail();
    
        return view('companyAdmin.sales.invoice', compact('sale'));
    }

    
    public function getLatestOrders()
    {
        $latestOrder = Sales::latest()->where('created_by', Auth::user()->id)->first();
        return response()->json($latestOrder);
    }
    
    public function updateStatus(Request $request, $id)
    {
        
        dd($request->all()); 
        
        $sale = Sales::find($id);
        $sale->update([
            'status' => 1,
            'staff_id' => $request->staff_id,
            'assigned_at' => Carbon::now('Asia/Karachi')
        ]);
        
        
        return redirect()->route('company-sale.index')->with('success', 'Staff Assigned Successfully!');
    }


    
 
    public function create()
    {
        $userId = Auth::id();
        $customers = Customer::where('created_by', $userId)->get();
        $items = Items::where('created_by', $userId)->get();
        $zones = Zone::where('created_by', $userId)->get();

        return view('companyAdmin.sales.create',compact('customers','items', 'zones'));
     }
  
 public function store(Request $request)
{
    // Validate request
    $request->validate([
        'cash_received' => 'required|numeric|lte:total_amount',
        'balance'       => 'required|numeric|min:0',
    ], [
        'cash_received.required' => 'Please enter cash received.',
        'cash_received.lte'      => 'Cash received cannot be greater than Total Amount.',
        'balance.required'       => 'Balance is required.',
    ]);

    $item_id = $request->item_id;
    $buying_qty = $request->buying_qty;
    $unit_price = $request->unit_price;
    $buying_price = $request->buying_price;
    $bottles = $request->bottles;

    $buying_qty = array_map(function ($qty) {
        return !empty($qty) ? $qty : 1;
    }, $buying_qty);

    // Generate QR Code Data
    $qrData = [
        'order_id' => uniqid('ORD'), // Generate unique order ID
        'customer_id' => $request->customer_id,
        'items' => implode(', ', $item_id),
        'quantities' => implode(', ', $buying_qty),
        'total_amount' => $request->total_amount,
        'payment_type' => $request->payment,
        'transaction_date' => now()->format('Y-m-d H:i:s'),
        'refrel_code' => Auth::user()->refrel_code,
        'created_by' => Auth::user()->id,
        'status' => 'pending'
    ];

    // Convert to JSON for QR Code
    $qrJsonData = json_encode($qrData);

    // Generate QR Code
    $qrCode = QrCode::size(300)->generate($qrJsonData);

    // Save QR Code as image file
    $qrFileName = 'qrcode_' . time() . '_' . uniqid() . '.svg';
    $qrPath = public_path('qrcodes/' . $qrFileName);

    // Ensure directory exists
    if (!file_exists(public_path('qrcodes'))) {
        mkdir(public_path('qrcodes'), 0755, true);
    }

    // Save QR code as SVG file
    file_put_contents($qrPath, $qrCode);

    // Create Sales Record with QR Code Path and order_unique_id
    $sale = Sales::create([
        'customer_id' => $request->customer_id,
        'coupon_code' => $request->code,
        'item_id' => implode(', ', $item_id),
        'buying_qty' => (!empty($buying_qty) ? implode(', ', $buying_qty) : '1'),
        'unit_price' => implode(', ', $unit_price),
        'buying_price' => implode(', ', $buying_price),
        'payment' => $request->payment,
        'total_amount' => $request->total_amount,
        'cash_collected' => $request->cash_collected,
        'cash_received' => $request->cash_received ? $request->cash_received : 0,
        'balance' => $request->balance ? $request->balance : $request->total_amount,
        'bank_account' => $request->bank_account,
        'transaction_id' => $request->transaction_id,
        'transaction_date' => $request->transaction_date,
        'receive_amount' => $request->receive_amount,
        'note' => $request->note,
        'created_by' => Auth::user()->id,
        'status' => 0,
        'refrel_code' => Auth::user()->refrel_code,
        'qr_code_path' => 'qrcodes/' . $qrFileName,
        'qr_code_data' => $qrJsonData,
        'order_unique_id' => $qrData['order_id'], // NEW: store QR order_id here
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('company-sale.index')->with('success', 'Sale Added Successfully!');
}

 
 
 // Add this method to show QR code
    public function showQRCode($id)
    {
        $sale = Sales::with('customer')->findOrFail($id);
        return view('companyAdmin.sales.qrcode', compact('sale'));
    }

    // Add this method to download QR code
    public function downloadQRCode($id)
    {
        $sale = Sales::findOrFail($id);
        
        if (!$sale->qr_code_path) {
            return back()->with('error', 'QR Code not found for this order.');
        }
        
        $filePath = public_path($sale->qr_code_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'QR Code file not found.');
        }
        
        return response()->download($filePath, 'order_qrcode_' . $sale->order_unique_id . '.svg');
    }
 
    
    public function update(Request $request, $id) 
    {  
        $item = Items::find($id);
        $item->update([
            'name' => $request->name,
            'item_type' => $request->item_type,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'tax' => $request->tax,
            'opening_stock' => $request->opening_stock,
            'opening_stock_purschase_price' => $request->opening_stock_purschase_price,
            'barcode_no' => $request->barcode_no,
            // 'price_inculdes_tax' => $request->price_inculdes_tax,
            'created_by' => Auth::user()->id,
            
        ]);

        return redirect()->route('company-item.index')->with('success', 'Vendor Updated Successfully!');

       
    }
    
      
    public function edit($id)
    {  
        $customers = Customer::all();
        $sale = Sales::find($id);
       
        return view('companyAdmin.sales.edit', compact('sale','customers'));
    }
    
        public function delete($id)
    {
        $sales = Sales::findOrFail($id); 
        $sales->delete();
        return redirect()->route('company-sale.index')->with('success', 'Sale Deleted Successfully!');
    }
    

// public function statusChange(Request $request, $id)
// {
//     // Step 1: Find the sale record or fail if it doesn't exist
//     $sale = Sales::findOrFail($id);

//     // Step 2: Update the sale record
//     $sale->status = 1; // Update the status
//     $sale->staff_id = $request->staff_id; // Update the staff ID

//     // Step 3: Set assigned_at to the current timestamp only if it's not already set
//     if (!$sale->assigned_at) {
//         $sale->assigned_at = Carbon::now('Asia/Karachi'); // Set the timestamp
//     }

//     // Step 4: Save the updated record
//     $sale->save();

//     // Step 5: Redirect or return a response
//     return redirect()->route('company-sale.index')->with('success', 'Status updated successfully.');
// }


public function statusChange(Request $request, $id)
{
    // Step 1: Find the sale record
    $sale = Sales::findOrFail($id);

    // Step 2: Update the sale record
    $sale->status = 1; 
    $sale->staff_id = $request->staff_id; 

    if (!$sale->assigned_at) {
        $sale->assigned_at = Carbon::now('Asia/Karachi');
    }

    $sale->save();

    // Step 3: Send Notification
    $staff = Staff::find($request->staff_id);

    if ($staff && $staff->fcm_token) {
        try {
            $accessToken = FirebaseService::getAccessToken();
            $client = new Client();

            $projectId = env('FIREBASE_PROJECT_ID');
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            // Agar table me 'order_no' hai toh use karna, warna id use karna
            $orderNumber = $sale->order_no ?? $sale->id;

            $body = [
                "message" => [
                    "token" => $staff->fcm_token,
                    "notification" => [
                        "title" => "Order Assigned",
                        "body"  => "Order #{$orderNumber} assigned to you",
                    ],
                    "data" => [
                        "order_id" => (string) $sale->id,
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                    ]
                ]
            ];

            $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $body,
            ]);
        } catch (\Exception $e) {
            \Log::error("FCM Notification failed: " . $e->getMessage());
        }
    }

    // Step 4: Redirect
    return redirect()->route('company-sale.index')->with('success', 'Status updated & staff notified.');
} 


public function showInvoice($id)
{
    $sale = Sales::with(['customer', 'customer.zone'])->findOrFail($id);

    // Get the user who created the sale
    $user = User::find($sale->created_by);

    return view('companyAdmin.sales.invoice', compact('sale', 'user'));
}


public function downloadInvoice($id)
{
    $sale = Sales::with(['customer', 'customer.zone'])->findOrFail($id);
    $user = User::find($sale->created_by);

    // ---- Prepare items (avoid Items::find in blade) ----
    $itemIds      = array_map('trim', explode(',', (string)$sale->item_id));
    $quantities   = array_map('trim', explode(',', (string)$sale->buying_qty));
    $unitPrices   = array_map('trim', explode(',', (string)$sale->unit_price));
    $buyingPrices = array_map('trim', explode(',', (string)$sale->buying_price));

    $rows = [];
    $subtotal = 0;
    $totalTax = 0;

    foreach ($itemIds as $index => $itemId) {
        if (!$itemId) continue;

        $item = Items::find($itemId);

        $qty       = (float)($quantities[$index] ?? 1);
        $unitPrice = (float)($unitPrices[$index] ?? 0);
        $totalPrice= (float)($buyingPrices[$index] ?? 0);

        $tax = $totalPrice * 0.10;

        $subtotal += $totalPrice;
        $totalTax += $tax;

        $imgBase64 = null;
        if ($item && $item->item_img) {
            $imgPath = public_path('uploads/' . $item->item_img);
            $imgBase64 = $this->imgToBase64($imgPath);
        }

        $rows[] = [
            'name'       => $item->name ?? ('Item ' . ($index + 1)),
            'qty'        => $qty,
            'unit_price' => $unitPrice,
            'total'      => $totalPrice,
            'tax'        => $tax,
            'img'        => $imgBase64,
        ];
    }

    // ---- QR code base64 ----
    $qrBase64 = null;
    if (!empty($sale->qr_code_path)) {
        // qr_code_path usually like: "uploads/qr/xxx.png" or "storage/..."
        $qrPath = public_path(ltrim($sale->qr_code_path, '/'));
        $qrBase64 = $this->imgToBase64($qrPath);
    }

    $shipping = 0;
    $discount = $sale->coupon_code ? 270.00 : 0;
    $grandTotal = $subtotal + $shipping - $discount;

    $fileName = 'Invoice-' . ($sale->order_unique_id ?? ('SALE-' . $sale->id)) . '.pdf';

 $pdf = Pdf::loadView('companyAdmin.sales.invoice_pdf', compact(
  'sale','user','rows','subtotal','totalTax','shipping','discount','grandTotal','qrBase64'
))->setPaper('a4', 'portrait');



    return $pdf->download($fileName);
}

// ---------- helper: image -> base64 data URI ----------
private function imgToBase64($path)
{
    if (!$path || !file_exists($path)) return null;

    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
}
