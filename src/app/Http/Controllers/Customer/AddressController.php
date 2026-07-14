<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.addresses.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'full_address' => 'required|string|max:1000',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_default' => 'boolean'
        ]);

        $user = auth()->user();

        // If this is the first address, or is_default is true, handle defaults
        if ($user->addresses()->count() === 0) {
            $validated['is_default'] = true;
        } elseif (!empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        } else {
            $validated['is_default'] = false;
        }

        $user->addresses()->create($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        return view('customer.addresses.form', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'full_address' => 'required|string|max:1000',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_default' => 'boolean'
        ]);

        if (!empty($validated['is_default'])) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        } else {
            $validated['is_default'] = false;
        }

        $address->update($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        
        $address->delete();

        return redirect()->route('customer.addresses.index')->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);

        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }
}
