<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} Collection | Pink Petals Admin</title>
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

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }

        /* Product Grid Card Styling */
        .product-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 20px #d88da512;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .flower-photo { 
            width: 100%; 
            height: 160px; 
            object-fit: cover; 
            border-radius: 12px; 
        }
        .price { color: var(--pink-primary); font-size: 18px; font-weight: 700; }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 8px; font-size: 0.8rem; }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
        .btn-delete { background: #fa5252; color: white; border-radius: 8px; font-size: 0.8rem; }
        .btn-delete:hover { background: #e03131; color: white; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories') }}" class="active"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index')}}"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="{{ route('home')}}" class="text-danger text-decoration-none d-flex align-items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a><li>

        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: var(--pink-primary);">🌸 {{ $category->name }} Collection</h2>
            <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary px-3 py-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>

        <!-- တစ်တန်းကို ၄ ခုပေါ်စေရန် col-md-3 ကို အသုံးပြုထားပါသည် -->
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="flower-photo mb-3" alt="{{ $product->name }}">
                            @else
                                <div class="flower-photo bg-light d-flex align-items-center justify-content-center mb-3" style="font-size: 40px;">💐</div>
                            @endif

                            <p class="text-uppercase text-secondary small fw-semibold mb-1" style="font-size: 0.7rem;">PINK PETALS COLLECTION</p>
                            <h6 class="fw-bold mb-2" style="color: #563b47;">{{ $product->name }}</h6>

                            <p class="mb-2 small">
                                Category: 
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.75rem;">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            </p>

                            <p class="price mb-2">{{ number_format($product->price, 0) }} MMK</p>

                            <p class="mb-2">
                                @if($product->stock > 0)
                                    <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size: 0.7rem;">{{ $product->stock }} available</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1" style="font-size: 0.7rem;">Out of stock</span>
                                @endif
                            </p>

                            <p class="text-secondary small mb-3" style="font-size: 0.8rem;">
                                {{ $product->description ?: 'A beautiful flower arrangement.' }}
                            </p>
                        </div>

                        <!-- အောက်ခြေခလုတ်များ (Edit နှင့် Delete) -->
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-pink flex-grow-1 py-1 text-center">
                                <i class="fa-solid fa-pen me-1"></i> Edit
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ဒီပစ္စည်းကို ဖျက်မှာ သေချာပါသလား?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete py-1 px-2" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card text-center py-5 border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">ဤ Category ထဲတွင် ပစ္စည်းအချက်အလက် တစ်စုံတစ်ရာ မရှိသေးပါ။</h5>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>