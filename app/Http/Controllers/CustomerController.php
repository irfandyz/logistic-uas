<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
        if (request('keyword')) {
            $customers = Customer::where('name', 'like', '%' . request('keyword') . '%')
                ->orWhere('email', 'like', '%' . request('keyword') . '%')
                ->orWhere('phone', 'like', '%' . request('keyword') . '%')
                ->orWhere('address', 'like', '%' . request('keyword') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('user.master-data.customer.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Customer::create($request->all());
        return redirect()->back()->with('success', 'Customer created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Customer::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }

    public function find($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }
}

