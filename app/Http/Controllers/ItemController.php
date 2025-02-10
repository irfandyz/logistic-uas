<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('created_at', 'desc')->paginate(10);
        if (request('keyword')) {
            $items = Item::where('name', 'like', '%' .$request->keyword . '%')->paginate(10);
        }
        return view('user.logistic.item.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.logistic.item.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);
        $code = 'ITM-' . date('Ymd') . '-' . rand(1000, 9999);
        $data = [
            'code' => $code,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $data['image'] = $imageName;
            $image->move(public_path('storage/items'), $imageName);
        }
        Item::create($data);
        return redirect('item')->with('success', 'Item created successfully');
    }

    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all();
        return view('user.logistic.item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $item = Item::find($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path('storage/items/' . $item->image))) {
                unlink(public_path('storage/items/' . $item->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $data['image'] = $imageName;
            $image->move(public_path('storage/items'), $imageName);
        }

        $item->update($data);
        return redirect('item')->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if ($item->image && file_exists(public_path('storage/items/' . $item->image))) {
            unlink(public_path('storage/items/' . $item->image));
        }
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }

    public function find($id)
    {
        $item = Item::with('category')->find($id);
        return response()->json($item);
    }
}
