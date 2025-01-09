@extends('layouts.app2')

@section('content')
<div class="container mt-5">
    <!-- Quảng cáo (carousel) -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://png.pngtree.com/thumb_back/fw800/back_our/20190620/ourmid/pngtree-classic-quartz-watch-big-black-banner-image_166389.jpg"
                    class="d-block w-100" alt="Quảng cáo đồng hồ 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Giảm giá 30%</h5>
                    <p>Ưu đãi hấp dẫn cho đơn hàng đầu tiên</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTItt1ad488KPfmEEEtqDavMoDAWC4kjVOEWw&s"
                    class="d-block w-100" alt="Quảng cáo đồng hồ 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Mua 1 tặng 1</h5>
                    <p>Áp dụng cho các mẫu đồng hồ cổ điển</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.YGyrE9rZBBYEUTWjj35RRQHaDP?rs=1&pid=ImgDetMain"
                    class="d-block w-100" alt="Quảng cáo đồng hồ 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Khuyến mãi mùa hè</h5>
                    <p>Giảm giá lên tới 50%</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Kết thúc quảng cáo -->

    <h1 class="text-center mb-4">Sản phẩm của chúng tôi</h1>
    @if($products->isEmpty())
        <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa.</p>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                        @if($product->img)
                            <img src="{{ asset('images/' . $product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="No Image">
                        @endif
                        <div class="card-body bg-light">
                            <h5 class="card-title text-success">{{ $product->name }}</p>
                                <p class="card-text">Giá: <strong class="text-danger">{{ $product->price }} USD</strong></p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between">
                            @if($product->quantity > 0)
                                <!-- Form để thêm vào giỏ hàng -->
                                <div class="btn-container">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-custom-success">
                                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- Hiển thị khi sản phẩm hết hàng -->
                                <div class="btn-container">
                                    <button class="btn btn-danger w-100" disabled>Hết hàng</button>
                                </div>
                            @endif
                            <!-- Nút Xem chi tiết -->
                            <div class="btn-container">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-custom btn-custom-primary">
                                    <i class="fas fa-info-circle"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection

<style>
    
    /* Tạo hiệu ứng đẳng cấp cho thẻ sản phẩm */
    .card {
        position: relative;
        transition: all 0.3s ease;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    /* Tạo hiệu ứng nổi bật khi di chuột qua sản phẩm */
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Hình ảnh sản phẩm */
    .card-img-top {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        max-height: 200px;
        object-fit: cover;
    }

    /* Cải tiến phần tiêu đề */
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
    }

    /* Nút bấm */
    .btn-custom {
        font-size: 16px;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 8px;
        color: white; /* Chữ màu trắng */
        transition: all 0.3s ease;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Nút thêm vào giỏ hàng với gradient */
    .btn-custom-success {
        background: linear-gradient(45deg, #28a745, #4caf50); /* Hiệu ứng gradient */
        border: none;
    }

    /* Hiệu ứng khi di chuột qua nút thêm vào giỏ hàng */
    .btn-custom-success:hover {
        background: linear-gradient(45deg, #4caf50, #28a745);
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(76, 175, 80, 0.3);
    }

    /* Nút xem chi tiết với gradient */
    .btn-custom-primary {
        background: linear-gradient(45deg, #007bff, #0056b3); /* Hiệu ứng gradient */
        border: none;
    }

    /* Hiệu ứng khi di chuột qua nút xem chi tiết */
    .btn-custom-primary:hover {
        background: linear-gradient(45deg, #0056b3, #007bff);
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
    }

    /* Cải tiến phần chân card */
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        padding: 10px 15px;
        border-top: none;
    }

    .btn-container {
        flex: 1;
    }

    .btn-container a, .btn-container form {
        width: 100%;
    }

    /* Tạo hiệu ứng nổi bật cho tiêu đề sản phẩm */
    .card-body {
        background-color: #f8f9fa;
        text-align: center;
    }

    .card-body h5 {
        font-size: 20px;
        font-weight: bold;
        color: #2ecc71;
    }

    /* Chỉnh màu cho giá sản phẩm */
    .card-body p {
        color: #e74c3c;
        font-size: 16px;
    }

    /* Phần carousel */
    .carousel-item img {
        max-height: 400px;
        object-fit: cover;
    }

    .carousel-caption h5 {
        font-size: 32px;
        font-weight: bold;
    }

    .carousel-caption p {
        font-size: 18px;
    }

    /* Hiệu ứng glowing border cho các sản phẩm cao cấp */
    .glowing-border {
        border: 3px solid #ff6600;
        animation: glowing 1.5s infinite;
        border-radius: 20px;
    }

    @keyframes glowing {
        0% {
            border-color: #ff6600;
        }
        50% {
            border-color: #ffffff;
        }
        100% {
            border-color: #ff6600;
        }
    }
</style>|