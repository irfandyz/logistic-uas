<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(15);
        if (request('keyword')) {
            $categories = Category::where('name', 'like', '%' . request('keyword') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }
        return view('user.master-data.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function find($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
}
