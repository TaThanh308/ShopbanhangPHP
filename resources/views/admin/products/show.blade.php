@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Chi Tiết Sản Phẩm</h1>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Quay Lại Danh Sách Sản Phẩm</a>

    <div class="card">
        <div class="card-header">
            {{ $product->name }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Danh Mục: {{ $product->category->name }}</h5>
            <p class="card-text"><strong>Mô Tả:</strong> {{ $product->description }}</p>
            <p class="card-text"><strong>Số Lượng:</strong> {{ $product->quantity }}</p>
            <p class="card-text"><strong>Giá:</strong> {{ number_format($product->price, 2) }} đ</p>
            <!-- Thêm chi tiết sản phẩm khác nếu cần -->

            <!-- Tùy chọn: Thêm các nút hành động như Chỉnh Sửa hoặc Xóa -->
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Chỉnh Sửa</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
            </form>
        </div>
    </div>
</div>
@endsection
