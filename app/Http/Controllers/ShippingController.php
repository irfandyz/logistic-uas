<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::orderBy('created_at', 'desc')->paginate(10);
        if (request('keyword')) {
            $shippings = Shipping::where('name', 'like', '%' . request('keyword') . '%')
                ->orWhere('person_in_charge', 'like', '%' . request('keyword') . '%')
                ->orWhere('transportation', 'like', '%' . request('keyword') . '%')
                ->orWhere('description', 'like', '%' . request('keyword') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('user.master-data.shipping.index', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Shipping::create($request->all());
        return redirect()->back()->with('success', 'Shipping created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Shipping::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Shipping updated successfully');
    }

    public function destroy($id)
    {
        Shipping::find($id)->delete();
        return redirect()->back()->with('success', 'Shipping deleted successfully');
    }

    public function find($id)
    {
        $shipping = Shipping::find($id);
        return response()->json($shipping);
    }
}
