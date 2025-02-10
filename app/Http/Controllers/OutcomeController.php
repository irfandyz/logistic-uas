<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\OutgoingItem;
use App\Models\OutgoingItemDetail;

class OutcomeController extends Controller
{
    public function index()
    {
        $items = OutgoingItem::with('items', 'customer', 'shipping')->orderBy('id', 'desc')->paginate(10);
        $customers = Customer::all();
        $shippings = Shipping::all();

        if (request('keyword')) {
            $items = OutgoingItem::with('items', 'customer')->where('invoice_number', 'like', '%' . request('keyword') . '%')->paginate(10);
        }

        $items->each(function ($item) {
            $item->total_value = 0;
            $item->items->each(function ($detail) use ($item) {
                $item->total_value += $detail->quantity * $detail->price;
            });
        });

        return view('user.logistic.outcome.index', compact('items', 'customers', 'shippings'));
    }

    public function store(Request $request)
    {
        $data = [
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'customer_id' => $request->customer_id,
            'shipping_id' => $request->shipping_id,
        ];
        OutgoingItem::create($data);
        return redirect()->back()->with('success', 'Outgoing item added successfully');
    }

    public function update(Request $request, $id)
    {
        $item = OutgoingItem::find($id);
        $item->update($request->all());
        return redirect()->back()->with('success', 'Outgoing item updated successfully');
    }

    public function find($id)
    {
        $item = OutgoingItem::with('items', 'customer')->find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = OutgoingItem::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Outgoing item deleted successfully');
    }

    public function detail($id)
    {
        $outgoingItem = OutgoingItem::find($id);
        $itemsData = Item::all();
        $items = OutgoingItemDetail::with('item')->where('outgoing_item_id', $id)->paginate(10);
        if (request('keyword')) {
            $items = OutgoingItemDetail::with('item')->where('outgoing_item_id', $id)->whereHas('item', function ($query) {
                $query->where('name', 'like', '%' . request('keyword') . '%');
            })->paginate(10);
        }
        return view('user.logistic.outcome.detail.index', compact('items', 'outgoingItem', 'itemsData'));
    }

    public function addItem(Request $request, $id)
    {
        $item = Item::find($request->item_id);
        $item->quantity += $request->quantity;
        $item->save();

        $detail = OutgoingItemDetail::where('outgoing_item_id', $id)->where('item_id', $request->item_id)->first();
        if ($detail) {
            $detail->quantity += $request->quantity;
            $detail->save();
        } else {
            $item = OutgoingItemDetail::create([
                'outgoing_item_id' => $id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'price' => $item->price,
            ]);
        }
        return redirect()->back()->with('success', 'Item added successfully');
    }

    public function updateItem(Request $request, $id, $detail_id)
    {
        $item = OutgoingItemDetail::find($detail_id);
        $item->item->quantity -= $item->quantity;
        $item->item->save();
        $item->update([
            'quantity' => $request->quantity,
        ]);
        $item->item->quantity += $item->quantity;
        $item->item->save();
        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function deleteItem($id, $detail_id)
    {
        $item = OutgoingItemDetail::find($detail_id);
        $item->item->quantity -= $item->quantity;
        $item->item->save();
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }

    public function findItem($id, $detail_id)
    {
        $item = OutgoingItemDetail::with('item')->find($detail_id);

        return response()->json($item);
    }
}
