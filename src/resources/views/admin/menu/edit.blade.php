@extends('admin.layout')

@section('title', 'Edit Menu')
@section('header', 'Edit Menu: ' . $product->name)

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-[#EBE1D7] shadow-sm overflow-hidden">
        <form action="{{ route('admin.menu.update', $product) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[13px] font-bold text-gray-700 uppercase tracking-wider mb-2">Menu Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                       class="w-full px-4 py-3 bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8C4A15]/20 focus:border-[#8C4A15] transition-all text-[15px]">
                @error('name')<p class="text-red-500 text-[13px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 uppercase tracking-wider mb-2">Category <span class="text-red-500">*</span></label>
                <select name="category" required class="w-full px-4 py-3 bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8C4A15]/20 focus:border-[#8C4A15] transition-all text-[15px]">
                    <option value="coffee" {{ old('category', $product->category) == 'coffee' ? 'selected' : '' }}>Coffee</option>
                    <option value="non_coffee" {{ old('category', $product->category) == 'non_coffee' ? 'selected' : '' }}>Non-Coffee</option>
                    <option value="food" {{ old('category', $product->category) == 'food' ? 'selected' : '' }}>Food</option>
                    <option value="snack" {{ old('category', $product->category) == 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('category')<p class="text-red-500 text-[13px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 uppercase tracking-wider mb-2">Price (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1000"
                       class="w-full px-4 py-3 bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8C4A15]/20 focus:border-[#8C4A15] transition-all text-[15px]">
                @error('price')<p class="text-red-500 text-[13px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-3 bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8C4A15]/20 focus:border-[#8C4A15] transition-all text-[15px]">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="text-red-500 text-[13px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[13px] font-bold text-gray-700 uppercase tracking-wider mb-2">Image URL</label>
                <input type="url" name="image" value="{{ old('image', $product->image) }}" placeholder="https://example.com/image.jpg"
                       class="w-full px-4 py-3 bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8C4A15]/20 focus:border-[#8C4A15] transition-all text-[15px]">
                <p class="text-gray-400 text-[12px] mt-1">Leave empty for no image.</p>
                @error('image')<p class="text-red-500 text-[13px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 py-2">
                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                       class="w-5 h-5 rounded text-[#8C4A15] focus:ring-[#8C4A15]">
                <label for="is_available" class="font-medium text-gray-700">Available to order</label>
            </div>

            <div class="pt-4 flex gap-4">
                <a href="{{ route('admin.menu') }}" class="px-6 py-3 border border-[#EBE1D7] text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="flex-1 bg-[#8C4A15] text-white font-bold rounded-xl hover:bg-[#723C10] transition-colors">Update Menu</button>
            </div>
        </form>
    </div>
@endsection
