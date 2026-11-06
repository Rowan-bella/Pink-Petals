<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --pink-primary: #c75d83; --pink-bg: #fff5f7; }
        body { background-color: var(--pink-bg); font-family: system-ui, sans-serif; color: #563b47; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-box { background: white; border-radius: 24px; padding: 40px; width: 100%; max-width: 480px; box-shadow: 0 10px 30px rgba(216, 141, 165, 0.15); border: 1px solid #fce4ec; }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 12px; padding: 12px; font-weight: 600; width: 100%; border: none; }
        .btn-pink:hover { background: #b04c71; color: white; }
    </style>
</head>
<body>
<div class="container text-center py-5">
    <div class="card-box mx-auto text-start">
        <div class="text-center mb-4">
            <h4 class="fw-bold" style="color: #4a2e38;">Reset Password</h4>
            <p class="text-muted small">သင့်အကောင့်ဝင်ထားသည့် Email ကိုထည့်ပါ၊ Password ပြောင်းရန် Link ပို့ပေးပါမည်။</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success small">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus style="border-radius: 10px; padding: 10px;">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-pink">Send Password Reset Link</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill py-2 text-center text-decoration-none small">Back to Login</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>