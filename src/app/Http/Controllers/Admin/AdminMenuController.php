<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(12);
        $currentCategory = $request->category ?? 'all';

        $totalItems = Product::count();
        $inStock = Product::where('is_available', true)->count();
        $outOfStock = Product::where('is_available', false)->count();
        
        // For now, let's just pick the first available product as a dummy Best Seller
        $bestSeller = Product::where('is_available', true)->first()->name ?? 'None';

        return view('admin.menu.index', compact(
            'products', 
            'currentCategory',
            'totalItems',
            'inStock',
            'outOfStock',
            'bestSeller'
        ));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'category' => 'required|in:coffee,non_coffee,food,snack',
            'image' => 'nullable|url',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $request->image,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.menu.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'category' => 'required|in:coffee,non_coffee,food,snack',
            'image' => 'nullable|url',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $request->image,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.menu')->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleAvailability(Product $product)
    {
        $product->update([
            'is_available' => !$product->is_available
        ]);

        return redirect()->back()->with('success', 'Status ketersediaan ' . $product->name . ' berhasil diubah.');
    }
}
