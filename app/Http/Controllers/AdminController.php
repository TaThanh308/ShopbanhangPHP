<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;  // Thêm OrderItem để truy vấn sản phẩm bán nhiều nhất
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Tổng số lượng tài khoản đã đăng ký
        $totalUsers = User::count();

        // Lấy dữ liệu doanh thu theo ngày
        $dailySales = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Lấy dữ liệu doanh thu theo tháng
        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        // Lấy dữ liệu doanh thu theo năm
        $yearlySales = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get();

        // Lấy sản phẩm bán chạy nhất (dựa trên số lượng đã bán)
        $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5) // Lấy top 5 sản phẩm bán nhiều nhất
            ->with('product') // Load thông tin sản phẩm
            ->get();

        // Trả về view với đầy đủ biến
        return view('admin.dashboard', compact('user', 'totalUsers', 'dailySales', 'monthlySales', 'yearlySales', 'topSellingProducts'));
    }
}
