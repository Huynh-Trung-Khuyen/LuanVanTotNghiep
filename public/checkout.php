<?php
session_start();

require_once '../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../public/account/login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vegefoods</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/css/animate.css">

    <link rel="stylesheet" href="../css/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../css/css/magnific-popup.css">

    <link rel="stylesheet" href="../css/css/aos.css">

    <link rel="stylesheet" href="../css/css/ionicons.min.css">

    <link rel="stylesheet" href="../css/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../css/css/jquery.timepicker.css">


    <link rel="stylesheet" href="../css/css/flaticon.css">
    <link rel="stylesheet" href="../css/css/icomoon.css">
    <link rel="stylesheet" href="../css/css/style.css">
</head>

<body class="goto-here">
    <?php
    include("../partials/navbar.php");
    ?>


    <section class="ftco-section ftco-cart">
        <div class="container">
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
                                    <th>Email</th>
                                    <th>Tổng Số Tiền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>

                            <?php
                            if (!isset($_SESSION['user_id'])) {
                                echo "Bạn chưa đăng nhập.";
                            } else {
                                $user_id = $_SESSION['user_id'];

                                // Truy vấn CSDL để lấy danh sách đơn hàng của người đăng nhập
                                $query = "SELECT * FROM `order` WHERE user_id = :user_id";
                                $stmt = $conn->prepare($query);
                                $stmt->bindParam(':user_id', $user_id);
                                $stmt->execute();
                                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($orders) > 0) {

                                    foreach ($orders as $order) {
                                        include("../partials/checkout_main.php");
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "Bạn chưa có đơn hàng nào.";
                                }
                            } ?>

                        </table>
                    </div>
                </div>
            </div>



        </div>
    </section>



    <?php
    include("../partials/footer.php");
    ?>
</body>

</html>