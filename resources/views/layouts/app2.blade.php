<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Đồng Hồ Đeo Tay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(90deg, #ff6a00, #ee0979);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .nav-link {
            color: #fff;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .search-form {
            margin-left: 20px;
        }

        .container {
            margin-top: 20px;
        }

        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.products') }}">
                <i class="fas fa-home"></i> Trang Chủ
            </a>

            <form class="d-flex search-form" action="{{ route('customer.products') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Tìm sản phẩm" aria-label="Search" value="{{ request()->input('query') }}">
                <button class="btn btn-outline-light" type="submit">Tìm</button>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check() && Auth::user()->role == 'customer')
                    <li class="nav-item">
                        <span class="nav-link">Xin chào, {{ Auth::user()->name }}!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn ({{ $cartItemCount }})
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.history') }}">
                            <i class="fas fa-history"></i> Lịch sử mua hàng
                        </a>
                    </li>
                    @endif

                    @if(Auth::check())
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Đăng ký
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <div class="footer text-white pt-5" style="background: linear-gradient(90deg, #ff6a00, #ee0979);">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Về Chúng Tôi</h5>
                    <p>Công ty của Tạ Thành chuyên cung cấp các sản phẩm đồng hồ đeo tay chất lượng cao, cam kết mang đến sự hài lòng cho khách hàng.</p>
                </div>

                <div class="col-md-4">
                    <h5>Liên Kết Nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white"><i class="fas fa-box"></i> Sản phẩm</a></li>
                        <li><a href="#" class="text-white"><i class="fas fa-history"></i> Lịch sử mua hàng</a></li>
                        <li><a href="#" class="text-white"><i class="fas fa-envelope"></i> Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5>Kết Nối Với Chúng Tôi</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-white"><i class="fab fa-facebook-f"></i> Facebook</a>
                        </li>
                        <li>
                            <a href="#" class="text-white"><i class="fab fa-instagram"></i> Instagram</a>
                        </li>
                        <li>
                            <a href="#" class="text-white"><i class="fab fa-twitter"></i> Twitter</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col text-center">
                    <p>&copy; {{ date('Y') }} Công ty của Tạ Thành. Tất cả quyền được bảo lưu.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
