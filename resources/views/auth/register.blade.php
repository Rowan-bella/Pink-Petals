<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Pink Petals</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
        }
        body {
            background-color: var(--pink-bg);
            font-family: system-ui, -apple-system, sans-serif;
            color: #563b47;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
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
            padding: 12px 15px;
            border: 1px solid #f8d7e0;
            background-color: #fffafb;
        }
        .form-control-custom:focus {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 0.25rem rgba(199, 93, 131, 0.15);
        }
        .btn-pink {
            background: var(--pink-primary);
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
        }
        .btn-pink:hover {
            background: #b04c71;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1" style="color: var(--pink-primary);">🌸 Pink Petals</h3>
            <p class="text-muted small">Create a new user account</p>
        </div>

        <div class="register-card mx-auto text-start">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Field -->
                <div class="mb-3">
                    <label class="form-label small text-muted">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-custom" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label class="form-label small text-muted">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-custom" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label class="form-label small text-muted">Password (at least 8 characters)</label>
                    <input type="password" name="password" class="form-control form-control-custom" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4">
                    <label class="form-label small text-muted">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-custom" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-pink mb-3">Register &rarr;</button>
                <div class="d-grid gap-2">
                 <a
                    href="{{ route('home') }}"
                    class="btn btn-outline-secondary rounded-pill py-2 text-decoration-none text-center"
                    style="border-color: #f8d7e0; color: #7a5c68;"
                >
                    Home
                </a>
                </div><br>
                <!-- Login Redirect Link -->
                <div class="text-center small">
                    <span class="text-muted">Already have an account?</span> 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--pink-primary);">Login here</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>