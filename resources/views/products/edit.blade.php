
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Flower | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff5f7; color: #563b47; }
        .form-card { max-width: 720px; margin: 35px auto; background: white; padding: 32px; border-radius: 20px; box-shadow: 0 8px 30px #d88da51a; }
        .form-control, .form-select { border-radius: 10px; padding: 11px; }
        .btn-pink { background: #c75d83; color: white; }
        .btn-pink:hover { background: #a9446a; color: white; }
        .preview { width: 110px; height: 110px; object-fit: cover; border-radius: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="form-card">
        <h2 class="mb-2">🌷 Edit Flower</h2>
        <p class="text-secondary mb-4">Update your flower details.</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Flower Name *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (MMK) *</label>
                    <input type="number" name="price" class="form-control"
                           min="0" step="0.01"
                           value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock Quantity *</label>
                    <input type="number" name="stock" class="form-control"
                           min="0" step="1"
                           value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            @if($product->image)
                <div class="mb-3">
                    <label class="form-label d-block">Current Image</label>
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="preview" alt="{{ $product->name }}">
                </div>
            @endif

            <div class="mb-4">
                <label class="form-label">Replace Image (Optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-secondary">ဓာတ်ပုံအသစ်မရွေးရင် လက်ရှိပုံကို ဆက်သုံးပါမယ်။</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-pink px-4">Update Flower</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
