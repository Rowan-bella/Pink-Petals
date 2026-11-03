<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Admin Dashboard မျက်နှာပြင်အတွက် ဒေတာများ ပို့ပေးရန်
    public function dashboard()
    {
        $totalProducts = Product::count(); 
        $totalStock = Product::sum('stock'); 
        
        $categories = Category::withCount('products')->get();
        $categoryNames = $categories->pluck('name');
        $categoryCounts = $categories->pluck('products_count');

        return view('admin.dashboard', compact('totalProducts', 'totalStock', 'categoryNames', 'categoryCounts'));
    }

    // Categories Card View အတွက် ဒေတာများ ယူဆောင်ရန်
        public function categoryIndex()
    {
        $categories = Category::withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }
    // Read: ပန်းစာရင်းကြည့်ရန်
    public function index()
    {
        $products = Product::with('category')->latest()->get();
            
            

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
   public function byCategory($id)
{
    $category = Category::findOrFail($id);
    $products = Product::with('category')->where('category_id', $id)->latest()->get();

    // Table ဖိုင် (`products.index`) အစား Card ပုံစံ View ဖိုင်သို့ ပို့ပေးရန်
    return view('admin.categories.products', compact('products', 'category'));
}
public function shopIndex(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $selectedCategory = null;

        $query = Product::with('category');

        // Price Filter စစ်ဆေးခြင်း
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

        // Availability Filter စစ်ဆေးခြင်း (stock > 0 ဆိုရင် In Stock, 0 ဆိုရင် Out of Stock ဟု ယူဆပါသည်)
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

        // Price Filter စစ်ဆေးခြင်း
if ($request->has('prices')) {
    $query->where(function($q) use ($request) {
        foreach ($request->prices as $index => $priceRange) {
            // ပထမဆုံး Checkbox အတွက် where သုံးပြီး၊ ကျန်တာတွေအတွက် orWhere သုံးရန်
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

        // Availability Filter စစ်ဆေးခြင်း
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