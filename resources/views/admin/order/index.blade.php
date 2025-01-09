@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách đơn hàng</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <h4>Trạng thái đơn hàng</h4>
                <ul class="list-group">
                    <li class="list-group-item" onclick="filterOrders('all')" style="cursor: pointer;">Tất cả</li>
                    <li class="list-group-item" onclick="filterOrders('đang chờ xét duyệt')" style="cursor: pointer;">Đang chờ xét duyệt</li>
                    <li class="list-group-item" onclick="filterOrders('đang giao hàng')" style="cursor: pointer;">Đang giao hàng</li>
                    <li class="list-group-item" onclick="filterOrders('hoàn thành')" style="cursor: pointer;">Hoàn thành</li>
                    <li class="list-group-item" onclick="filterOrders('thất bại')" style="cursor: pointer;">Thất bại</li>
                </ul>
            </div>

            <div class="col-md-9">
                <!-- Lặp qua từng nhóm đơn hàng theo trạng thái -->
                @foreach($orders as $status => $statusOrders)
                    <div class="order-status" data-status="{{ $status }}" style="display: none;">
                        <h3>Trạng thái: {{ ucfirst($status) }}</h3>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên người nhận</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Tổng giá trị</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_address }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->total_price }} USD</td>
                                        <td>{{ $order->payment_method == 'cash' ? 'Tiền mặt' : 'Online' }}</td>
                                        <td>
                                            <!-- Dropdown trạng thái -->
                                            <form action="{{ route('order.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="đang chờ xét duyệt" {{ $order->status == 'đang chờ xét duyệt' ? 'selected' : '' }}>Đang chờ xét duyệt</option>
                                                    <option value="đang giao hàng" {{ $order->status == 'đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                                                    <option value="hoàn thành" {{ $order->status == 'hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                                    <option value="thất bại" {{ $order->status == 'thất bại' ? 'selected' : '' }}>Thất bại</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-info">Chi tiết</a>

                                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function filterOrders(status) {
            // Ẩn tất cả các bảng trạng thái
            var orderStatuses = document.querySelectorAll('.order-status');
            orderStatuses.forEach(function(orderStatus) {
                orderStatus.style.display = 'none';
            });

            // Hiển thị bảng tương ứng với trạng thái được chọn
            if (status === 'all') {
                orderStatuses.forEach(function(orderStatus) {
                    orderStatus.style.display = 'block';
                });
            } else {
                var selectedStatus = document.querySelector('.order-status[data-status="' + status + '"]');
                if (selectedStatus) {
                    selectedStatus.style.display = 'block';
                }
            }
        }

        // Hiển thị tất cả đơn hàng khi trang được tải
        window.onload = function() {
            filterOrders('all');
        };
    </script>
@endsection
