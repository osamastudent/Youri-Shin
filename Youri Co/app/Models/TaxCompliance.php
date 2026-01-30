<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCompliance extends Model
{
    use HasFactory;
    protected $table ='tax_compliance';
    protected $guarded=[];
}
