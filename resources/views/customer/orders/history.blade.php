@extends('layouts.app2')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Lịch sử mua hàng</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($orders->isEmpty())
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Đơn hàng</th>
                    <th>Tổng giá trị</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt hàng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->total_price }} USD</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('order.details', $order->id) }}" class="btn btn-info">Xem chi tiết</a>
                            
                            @if($order->status != 'đang giao hàng')
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">Hủy</button>
                                </form>
                            @else
                                <button class="btn btn-secondary" disabled>Không thể hủy</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
