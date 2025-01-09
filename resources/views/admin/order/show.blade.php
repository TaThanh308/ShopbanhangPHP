@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        <p><strong>Tên người nhận:</strong> {{ $order->customer_name }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Tổng giá trị:</strong> {{ $order->total_price }} USD</p>

        <h3>Sản phẩm trong đơn hàng:</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }} USD</td>
                        <td>{{ $item->price * $item->quantity }} USD</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('order.orders') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
    </div>
@endsection
