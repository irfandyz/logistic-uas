<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingItem;
use App\Models\OutgoingItem;
use App\Models\Item;
use App\Models\IncomingItemDetail;
use App\Models\OutgoingItemDetail;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $incomingItems = 0;
        $incomingItemsValue = 0;
        $outgoingItems = 0;
        $outgoingItemsValue = 0;

        foreach (IncomingItemDetail::all() as $incomingItem) {
            $incomingItems += $incomingItem->quantity;
            $incomingItemsValue += $incomingItem->quantity * $incomingItem->item->price;
        }

        foreach (OutgoingItemDetail::all() as $outgoingItem) {
            $outgoingItems += $outgoingItem->quantity;
            $outgoingItemsValue += $outgoingItem->quantity * $outgoingItem->item->price;
        }

        $items = Item::all();
        $totalValue = 0;
        foreach ($items as $item) {
            $totalValue += $item->price * $item->quantity;
        }
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $shippings = Shipping::all();
        $categories = Category::all();
        return view('user.dashboard', compact('incomingItems', 'incomingItemsValue', 'outgoingItems', 'outgoingItemsValue', 'items', 'totalValue', 'suppliers', 'customers', 'shippings', 'categories'));
    }
}
