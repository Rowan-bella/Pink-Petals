<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Read: ပန်းစာရင်းကြည့်ရန်
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(8);

        return view('products.index', compact('products'));
    }

    // Create form: ပန်းအသစ်ထည့်ရန် Form
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    // Create: ပန်းအသစ်ကို Database ထဲသိမ်းရန်
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'ပန်းပစ္စည်းအသစ် ထည့်သွင်းပြီးပါပြီ။');
    }

    // Read: ပန်းတစ်မျိုးချင်းစီ၏ အသေးစိတ်ကြည့်ရန်
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    // Update form: ပန်းအချက်အလက်ပြင်ရန် Form
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    // Update: Database ထဲက ပန်းအချက်အလက် ပြင်ရန်
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'ပန်းအချက်အလက် ပြင်ဆင်ပြီးပါပြီ။');
    }

    // Delete: ပန်းပစ္စည်းဖျက်ရန်
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'ပန်းပစ္စည်းကို ဖျက်ပြီးပါပြီ။');
    }
}