<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return redirect()->route('product.index');
    }
}
