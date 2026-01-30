<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table ='items';
    protected $guarded=[];
    
    protected $appends = ['image_url'];
    
    
    
    
    
    
    public function getImageUrlAttribute()
{
    if ($this->image) {
        return asset('storage/' . $this->image);
    }
    return null;
}



}
