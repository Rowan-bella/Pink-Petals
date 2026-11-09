<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Pink Petals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
        }

        body {
            background-color: var(--pink-bg);
            background-image: radial-gradient(#f8d7e0 1px, transparent 1px);
            background-size: 20px 20px;
            font-family: system-ui, -apple-system, sans-serif;
            color: #563b47;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 10px 30px rgba(216, 141, 165, 0.15);
            border: 1px solid #fce4ec;
        }

        .form-control-custom {
            border-radius: 12px;
            padding: 12px 15px 12px 45px;
            border: 1px solid #f8d7e0;
            background-color: #fffafb;
        }

        .form-control-custom:focus {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 4px rgba(199, 93, 131, 0.1);
        }

        .input-group-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b08c99;
            z-index: 10;
        }

        .btn-pink {
            background: var(--pink-primary);
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: background 0.2s;
        }

        .btn-pink:hover {
            background: #b04c71;
            color: white;
        }
    </style>
</head>

<body>

<div class="container text-center py-5">
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color: var(--pink-primary);">
            🌸 Pink Petals
        </h3>

        <p class="text-muted small mb-1">FLOWER SHOP</p>

        <p class="text-muted" style="font-size: 0.85rem;">
            Fresh Flowers • Happy Moments • Always
        </p>
    </div>
    <div class="login-card mx-auto text-start">

        <div class="text-center mb-4">
            <h4 class="fw-bold" style="color: #4a2e38;">
                Welcome Back
            </h4>

            <p class="text-muted small">
                Please login to your account
            </p>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ request('product_id') }}">
            <div class="mb-3 position-relative">
                <i class="fa-regular fa-envelope input-group-icon"></i>
                <input
                    type="text"
                    name="email"
                    class="form-control form-control-custom"
                    placeholder="Email address"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    inputmode="email"
                    required >
            </div>
            <div class="mb-3 position-relative">
                <i class="fa-solid fa-lock input-group-icon"></i>

                <input
                    type="password"
                    name="password"
                    class="form-control form-control-custom"
                    placeholder="Password"
                    required >
            </div>
            <div class="mb-3 text-start">
                <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color: #b04c71;">
                    Forgot password?
                </a>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-pink">
                    Login &rarr;
                </button>
                <a
                    href="{{ route('register') }}"
                    class="btn btn-outline-secondary rounded-pill py-2 text-decoration-none text-center"
                    style="border-color: #f8d7e0; color: #7a5c68;" >
                    Create an Account (Register)
                </a>
                <a
                    href="{{ route('home') }}"
                    class="btn btn-outline-secondary rounded-pill py-2 text-decoration-none text-center"
                    style="border-color: #f8d7e0; color: #7a5c68;" >
                    Home
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>