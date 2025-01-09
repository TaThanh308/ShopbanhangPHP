@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1>Giỏ hàng của bạn</h1>

        @if(!$cart || $cart->items->isEmpty())
            <p>Giỏ hàng trống.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->product->price }} USD</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="form-control" style="width: 80px; display: inline;">
                                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                </form>
                            </td>
                            <td>{{ $item->product->price * $item->quantity }} USD</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <a href="{{ route('cart.checkout.form') }}" class="btn btn-success">Thanh toán</a>
            </div>
        @endif
    </div>
@endsection
