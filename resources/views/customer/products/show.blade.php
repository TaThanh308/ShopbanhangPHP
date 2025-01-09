@extends('layouts.app2')

@section('content')
    <div class="container mt-5 product-details-container">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6">
                @if($product->img)
                    <img src="{{ asset('images/' . $product->img) }}" class="img-fluid product-image" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/default.png') }}" class="img-fluid product-image" alt="No Image">
                @endif
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6 product-info">
                <h2 class="product-name">{{ $product->name }}</h2>
                <p class="product-price">Giá: <strong class="text-danger">{{ $product->price }} USD</strong></p>
                <p class="product-description">{{ $product->description }}</p>
                <p class="product-quantity">Còn: <strong>{{ $product->quantity }}</strong> sản phẩm</p>

                <!-- Form thêm sản phẩm vào giỏ hàng -->
                @if($product->quantity > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                    </form>
                @else
                    <button class="btn btn-danger" disabled>Hết hàng</button>
                @endif
            </div>
        </div>
    </div>
@endsection

<!-- CSS -->
<style>
    /* Container tổng thể */
    .product-details-container {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    /* Hình ảnh sản phẩm */
    .product-image {
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease-in-out;
    }

    .product-image:hover {
        transform: scale(1.05); /* Phóng to hình khi hover */
    }

    /* Thông tin sản phẩm */
    .product-name {
        font-size: 36px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .product-price {
        font-size: 28px;
        font-weight: bold;
    }

    .product-description, .product-quantity {
        font-size: 18px;
        color: #555;
    }

    strong {
        color: #333;
        font-weight: bold;
    }

    /* Nút bấm thêm vào giỏ hàng */
    .add-to-cart-btn {
        background-color: #28a745;
        border: none;
        padding: 15px 30px; /* Tăng kích thước padding để nút trông gắn liền hơn */
        font-size: 18px;
        font-weight: bold;
        border-radius: 50px;
        width: auto; /* Thay đổi width cho nút không chiếm toàn bộ */
        display: block;
        margin-top: 20px; /* Thêm khoảng cách giữa nút và thông tin sản phẩm */
        transition: background-color 0.3s ease;
        text-transform: uppercase;
        box-shadow: 0 5px 15px rgba(0, 167, 69, 0.4);
    }

    .add-to-cart-btn:hover {
        background-color: #218838;
    }

    /* Nút khi hết hàng */
    .btn-danger {
        background-color: #ff4d4d;
        border: none;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 50px;
        display: block;
        width: auto;
        margin-top: 20px;
        text-transform: uppercase;
        box-shadow: 0 5px 15px rgba(255, 77, 77, 0.4);
    }

    /* Hiệu ứng glowing cho nút khi hover */
    .add-to-cart-btn:hover, .btn-danger:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    /* Bố cục */
    .product-info {
        margin-top: 20px;
    }
</style>
