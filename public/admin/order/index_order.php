<?php
session_start();


require_once '../../../config.php';


$query = $conn->prepare('SELECT * FROM `order`');
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include("../include/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("../include/sidebar.php"); ?>
        </aside>
        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Đơn Hàng</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <?php if (isset($orders) && !empty($orders)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="orderTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Mã Đơn Hàng</th>
                                                    <th>Tên Người Nhận</th>
                                                    <th>Địa Chỉ</th>
                                                    <th>Thành Phố</th>
                                                    <th>Huyện</th>
                                                    <th>Số Điện Thoại</th>
                                                    <th>Email</th>
                                                    <th>Tiền</th>
                                                    <th>Xác Nhận Giao Hàng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order) : ?>
                                                    <tr>
                                                        <td><?php echo $order['order_id']; ?></td>
                                                        <td><?php echo $order['order_name']; ?></td>
                                                        <td><?php echo $order['address']; ?></td>
                                                        <td><?php echo $order['city_address']; ?></td>
                                                        <td><?php echo $order['district_address']; ?></td>
                                                        <td><?php echo $order['phone']; ?></td>
                                                        <td><?php echo $order['district_address']; ?></td>
                                                        <td><?php echo $order['cart_total']; ?>.000 vnđ</td>
                                                        <td>
                                                            <form action="delete.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-success" onclick="return confirm('Giao Hàng Thành Công?')">Thành Công</button>
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Giao Hàng Không Thành Công?')">Thất Bại</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <p>Không có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
    <?php include("../include/footer.php"); ?>
</body>

</html>