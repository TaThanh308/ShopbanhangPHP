<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $search = $request->query('search');
    
        // Nếu có từ khóa tìm kiếm, lọc sản phẩm theo tên
        if ($search) {
            $products = Product::where('name', 'like', "%{$search}%")->paginate(10);
        } else {
            // Nếu không có từ khóa tìm kiếm, trả về toàn bộ sản phẩm
            $products = Product::paginate(10);
        }
    
        return view('admin.products.index', compact('products'));
    }
    

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Xác thực ảnh
    ]);

    // Xử lý ảnh nếu có
    $imageName = null;
    if ($request->hasFile('img')) {
        $imageName = time() . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $imageName);
    }

    // Tạo sản phẩm
    Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'category_id' => $request->category_id,
        'img' => $imageName, // Lưu tên ảnh
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Xác thực ảnh
    ]);

    // Xử lý ảnh nếu có
    if ($request->hasFile('img')) {
        // Xóa ảnh cũ nếu có
        if ($product->img && file_exists(public_path('images/' . $product->img))) {
            unlink(public_path('images/' . $product->img));
        }
        
        // Lưu ảnh mới
        $imageName = time() . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $imageName);
        $product->img = $imageName;
    }// Cập nhật thông tin sản phẩm
    $product->update([
        'name' => $request->name,
        'description' => $request->description,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'category_id' => $request->category_id,
        'img' => $product->img, // Cập nhật tên ảnh nếu có
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Fetch the product or show a 404 error if not found
        return view('admin.products.show', compact('product'));
    }

    public function indexUser(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ query string
        $query = $request->input('query');
        
        // Kiểm tra nếu có từ khóa tìm kiếm thì lọc sản phẩm theo từ khóa, nếu không thì lấy tất cả sản phẩm
        if ($query) {
            $products = Product::where('name', 'like', '%' . $query . '%')
                                ->orWhere('description', 'like', '%' . $query . '%')
                                ->get();
        } else {
            $products = Product::all();
        }
        
        // Lấy user hiện tại
        $user = Auth::user();
    
        // Lấy giỏ hàng của user hiện tại và đếm số lượng sản phẩm trong giỏ hàng
        $cartItemCount = 0;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->with('items')->first();
            $cartItemCount = $cart ? $cart->items->sum('quantity') : 0;
        }
    
        // Trả về view và truyền danh sách sản phẩm cùng số lượng sản phẩm trong giỏ hàng
        return view('customer.products.indexUser', compact('products', 'cartItemCount'));
    }
    
    public function showCustomer($id)
{
    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('customer.products')->with('error', 'Sản phẩm không tồn tại!');
    }
    $cart = Cart::where('user_id', Auth::id())->first();
    $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;
    return view('customer.products.show', compact('product','cartItemCount'));
}

}