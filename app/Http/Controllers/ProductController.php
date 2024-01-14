<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $products = Product::when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->paginate(5);
        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $fileName);
        $product = new Product();
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->image = $fileName;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.product.edit', compact(['product', 'categories']));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->image != null) {
            $path = 'storage/products/' . $product->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $path = 'storage/products/' . $product->image;
        if (File::exists($path)) {
            File::delete($path);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
