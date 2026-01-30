<?php

namespace App\Http\Controllers\companyAdmin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\JalCard;
use App\Models\GiftCardRecharge;
use Keygen;
use Auth;
use Illuminate\Validation\Rule;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;


class JalCardController extends Controller
{
   
   
 
 public function index()
{
    $user = Auth::user(); // Get logged-in user

    // ✅ Generate a unique 10-digit card number
    do {
        $generatedCardNo = mt_rand(1000000000, 9999999999); // 10 digits
    } while (DB::table('jal_cards')->where('card_no', $generatedCardNo)->exists());

    // ✅ Fetch only active customers created by this company
    $lims_customer_list = Customer::where('status', 1)
        ->where('created_by', $user->id)
        ->get();

    // ✅ Fetch only Jal Cards created by this company
    $lims_jal_card_all = JalCard::where('created_by', $user->id)
        ->orderBy('id', 'desc')
        ->get();

    return view('companyAdmin.jal_card.index', compact('lims_customer_list', 'lims_jal_card_all', 'generatedCardNo'));
}

 
    public function create()
    {
        //
    }

  public function generateCode()
    {
        return Keygen::numeric(16)->generate();
    }

public function store(Request $request)
{
    // ✅ Generate a unique 10-digit Jal Card number
    do {
        $generatedCardNo = mt_rand(1000000000, 9999999999); // random 10-digit number
    } while (DB::table('jal_cards')->where('card_no', $generatedCardNo)->exists());

    // ✅ Validate request
    $this->validate($request, [
        'amount' => 'required|numeric|min:0',
    ]);

    // ✅ Prepare data
    $data = $request->all();
    $data['card_no'] = $generatedCardNo;
    $data['is_active'] = true;
    $data['created_by'] = Auth::id();
    $data['expense'] = 0;

    // ✅ Create new Jal Card
    $jalCard = JalCard::create($data);

    $message = 'Jal Card created successfully';

    // ✅ Send email to customer (if email exists)
    if (!empty($data['customer_id'])) {
        $customer = Customer::find($data['customer_id']);
        if ($customer && $customer->email) {
            $data['email'] = $customer->email;
            $data['name'] = $customer->name;

            try {
                Mail::send('mail.jal_card_create', $data, function ($m) use ($data) {
                    $m->to($data['email'])->subject('Your Jal Card Details');
                });
            } catch (\Exception $e) {
                $message = 'Jal Card created successfully, but email could not be sent. 
                            Please configure <a href="' . url('setting/mail_setting') . '">mail settings</a>.';
            }
        }
    }

    return redirect()->route('jal_cards.index')->with('message', $message);
}


    public function show($id)
    {
        $jalCard = JalCard::with('customer')->findOrFail($id);
        return view('backend.jal_card.show', compact('jalCard'));
    }

    public function edit($id)
    {
        $jalCard = JalCard::findOrFail($id);
        return response()->json($jalCard);
    }

    // Update Jal Card info
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'card_no_edit' => [
                'required',
                'max:255',
                Rule::unique('jal_cards', 'card_no')->ignore($id)->where(fn($q) => $q->where('is_active', 1)),
            ],
            'amount_edit' => 'required|numeric|min:0',
        ]);

        $jalCard = JalCard::findOrFail($id);
        $jalCard->card_no = $request->card_no_edit;
        $jalCard->amount = $request->amount_edit;
        $jalCard->customer_id = $request->customer_id_edit;
        $jalCard->expired_date = $request->expired_date_edit;
        $jalCard->save();

        return redirect()->route('jal_cards.index')->with('message', 'Jal Card updated successfully.');
    }

    // Recharge Jal Card
    public function recharge(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
        ]);

        $jalCard = JalCard::findOrFail($id);
        $customer = Customer::find($jalCard->customer_id);

        $jalCard->amount += $request->amount;
        $jalCard->save();

        JalCardRecharge::create([
            'jal_card_id' => $jalCard->id,
            'amount' => $request->amount,
            'user_id' => Auth::id(),
        ]);

        $message = 'Jal Card recharged successfully.';

        // Send recharge email
        if ($customer && $customer->email) {
            $data = [
                'email' => $customer->email,
                'name' => $customer->name,
                'card_no' => $jalCard->card_no,
                'balance' => $jalCard->amount - $jalCard->expense,
                'amount' => $request->amount,
            ];

            try {
                Mail::send('mail.jal_card_recharge', $data, function ($m) use ($data) {
                    $m->to($data['email'])->subject('Your Jal Card Recharge Info');
                });
            } catch (\Exception $e) {
                $message = 'Jal Card recharged successfully, but email could not be sent. 
                            Please configure <a href="' . url('setting/mail_setting') . '">mail settings</a>.';
            }
        }

        return redirect()->route('jal_cards.index')->with('message', $message);
    }

    // Bulk delete Jal Cards (soft delete)
    public function deleteBySelection(Request $request)
    {
        $ids = $request->jalCardIdArray ?? [];
        foreach ($ids as $id) {
            $jalCard = JalCard::find($id);
            if ($jalCard) {
                $jalCard->is_active = false;
                $jalCard->save();
            }
        }
        return response()->json(['success' => 'Jal Cards deleted successfully.']);
    }

    // Delete single Jal Card
    public function destroy($id)
    {
        $jalCard = JalCard::findOrFail($id);
        $jalCard->is_active = false;
        $jalCard->save();

        return redirect()->route('jal_cards.index')->with('not_permitted', 'Jal Card deleted successfully.');
    }
}