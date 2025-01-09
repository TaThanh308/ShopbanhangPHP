@extends('layouts.app2')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

    <div class="row">
        <div class="col-md-6">
            <h4>Thông tin đơn hàng</h4>
            <p><strong>Tổng giá trị:</strong> {{ $order->total_price }} USD</p>
            <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="col-md-6">
            <h4>Thông tin giao hàng</h4>
            <p><strong>Tên khách hàng:</strong> {{ $order->customer_name }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->customer_address }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
        </div>
    </div>

    <h4 class="mt-4">Sản phẩm trong đơn hàng</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->price }} USD</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price * $item->quantity }} USD</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('order.history') }}" class="btn btn-primary mt-3">Quay lại lịch sử mua hàng</a>
</div>
@endsection
