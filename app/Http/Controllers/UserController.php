<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // User စာရင်းများအားလုံးကို ထုတ်ပြရန်
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // User အသစ်ဖန်တီးသည့် မျက်နှာပြင် (Form) သို့ သွားရန်
    public function create()
    {
        return view('admin.users.create');
    }

    // User အသစ်အချက်အလက်များကို Database သို့ သိမ်းဆည်းရန်
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|exists:roles,name',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Spatie ဖြင့် Role ထည့်ပေးခြင်း
    $user->assignRole($request->role);

    return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
}

    // Edit ပြုလုပ်မည့် မျက်နှာပြင်သို့ သွားရန်
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ပြင်ဆင်ထားသော အချက်အလက်များကို Update လုပ်ရန်
  public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|exists:roles,name',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    // Spatie ဖြင့် Role အဟောင်းဖြုတ်ပြီး အသစ်ဖြင့် အစားထိုးခြင်း
    $user->syncRoles([$request->role]);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
}

    // User ကို ဖျက်ရန်
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}