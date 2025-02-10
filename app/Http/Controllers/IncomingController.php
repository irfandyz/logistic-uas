<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingItem;
use App\Models\IncomingItemDetail;
use App\Models\Item;
use App\Models\Supplier;

class IncomingController extends Controller
{
    public function index()
    {
        $items = IncomingItem::with('items', 'supplier')->orderBy('id', 'desc')->paginate(10);
        $suppliers = Supplier::all();

        if (request('keyword')) {
            $items = IncomingItem::with('items', 'supplier')->where('invoice_number', 'like', '%' . request('keyword') . '%')->paginate(10);
        }

        $items->each(function ($item) {
            $item->total_value = 0;
            $item->items->each(function ($detail) use ($item) {
                $item->total_value += $detail->quantity * $detail->price;
            });
        });

        return view('user.logistic.income.index', compact('items', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = [
            'date_received' => $request->date_received,
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $request->supplier_id,
        ];
        IncomingItem::create($data);
        return redirect()->back()->with('success', 'Incoming item added successfully');
    }

    public function update(Request $request, $id)
    {
        $item = IncomingItem::find($id);
        $item->update($request->all());
        return redirect()->back()->with('success', 'Incoming item updated successfully');
    }

    public function find($id)
    {
        $item = IncomingItem::with('items', 'supplier')->find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = IncomingItem::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Incoming item deleted successfully');
    }

    public function detail($id)
    {
        $incomingItem = IncomingItem::find($id);
        $itemsData = Item::all();
        $items = IncomingItemDetail::with('item')->where('incoming_item_id', $id)->paginate(10);
        if (request('keyword')) {
            $items = IncomingItemDetail::with('item')->where('incoming_item_id', $id)->whereHas('item', function ($query) {
                $query->where('name', 'like', '%' . request('keyword') . '%');
            })->paginate(10);
        }
        return view('user.logistic.income.detail.index', compact('items', 'incomingItem', 'itemsData'));
    }

    public function addItem(Request $request, $id)
    {
        $item = Item::find($request->item_id);
        $item->quantity += $request->quantity;
        $item->save();

        $detail = IncomingItemDetail::where('incoming_item_id', $id)->where('item_id', $request->item_id)->first();
        if ($detail) {
            $detail->quantity += $request->quantity;
            $detail->save();
        } else {
            $item = IncomingItemDetail::create([
                'incoming_item_id' => $id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'price' => $item->price,
            ]);
        }
        return redirect()->back()->with('success', 'Item added successfully');
    }

    public function updateItem(Request $request, $id, $detail_id)
    {
        $item = IncomingItemDetail::find($detail_id);
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
        $item = IncomingItemDetail::find($detail_id);
        $item->item->quantity -= $item->quantity;
        $item->item->save();
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }

    public function findItem($id, $detail_id)
    {
        $item = IncomingItemDetail::with('item')->find($detail_id);

        return response()->json($item);
    }
}
