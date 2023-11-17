<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $totalOrders; ?></h3>
                        <p>Đơn Mua Mới</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="../order/index_order.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo $totalBid; ?></h3>
                        <p>Những Phiên Đấu Giá</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                    <a href="../bid/index_bid.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $totalUsers2; ?></h3>
                        <p>Tài Khoản Khách Hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="../user_business/index_user.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo $totalUsers; ?></h3>
                        <p>Tài Khoản Doanh Nghiệp</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fas fa-building"></i>
                    </div>
                    <a href="../user_business/index_business.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="">
                        <h1 class="m-0">Sơ Đồ Thống Kê Bán Hàng</h1>
                    </div>
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            <p>Tổng Kho: <?php echo number_format($totalRevenue, 0, ',', '.'); ?>.000VNĐ</p>
                            <p>Tổng Lợi Nhuận từ Đơn Hàng: <?php echo number_format($totalProfit, 0, ',', '.'); ?>.000VNĐ</p>
                        </div>
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sơ Đồ Thống Kê Đấu Giá</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <p>Tổng Giá Trị Kho Đấu Giá: <?php echo number_format($totalPurchasePrice, 0, ',', '.'); ?>.000VNĐ</p>
                        <p>Tổng Lợi Nhuận từ Đấu Giá: <?php echo number_format($totalCurrentPrice, 0, ',', '.'); ?>.000VNĐ</p>

                    </div>
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>



    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var monthlyData = <?php echo json_encode($monthlyData); ?>;

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(item => `${item.month}/${item.year}`),
            datasets: [{
                    label: 'Tổng Giá Trị',
                    data: monthlyData.map(item => item.total_value),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Tổng Lợi Nhuận',
                    data: monthlyData.map(item => item.total_profit),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    // Lấy dữ liệu từ PHP và chuyển đổi sang JavaScript
    var monthlyData2 = <?php echo json_encode($monthlyData2); ?>;

    // Tạo biểu đồ cột
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: monthlyData2.map(item => `${item.month}/${item.year}`),
            datasets: [{
                    label: 'Tổng Giá Trị',
                    data: monthlyData2.map(item => item.total_value),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Tổng Lợi Nhuận',
                    data: monthlyData2.map(item => item.total_profit),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>