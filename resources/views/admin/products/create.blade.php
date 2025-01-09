@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tạo Sản Phẩm</h1>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên Sản Phẩm:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả:</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="quantity">Số Lượng:</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" name="price" id="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="category_id">Danh Mục:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    <!-- Thêm trường ảnh -->
       <div class="form-group">
            <label for="img">Hình Ảnh Sản Phẩm:</label>
            <input type="file" name="img" id="img" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Tạo Mới</button>
    </form>
</div>
@endsection
