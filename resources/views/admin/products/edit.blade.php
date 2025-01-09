@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Chỉnh Sửa Sản Phẩm</h1>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên Sản Phẩm:</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả:</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="quantity">Số Lượng:</label>
            <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" name="price" id="price" value="{{ $product->price }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="category_id">Danh Mục:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Thêm trường ảnh -->
        <div class="form-group">
            <label for="img">Hình Ảnh Sản Phẩm:</label>
            <input type="file" name="img" id="img" class="form-control" accept="image/*">
             Hiển thị ảnh hiện tại
            @if($product->img)
                <img src="{{ asset('images/' . $product->img) }}" alt="Hình Ảnh Sản Phẩm" class="img-thumbnail mt-2" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-success">Cập Nhật</button>
    </form>
</div>
@endsection
