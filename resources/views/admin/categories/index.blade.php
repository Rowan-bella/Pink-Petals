<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: system-ui, -apple-system, sans-serif; }
        
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
        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 15px; color: #7a5c68; text-decoration: none;
            border-radius: 10px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: var(--pink-primary); color: white;
        }
        .main-content { margin-left: var(--sidebar-width); padding: 25px; }

        .page-header {
            background: linear-gradient(135deg, #fff0f3 0%, #ffe3e8 100%);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #f8d7e0;
            box-shadow: 0 4px 20px #d88da50d;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 15px #d88da510;
            border: 1px solid #fce4ec;
            transition: transform 0.2s;
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-3px);
            border-color: var(--pink-primary);
        }
        .category-img {
            width: 70px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
        .btn-pink {
            background: var(--pink-primary);
            color: white;
            border-radius: 8px;
        }
        .btn-pink:hover {
            background: #a9446a;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="sidebar-brand">🌸 <span>Pink Petals</span></a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories') }}" class="active"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index')}}"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="{{ route('home')}}" class="text-danger text-decoration-none d-flex align-items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold" style="color: var(--pink-primary);">Categories Management</h2>
                <p class="text-muted mb-0">Manage your flower categories</p>
            </div>
            <!-- Category အသစ်ထည့်ရန် Trigger Button -->
            <button type="button" class="btn btn-pink px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa-solid fa-plus me-1"></i> Add New Category
            </button>
        </div>

        <!-- Categories List Grid -->
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-md-4">
                <div class="category-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        
                           
                        @if($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-img">
    @else
        <div class="category-img bg-light d-flex align-items-center justify-content-center border" style="font-size: 24px;">💐</div>
    @endif
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #563b47;">{{ $category->name }}</h5>
                            <span class="text-muted small">{{ $category->products_count }} products</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-3">{{ $category->description ?? 'No description provided.' }}</p>

                    <!-- CRUD Actions (View Products, Edit, Delete) -->
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <a href="{{ route('admin.category.products', $category->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-eye me-1"></i> View Products
                        </a>

                        <div class="d-flex gap-1">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-pink" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('ဒီ Category ကို ဖျက်မှာ သေချာပါသလား?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modal တစ်ခုချင်းစီအတွက် -->
            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
                                </div>
                                <!-- Edit Image Input -->
                                <div class="mb-3">
                                    <label class="form-label">Category Image</label>
                                    <input type="file" name="image" class="form-control">
                                    @if($category->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $category->image) }}" width="60" class="rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-pink">Update Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Categories တစ်စုံတစ်ရာ မရှိသေးပါ။</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add New Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" style="color: var(--pink-primary);">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                        </div>
                        <!-- Add Image Input -->
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-pink">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>