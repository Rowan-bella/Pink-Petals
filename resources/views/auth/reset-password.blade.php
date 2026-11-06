<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Password | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h4 class="fw-bold" style="color: #4a2e38;">Create New Password</h4>
            <p class="text-muted small">စကားဝှက်အသစ်အမျိုးအစားကို နှစ်ကြိမ်တိတိ ရိုက်ထည့်ပါ။</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger small">
                @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $request->email }}" required style="border-radius: 10px; padding: 10px;">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">New Password</label>
                <input type="password" name="password" class="form-control" required style="border-radius: 10px; padding: 10px;">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required style="border-radius: 10px; padding: 10px;">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-pink">Reset Password</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>