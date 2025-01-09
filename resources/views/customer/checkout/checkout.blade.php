@extends('layouts.app2')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Thanh toán</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!$cart || $cart->items->isEmpty())
        <p class="text-center">Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>
    @else
        <form action="{{ route('cart.processCheckout') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <label for="customer_name" class="form-label">Tên người nhận</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="customer_phone" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                @error('customer_phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="customer_address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
            </div>

            <h4 class="mt-4">Hình thức thanh toán</h4>
            <div class="form-group mb-3">
                <label for="payment_method">Chọn hình thức thanh toán</label>
                <select id="payment_method" class="form-control" name="payment_method" required>
                    <option value="cash">Thanh toán bằng tiền mặt</option>
                    <option value="card">Thanh toán Online</option>
                </select>
            </div>

            <div id="qrCodeSection" class="mb-3" style="display:none;">
                <h5 class="mt-4">Thanh toán Online</h5>
                <p>Quét mã QR dưới đây để thanh toán:</p>
                <div id="qrCode" style="text-align: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=YOUR_PAYMENT_LINK_HERE&size=200x200" alt="QR Code">
                </div>
            </div>

            <h4 class="mt-4">Thông tin đơn hàng</h4>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->product->price, 2) }} USD</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->product->price * $item->quantity, 2) }} USD</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tổng:</strong></td>
                        <td><strong>{{ number_format($cart->items->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }} USD</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-start mb-3">
                <a href="{{ route('cart.view') }}" class="btn btn-secondary">Quay lại Giỏ hàng</a>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
            </div>
        </form>
    @endif
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const qrCodeSection = document.getElementById('qrCodeSection');
        if (this.value === 'card') {
            qrCodeSection.style.display = 'block'; // Hiển thị mã QR
        } else {
            qrCodeSection.style.display = 'none'; // Ẩn mã QR
        }
    });
</script>

<style>
/* Định dạng chung cho toàn bộ form */
form {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

/* Cải tiến tiêu đề */
h1, h4 {
    font-weight: bold;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

/* Định dạng cho input và textarea */
input[type="text"], input[type="tel"], textarea, select {
    border: 2px solid #ced4da;
    border-radius: 8px;
    padding: 10px;
    font-size: 16px;
    width: 100%;
    transition: border-color 0.3s;
}

input[type="text"]:focus, input[type="tel"]:focus, textarea:focus, select:focus {
    border-color: #28a745;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.2);
    outline: none;
}

/* Cải tiến bảng thông tin sản phẩm */
table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 12px;
    text-align: left;
}

table th {
    background-color: #2c3e50;
    color: white;
    text-transform: uppercase;
}

table td {
    font-size: 14px;
    border: 1px solid #ddd;
}

/* Định dạng cho nút thanh toán */
button.btn-success {
    background-color: #28a745;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

button.btn-success:hover {
    background-color: #218838;
}
</style>

@endsection
