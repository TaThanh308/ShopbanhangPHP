<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::all()->groupBy('status'); // Nhóm đơn hàng theo trạng thái
        return view('admin.order.index', compact('orders'));
    }
    
    
    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::findOrFail($id); // Lấy đơn hàng theo ID
        return view('admin.order.show', compact('order'));
    }
    public function destroy($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);

        // Xóa đơn hàng
        $order->delete();

        return redirect()->route('order.orders')->with('success', 'Đơn hàng đã được xóa thành công!');
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }


    public function orderHistory()
    {
        // Kiểm tra xem người dùng hiện tại có phải là customer hay không
        if (Auth::user()->role != 'customer') {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        // Lấy danh sách đơn hàng
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // Đếm số lượng sản phẩm trong giỏ hàng
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;

        return view('customer.orders.history', compact('orders', 'cartItemCount'));
    }


    // Xử lý hủy đơn hàng
    public function cancelOrder($id)
    {
        // Lấy đơn hàng dựa trên ID và đảm bảo nó thuộc về người dùng hiện tại
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Kiểm tra trạng thái đơn hàng, chỉ cho phép hủy nếu đơn hàng chưa được giao
        if ($order->status == 'đang giao hàng' || $order->status == 'đã giao hàng') {
            return redirect()->route('order.history')->with('error', 'Bạn không thể hủy đơn hàng này vì nó đang được giao hoặc đã giao!');
        }
        // Lấy các sản phẩm trong đơn hàng và hoàn lại số lượng sản phẩm vào kho
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            $product->increment('quantity', $item->quantity); // Cộng lại số lượng sản phẩm
        }
        // Cập nhật trạng thái đơn hàng thành "đã hủy"
        $order->update(['status' => 'đã hủy']);
        return redirect()->route('order.history')->with('success', 'Đơn hàng đã được hủy và số lượng sản phẩm đã được hoàn lại vào kho!');
    }


    public function showOrder($id)
    {
        $order = Order::with('orderItems.product')->find($id);

        if (!$order || $order->user_id != Auth::id()) {
            return redirect()->route('order.history')->with('error', 'Bạn không có quyền xem chi tiết đơn hàng này.');
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;

        return view('customer.orders.details', compact('order', 'cartItemCount'));
    }

}
