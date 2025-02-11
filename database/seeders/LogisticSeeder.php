<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\OutgoingItem;
use App\Models\OutgoingItemDetail;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Shipping;

class LogisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $item = Item::create([
                'code' => 'ITM-' . date('YmdHis') . $i,
                'name' => 'Item ' . $i,
                'price' => rand(10000, 100000),
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);

            $incoming = IncomingItem::create([
                'invoice_number' => 'INV-' . date('YmdHis') . $i,
                'supplier_id' => Supplier::inRandomOrder()->first()->id,
                'date_received' => now(),
            ]);
            $outgoing = OutgoingItem::create([
                'invoice_number' => 'INV-' . date('YmdHis') . $i,
                'customer_id' => Customer::inRandomOrder()->first()->id,
                'shipping_id' => Shipping::inRandomOrder()->first()->id,
                'date' => now(),
            ]);
        }
        $id = [];
        for ($j = 0; $j < 5; $j++) {
            $item = Item::whereNotIn('id', $id)->inRandomOrder()->first();
            $id[] = $item->id;
            $quantity = rand(10, 20);
            $incomingDetail = IncomingItemDetail::create([
                'incoming_item_id' => IncomingItem::inRandomOrder()->first()->id,
                'item_id' => $item->id,
                'quantity' => $quantity,
                'price' => [10000, 20000, 30000, 40000, 50000][$j],
            ]);

            $outgoingDetail = OutgoingItemDetail::create([
                'outgoing_item_id' => OutgoingItem::inRandomOrder()->first()->id,
                'item_id' => $item->id,
                'quantity' => $quantity - 5,
                'price' => [10000, 20000, 30000, 40000, 50000][$j],
            ]);

            $item->quantity += $quantity;
            $item->save();
        }
    }
}
