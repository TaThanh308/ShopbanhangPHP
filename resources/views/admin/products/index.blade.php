@extends('layouts.app')

@section('content')
<div class="container mt-5">
<h1>Sản Phẩm</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tạo Sản Phẩm Mới</a>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Form tìm kiếm sản phẩm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request()->query('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-info">Tìm Kiếm</button>
            </div>
        </div>
    </form>

    <!-- Hiển thị danh sách sản phẩm trong bảng -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
               <th>Hình Ảnh Sản Phẩm</th> 
                <th>Tên Sản Phẩm</th>
                <th>Danh Mục</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->img)
                            <img src="{{ asset('images/' . $product->img) }}" alt="{{ $product->name }}" class="img-thumbnail" width="50">
                        @else
                            Không Có Hình Ảnh
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Xem Chi Tiết</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Chỉnh Sửa</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Hiển thị phân trang -->
    {{ $products->links() }}
</div>
@endsection
