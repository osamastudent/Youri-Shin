<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTracking extends Model
{
    use HasFactory;
    protected $table ='expense_tracking';
    protected $guarded =[];
}
