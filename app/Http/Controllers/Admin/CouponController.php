<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_spend' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend ?? 0,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'ကူပွန်အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။');
    }

   public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_spend' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend ?? 0,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'ကူပွန်အချက်အလက်များကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'ကူပွန်ကို ဖျက်လိုက်ပါပြီ။');
    }
}