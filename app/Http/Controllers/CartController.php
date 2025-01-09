<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
  

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id)
    {
        $user = Auth::user();
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        }

        // Kiểm tra nếu người dùng đã có giỏ hàng
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();

        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $cartItem->quantity++;
        } else {
            // Nếu sản phẩm chưa có, tạo mới sản phẩm trong giỏ hàng
            $cartItem = new CartItem([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        $cartItem->save();

        return redirect()->route('cart.view')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function updateCart(Request $request, $id)
{
    $cartItem = CartItem::find($id);

    if (!$cartItem) {
        return redirect()->route('cart.view')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    $product = Product::find($cartItem->product_id);

    // Kiểm tra số lượng tồn kho
    if (!$product || $request->quantity > $product->quantity) {
        return redirect()->route('cart.view')->with('error', 'Không đủ số lượng sản phẩm trong kho! Chỉ còn ' . $product->quantity . ' sản phẩm.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $cartItem->quantity = max(1, $request->quantity); // Đảm bảo số lượng không nhỏ hơn 1
    $cartItem->save();

    return redirect()->route('cart.view')->with('success', 'Cập nhật số lượng sản phẩm thành công!');
}

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cartItem = CartItem::find($id);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.view')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    // Xác thực thông tin người dùng
    protected function validateCheckout(Request $request)
    {
        return $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'customer_phone' => 'required|regex:/^[0-9]{10}$/', // Yêu cầu chính xác 10 chữ số
            'payment_method' => 'required|string',
        ], [
            'customer_phone.regex' => 'Số điện thoại phải gồm 10 chữ số.',
        ]);
    }
    

    // Thanh toán
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();
    
        // Kiểm tra nếu giỏ hàng rỗng
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
    
        // Xác thực thông tin thanh toán
        $this->validateCheckout($request);
    
        // Tính tổng giá trị đơn hàng
        $totalPrice = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        // Bọc logic trong transaction
        $order = DB::transaction(function () use ($request, $totalPrice, $cart) {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_phone' => $request->customer_phone,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
            ]);
    
            // Lưu chi tiết sản phẩm
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
    
                // Trừ số lượng sản phẩm trong kho
                $item->product->decrement('quantity', $item->quantity);
            }
    
            // Xóa giỏ hàng sau khi thanh toán
            $cart->items()->delete();
    
            return $order;  // Trả về đơn hàng vừa tạo
        });
    
        // Chuyển hướng đến trang chi tiết đơn hàng vừa tạo
        return redirect()->route('order.details', ['id' => $order->id])->with('success', 'Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.');
    }
    
    
    public function checkoutForm()
    {
        $user = Auth::user();
    
        // Lấy giỏ hàng từ cơ sở dữ liệu dựa trên user_id và kèm theo sản phẩm
        $cart = Cart::where('user_id', $user->id)->with('products')->first();
        
        // Kiểm tra nếu giỏ hàng rỗng hoặc không có sản phẩm
        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        }
    
        // Đếm số lượng sản phẩm trong giỏ hàng
        $cartItemCount = $cart->products->sum('pivot.quantity');
    
        return view('customer.checkout.checkout', compact('cart', 'cartItemCount'));
    }
    

      // Hiển thị giỏ hàng
      public function viewCart()
      {
          $user = Auth::user();
  
          // Lấy giỏ hàng của người dùng và các sản phẩm trong giỏ
          $cart = Cart::where('user_id', $user->id)->with('items.product')->first();
  
          // Đếm số lượng sản phẩm trong giỏ hàng (nếu có giỏ hàng)
          $cartItemCount = 0;
          if ($user) {
              $cart = Cart::where('user_id', $user->id)->with('items')->first();
              $cartItemCount = $cart ? $cart->items->sum('quantity') : 0;
          }
  
          return view('customer.cart.index', [
              'cart' => $cart,
              'cartItemCount' => $cartItemCount // Truyền số lượng sản phẩm sang view
          ]);
      }
      

}
