<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'name'             => $row['name'],
            'zone_id'          => $row['zone_id'],
            'address'          => $row['address'],
            'phone_number'     => $row['phone_number'],
            'latitude'         => $row['latitude'] ?? null,
            'longitude'        => $row['longitude'] ?? null,
            'category'         => $row['category'],
            'opening_balance'  => $row['opening_balance'],
            'opening_stock'    => $row['opening_stock'],
            'id_card_no'       => $row['id_card_no'],
            'email'            => $row['email'],
            'password'         => Hash::make($row['password']),
            'confirm_password' => $row['password'], // keep if required
            'created_by'       => Auth::id(),
            'refrel_code'      => Auth::user()->refrel_code,
            'status'           => 1,
        ]);
    }
}
