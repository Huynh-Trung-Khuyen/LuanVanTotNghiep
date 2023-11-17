<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    $query = $conn->prepare('
        SELECT category_name
        FROM category
        WHERE category_name = :category_name
    ');
    $query->bindValue(':category_name', $category_name);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        $query = $conn->prepare('
        INSERT INTO category (category_name)
        VALUES (:category_name)
    ');
        $query->bindParam(':category_name', $category_name);
        $query->execute();

        $success = 'Thêm danh mục thành công!';
    } else {
        $error = 'Danh mục đã tồn tại!';
    }
}

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM business WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM user WHERE role = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sqlCountUsers = "SELECT COUNT(*) AS total_users FROM user WHERE role = 1";
$stmtCountUsers = $conn->prepare($sqlCountUsers);
$stmtCountUsers->execute();
$resultCountUsers = $stmtCountUsers->fetch(PDO::FETCH_ASSOC);
$totalUsers = $resultCountUsers['total_users'];

$sqlCountUsers2 = "SELECT COUNT(*) AS total_users2 FROM user WHERE role = 2";
$stmtCountUsers2 = $conn->prepare($sqlCountUsers2);
$stmtCountUsers2->execute();
$resultCountUsers2 = $stmtCountUsers2->fetch(PDO::FETCH_ASSOC);
$totalUsers2 = $resultCountUsers2['total_users2'];

$sqlCountOrders = "SELECT COUNT(*) AS total_orders FROM `order`";
$stmtCountOrders = $conn->prepare($sqlCountOrders);
$stmtCountOrders->execute();
$resultCountOrders = $stmtCountOrders->fetch(PDO::FETCH_ASSOC);
$totalOrders = $resultCountOrders['total_orders'];

$sqlCountBid = "SELECT COUNT(*) AS total_bid FROM product_bid";
$stmtCountBid = $conn->prepare($sqlCountBid);
$stmtCountBid->execute();
$resultCountBid = $stmtCountBid->fetch(PDO::FETCH_ASSOC);
$totalBid = $resultCountBid['total_bid'];


// Thống kê bán hàng

$sqlTotalRevenue = "SELECT SUM(purchase_price * quantity) AS total_revenue FROM warehouse";
$stmtTotalRevenue = $conn->prepare($sqlTotalRevenue);
$stmtTotalRevenue->execute();
$resultTotalRevenue = $stmtTotalRevenue->fetch(PDO::FETCH_ASSOC);
$totalRevenue = $resultTotalRevenue['total_revenue'];

$sqlTotalProfit = "SELECT SUM(cart_total) AS total_profit FROM `order`";
$stmtTotalProfit = $conn->prepare($sqlTotalProfit);
$stmtTotalProfit->execute();
$resultTotalProfit = $stmtTotalProfit->fetch(PDO::FETCH_ASSOC);
$totalProfit = $resultTotalProfit['total_profit'];

$sqlMonthlyData = "
    (
        SELECT 
            MONTH(w.input_day) AS month, 
            YEAR(w.input_day) AS year, 
            SUM(w.quantity * w.purchase_price) AS total_value,
            0 AS total_profit
        FROM warehouse w
        WHERE w.expired_date >= CURDATE()
        GROUP BY month, year
    )
    UNION
    (
        SELECT 
            MONTH(o.date_ordered) AS month, 
            YEAR(o.date_ordered) AS year, 
            0 AS total_value,
            SUM(o.cart_total) AS total_profit
        FROM `order` o
        GROUP BY month, year
    )
    ORDER BY year DESC, month DESC
";
$stmtMonthlyData = $conn->prepare($sqlMonthlyData);
$stmtMonthlyData->execute();
$monthlyData = $stmtMonthlyData->fetchAll(PDO::FETCH_ASSOC);

// Thống kê đấu giá

$sqlTotalPurchasePrice = "SELECT SUM(purchase_price) AS total_purchase_price FROM warehouse_bid";
$stmtTotalPurchasePrice = $conn->prepare($sqlTotalPurchasePrice);
$stmtTotalPurchasePrice->execute();
$resultTotalPurchasePrice = $stmtTotalPurchasePrice->fetch(PDO::FETCH_ASSOC);
$totalPurchasePrice = $resultTotalPurchasePrice['total_purchase_price'];


$sqlTotalCurrentPrice = "SELECT SUM(current_price) AS total_current_price FROM product_bid WHERE is_active = 3";
$stmtTotalCurrentPrice = $conn->prepare($sqlTotalCurrentPrice);
$stmtTotalCurrentPrice->execute();
$resultTotalCurrentPrice = $stmtTotalCurrentPrice->fetch(PDO::FETCH_ASSOC);
$totalCurrentPrice = $resultTotalCurrentPrice['total_current_price'];


$sqlMonthlyData2 = "
    (
        SELECT 
            MONTH(wb.input_day) AS month, 
            YEAR(wb.input_day) AS year, 
            SUM(wb.purchase_price) AS total_value,
            0 AS total_profit
        FROM warehouse_bid wb
        WHERE wb.expired_date >= CURDATE()
        GROUP BY month, year
    )
    UNION
    (
        SELECT 
            MONTH(pb.real_end_time) AS month, 
            YEAR(pb.real_end_time) AS year, 
            0 AS total_value,
            SUM(pb.current_price) AS total_profit
        FROM product_bid pb
        WHERE pb.is_active = 3
        GROUP BY month, year
    )
    ORDER BY year DESC, month DESC
";
$stmtMonthlyData2 = $conn->prepare($sqlMonthlyData2);
$stmtMonthlyData2->execute();
$monthlyData2 = $stmtMonthlyData2->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">

<?php
include("../include/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("../include/sidebar.php");
        ?>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Thông Tin Trang Web</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("../main_page/dash_board.php");
            ?>

        </div>
        <?php if (isset($error)) : ?>
            <div style="width: 300px;" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php endif ?>

        <?php if (isset($success)) : ?>
            <div style="width: 300px;" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> <?php echo $success ?>
            </div>
        <?php endif ?>
    </div>
    <!-- ./wrapper -->
    <?php
    include("../include/footer.php");
    ?>
</body>


</html>