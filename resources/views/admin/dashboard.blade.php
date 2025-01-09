@extends('layouts.app')

@section('content')
    <div class="container dashboard-container">
        <center><h1>Xin chào Admin {{ $user->name }}</h1></center> 

        <h2 class="mt-4">Tổng số lượng tài khoản đã đăng ký: {{ $totalUsers }}</h2>
        <div class="mt-5 chart-container">
    <h3>Sản phẩm bán chạy nhất</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Tổng số lượng bán</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topSellingProducts as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->total_sold }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Doanh thu theo ngày -->
        <div class="mt-5 chart-container">
            <h3>Doanh thu bán hàng theo ngày</h3>
            <canvas id="dailySalesChart"></canvas>

            <!-- Bảng doanh thu theo ngày -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Doanh thu (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySales as $sale)
                        <tr>
                            <td>{{ $sale->date }}</td>
                            <td>{{ number_format($sale->total_sales, 2) }} USD</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Doanh thu theo tháng -->
        <div class="mt-5 chart-container">
            <h3>Doanh thu bán hàng theo tháng</h3>
            <canvas id="monthlySalesChart"></canvas>

            <!-- Bảng doanh thu theo tháng -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Tháng/Năm</th>
                        <th>Doanh thu (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlySales as $sale)
                        <tr>
                            <td>{{ $sale->month }}/{{ $sale->year }}</td>
                            <td>{{ number_format($sale->total_sales, 2) }} USD</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Doanh thu theo năm -->
        <div class="mt-5 chart-container">
            <h3>Doanh thu bán hàng theo năm</h3>
            <canvas id="yearlySalesChart"></canvas>

            <!-- Bảng doanh thu theo năm -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Năm</th>
                        <th>Doanh thu (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($yearlySales as $sale)
                        <tr>
                            <td>{{ $sale->year }}</td>
                            <td>{{ number_format($sale->total_sales, 2) }} USD</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Doanh thu theo ngày
        const dailySalesLabels = {!! json_encode($dailySales->pluck('date')->toArray()) !!};
        const dailySalesData = {!! json_encode($dailySales->pluck('total_sales')->toArray()) !!};
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(dailySalesCtx, {
            type: 'line',
            data: {
                labels: dailySalesLabels,
                datasets: [{
                    label: 'Doanh thu (USD)',
                    data: dailySalesData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                    }
                },
            },
        });

        // Doanh thu theo tháng
        const monthlySalesLabels = {!! json_encode($monthlySales->map(function($sale) {
            return $sale->month . '/' . $sale->year;
        })->toArray()) !!};
        const monthlySalesData = {!! json_encode($monthlySales->pluck('total_sales')->toArray()) !!};
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlySalesCtx, {
            type: 'bar',
            data: {
                labels: monthlySalesLabels,
                datasets: [{
                    label: 'Doanh thu (USD)',
                    data: monthlySalesData,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                    }
                },
            },
        });

        // Doanh thu theo năm
        const yearlySalesLabels = {!! json_encode($yearlySales->pluck('year')->toArray()) !!};
        const yearlySalesData = {!! json_encode($yearlySales->pluck('total_sales')->toArray()) !!};
        const yearlySalesCtx = document.getElementById('yearlySalesChart').getContext('2d');
        new Chart(yearlySalesCtx, {
            type: 'pie',
            data: {
                labels: yearlySalesLabels,
                datasets: [{
                    label: 'Doanh thu (USD)',
                    data: yearlySalesData,
                    backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    </script>

    <style>
        .dashboard-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            position: relative;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        canvas {
            max-width: 100%;
            height: 300px !important; /* Đảm bảo chiều cao cố định cho các biểu đồ */
        }
    </style>
@endsection
