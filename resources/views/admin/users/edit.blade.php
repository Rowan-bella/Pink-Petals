<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: system-ui, -apple-system, sans-serif; }
        
        /* Sidebar Layout */
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            background: white;
            border-right: 1px solid #f8d7e0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 24px 20px;
            font-weight: bold;
            color: var(--pink-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0 15px;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #7a5c68;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: var(--pink-primary);
            color: white;
        }
        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #f8d7e0;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px #d88da512;
            max-width: 800px;
            margin: 0 auto;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 11px;
            border-color: #f8d7e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 0.25rem #c75d8325;
        }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 10px; }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="{{ route('admin.orders') }}"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="active"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="{{ route('home') }}" class="text-danger text-decoration-none d-flex align-items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
        <div class="sidebar-footer"></div>
    </div>
    <div class="main-content">
        <div class="form-card">
            <h2 class="mb-2 fw-bold" style="color: var(--pink-primary);"> Edit User / Staff</h2>
            <p class="text-secondary mb-4">Update user account details and roles.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password <small class="text-muted">(စကားဝှက်အသစ်ပြောင်းလိုမှသာ ဖြည့်ပါ)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Role *</label>
                    <select name="role" class="form-select" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-pink px-4 py-2">Update User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>