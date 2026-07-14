<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_available', true);

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $currentCategory = $request->category ?? 'all';

        return view('customer.menu', compact('products', 'currentCategory'));
    }
}
