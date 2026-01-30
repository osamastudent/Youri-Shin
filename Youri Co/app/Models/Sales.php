<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table ='sales';
    protected $guarded = [];
    
    // app/Models/Sales.php

    public function getItemNamesWithQuantities()
    {
        $itemIds = explode(', ', $this->item_id);
        $quantities = explode(', ', $this->buying_qty);
        $items = Items::whereIn('id', $itemIds)->pluck('name', 'id')->toArray();
    
        $itemNamesWithQuantities = [];
        foreach ($itemIds as $index => $itemId) {
            $itemName = $items[$itemId] ?? 'Unknown';
            $quantity = $quantities[$index] ?? 'Unknown';
            $itemNamesWithQuantities[] = "$itemName ($quantity)";
        }
    
        return implode(',', $itemNamesWithQuantities);
    }
    

    public function getItemsArray()
    {
        $itemIds = explode(', ', $this->item_id);
        $quantities = explode(', ', $this->buying_qty);
        $items = Items::whereIn('id', $itemIds)->pluck('name', 'id')->toArray();
    
        $itemNamesWithQuantities = [];
        foreach ($itemIds as $index => $itemId) {
            $itemName = $items[$itemId] ?? 'Unknown';
            $quantity = $quantities[$index] ?? 'Unknown';
            $itemNamesWithQuantities[] = "$itemName ($quantity)";
        }
    
        return $itemNamesWithQuantities; // Return array
    }


public function getItemsArray1()
{
    if (!$this->item_id) {
        return [];
    }

    // Convert comma-separated IDs and quantities to arrays
    $itemIds = array_filter(explode(',', $this->item_id));
    $quantities = $this->buying_qty ? array_filter(explode(',', $this->buying_qty)) : [];

    // Fetch item names from DB
    $items = \App\Models\Items::whereIn('id', $itemIds)
        ->pluck('name', 'id') // ✅ key = id, value = name
        ->toArray();

    $resolvedItems = [];

    // ✅ Combine name + quantity
    foreach ($itemIds as $index => $id) {
        $itemName = $items[$id] ?? "Unknown ($id)";
        $qty = $quantities[$index] ?? 1; // default qty = 1 if missing
        $resolvedItems[] = "{$itemName} ({$qty})";
    }

    return $resolvedItems;
}




public function latestLocation()
{
    return $this->hasOne(RiderLocation::class, 'order_id')->latestOfMany();
}

 // Add relationship to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    // Add relationship to items
    public function items()
    {
        // This assumes you have an Item model
        return $this->belongsToMany(Item::class, 'sale_items')
                    ->withPivot('quantity', 'price');
    }



}
