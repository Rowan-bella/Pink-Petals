<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 👈 Storage facade ကို ထည့်သွင်းရန်

class CategoryController extends Controller
{
    // Category စာရင်းနှင့် Product အရေအတွက်ပြရန်
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Category အသစ်သိမ်းဆည်းရန်
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048' // 👈 Image validation
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath // 👈 Image path ကို သိမ်းဆည်းရန်
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category အသစ် ထည့်သွင်းပြီးပါပြီ။');
    }

    // Category ပြင်ဆင်ရန်
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            // ပုံဟောင်းရှိလျှင် ဖျက်ရန်
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category အချက်အလက် ပြင်ဆင်ပြီးပါပြီ။');
    }

    // Category ဖျက်ရန်
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Category ဖျက်သည့်အခါ ပုံပါ တွဲဖျက်ရန်
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category ကို ဖျက်လိုက်ပါပြီ။');
    }
}