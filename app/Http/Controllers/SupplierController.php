<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);
        if (request('keyword')) {
            $suppliers = Supplier::where('name', 'like', '%' . request('keyword') . '%')
                ->orWhere('email', 'like', '%' . request('keyword') . '%')
                ->orWhere('phone', 'like', '%' . request('keyword') . '%')
                ->orWhere('address', 'like', '%' . request('keyword') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('user.master-data.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Supplier::create($request->all());
        return redirect()->back()->with('success', 'Supplier created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Supplier::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return redirect()->back()->with('success', 'Supplier deleted successfully');
    }

    public function find($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }
}
