<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionList;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerateSalesFromSubscriptions extends Command
{
    protected $signature = 'subscriptions:generate-sales';
    protected $description = 'Generate sales automatically from active subscriptions (daily, weekly, monthly)';

  public function handle()
{
    $now = Carbon::now();
    $today = strtolower($now->format('l'));
    $dayOfMonth = $now->day;

    // Fetch all active subscriptions
    $subscriptions = \App\Models\SubscriptionList::where('status', 'active')->get();

    foreach ($subscriptions as $sub) {
        $shouldGenerate = false;

        // Determine if we should generate sale today
        if ($sub->frequency === 'daily') {
            $shouldGenerate = true;
        } elseif ($sub->frequency === 'weekly' && strtolower($sub->day_of_week) === $today) {
            $shouldGenerate = true;
        } elseif ($sub->frequency === 'monthly' && (int)$sub->day_of_month === $dayOfMonth) {
            $shouldGenerate = true;
        }

        if ($shouldGenerate) {
            try {
                // ✅ Fetch item data
                $item = \App\Models\Items::find($sub->item_id);

                if (!$item) {
                    Log::error("❌ Item not found for subscription ID {$sub->id}");
                    continue;
                }

                // ✅ Calculate price details
                $unitPrice = $item->sale_price;
                $buyingQty = $sub->buying_quantity;
                $totalAmount = $unitPrice * $buyingQty;

                // ✅ Create Sale record
                \App\Models\Sales::create([
                    'customer_id'      => $sub->customer_id,
                    'item_id'          => $sub->item_id,
                    'buying_qty'       => $buyingQty,
                    'unit_price'       => $unitPrice,
                    'buying_price'     => $unitPrice, // optional if column exists
                    'total_amount'     => $totalAmount,
                    'payment'          => 'cash', // default payment mode
                    'status'           => 'pending',
                    'address'          => $sub->address ?? null,
                    'note'             => $sub->notes ?? null,
                    'transaction_date' => $now,
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);

                Log::info("✅ Sale created successfully for subscription ID {$sub->id}");
            } catch (\Exception $e) {
                Log::error("❌ Failed to generate sale for subscription ID {$sub->id}: " . $e->getMessage());
            }
        }
    }

    $this->info('Sales generation job completed successfully!');
}

}
