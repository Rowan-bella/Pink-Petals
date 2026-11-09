<?php
namespace App\Http\Controllers;
use Carbon\Carbon; 
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count(); 
        $totalStock = Product::sum('stock'); 
        $totalRevenue = Order::whereIn('status', ['delivered', 'approved'])->sum('total_price');
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $salesData = [
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(0))->sum('total_price'), // Mon
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(1))->sum('total_price'), // Tue
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(2))->sum('total_price'), // Wed
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(3))->sum('total_price'), // Thu (ကြာသပတေး - ယနေ့)
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(4))->sum('total_price'), // Fri
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(5))->sum('total_price'), // Sat
            Order::whereIn('status', ['delivered', 'approved'])->whereDate('created_at', (clone $startOfWeek)->addDays(6))->sum('total_price'), // Sun
        ];
        $categories = Category::withCount('products')->get();
        $categoryNames = $categories->pluck('name');
        $categoryCounts = $categories->pluck('products_count');

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalStock', 
            'totalRevenue', 
            'categoryNames', 
            'categoryCounts',
            'salesData'
        ));
    }
    
    public function categoryIndex()
    {
        $categories = Category::withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }
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
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }
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

    public function byCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::with('category')->where('category_id', $id)->latest()->get();

        return view('admin.categories.products', compact('products', 'category'));
    }

    public function shopIndex(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $selectedCategory = null;

        $query = Product::with('category');

        if ($request->has('prices')) {
            $query->where(function($q) use ($request) {
                foreach ($request->prices as $priceRange) {
                    if ($priceRange == 'under_40k') {
                        $q->orWhere('price', '<', 40000);
                    }
                    if ($priceRange == '40k_60k') {
                        $q->orWhereBetween('price', [40000, 60000]);
                    }
                    if ($priceRange == '60k_80k') {
                        $q->orWhereBetween('price', [60000, 80000]);
                    }
                    if ($priceRange == 'over_80k') {
                        $q->orWhere('price', '>', 80000);
                    }
                }
            });
        }

        if ($request->has('availability')) {
            $query->where(function($q) use ($request) {
                foreach ($request->availability as $status) {
                    if ($status == 'in_stock') {
                        $q->orWhere('stock', '>', 0);
                    }
                    if ($status == 'out_stock') {
                        $q->orWhere('stock', '<=', 0);
                    }
                }
            });
        }

        $products = $query->latest()->get();

        return view('shop.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function shopByCategory(Request $request, $id)
    {
        $categories = Category::withCount('products')->get();
        $selectedCategory = Category::findOrFail($id);
        
        $query = Product::with('category')->where('category_id', $id);

        if ($request->has('prices')) {
            $query->where(function($q) use ($request) {
                foreach ($request->prices as $index => $priceRange) {
                    $method = $index === 0 ? 'where' : 'orWhere';

                    if ($priceRange == 'under_40k') {
                        $q->$method('price', '<', 40000);
                    } elseif ($priceRange == '40k_60k') {
                        $q->{$method . 'Between'}('price', [40000, 60000]);
                    } elseif ($priceRange == '60k_80k') {
                        $q->{$method . 'Between'}('price', [60000, 80000]);
                    } elseif ($priceRange == 'over_80k') {
                        $q->$method('price', '>', 80000);
                    }
                }
            });
        }

        if ($request->has('availability')) {
            $query->where(function($q) use ($request) {
                foreach ($request->availability as $status) {
                    if ($status == 'in_stock') {
                        $q->orWhere('stock', '>', 0);
                    }
                    if ($status == 'out_stock') {
                        $q->orWhere('stock', '<=', 0);
                    }
                }
            });
        }

        $products = $query->latest()->get();

        return view('shop.index', compact('products', 'categories', 'selectedCategory'));
    }
}