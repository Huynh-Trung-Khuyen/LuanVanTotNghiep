<?php
session_start();

require_once '../../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../account/login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include("../../partials/include/head.php");
?>

<body class="goto-here">
    <?php
    include("../../partials/include/navbar.php");
    ?>


    <section class="ftco-section ftco-cart">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <h1><a class="nav-link active" href="../../public/cart/checkout.php">Đang Giao Hàng</a></h1>
                </li>
                <li class="nav-item">
                    <h1>&emsp;</h1>
                </li>
                <li class="nav-item">
                    <h1><a class="nav-link" href="../../public/cart/delivered.php">Đã Giao Hàng</a></h1>
                </li>
                <li class="nav-item">
                    <h1>
                <li class="nav-item">
                    <h1>&emsp;</h1>
                </li>
                </li>
                <li class="nav-item">
                    <h1><a class="nav-link disabled" href="../../public/cart/cancelled_delivery.php">Đã Hủy</a></h1>
                </li>

            </ul>
            <div class="row">

                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Tên Người Nhận</th>
                                    <th>Địa Chỉ</th>
                                    <th>Thành Phố</th>
                                    <th>Huyện</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Tổng Số Tiền</th>
                                    <th>Sản Phẩm</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>

                            <?php
                            if (!isset($_SESSION['user_id'])) {
                                echo "Bạn chưa đăng nhập.";
                            } else {
                                $user_id = $_SESSION['user_id'];
                                $query = "SELECT * FROM `order` AS o
                                WHERE o.role = 3 AND o.user_id = :user_id";
                                $stmt = $conn->prepare($query);
                                $stmt->bindParam(':user_id', $user_id);
                                $stmt->execute();
                                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($orders) > 0) {

                                    foreach ($orders as $order) {
                                        include("../../partials/cart/cancelled_delivery_main.php");
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "Bạn có đơn hàng nào bị hủy";
                                }
                            } ?>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php
    include("../../partials/include/footer.php");
    ?>
</body>
</html>
