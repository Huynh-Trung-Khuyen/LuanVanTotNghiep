<?php
session_start();

require_once '../../../config.php';

// Truy vấn để lấy thông tin từ bảng order với điều kiện role là 1
$query = $conn->prepare('SELECT * FROM `order` WHERE role = 1');
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
                                                    <th>Sản Phẩm và Số Lượng</th>
                                                    <th>Địa Chỉ</th>
                                                    <th>Thành Phố</th>
                                                    <th>Huyện</th>
                                                    <th>Số Điện Thoại</th>
                                                    <th>Email</th>
                                                    <th>Tiền</th>
                                                    <th>Giao Hàng Thành Công</th>
                                                    <th>Hủy Đơn</th>
                                                    <th>Xóa Đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order) : ?>
                                                    <tr>
                                                        <td><?php echo $order['order_id']; ?></td>
                                                        <td><?php echo $order['order_name']; ?></td>
                                                        <td>
                                                            <?php
                                                            $query = "SELECT p.product_name, op.quantity_of_products
                                                                      FROM ordered_products AS op
                                                                      INNER JOIN product AS p ON op.product_id = p.product_id
                                                                      WHERE op.order_id = :order_id";
                                                            $stmt = $conn->prepare($query);
                                                            $stmt->bindParam(':order_id', $order['order_id']);
                                                            $stmt->execute();
                                                            $products_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            $product_info_strings = [];
                                                            foreach ($products_info as $product_info) {
                                                                $product_name = $product_info['product_name'];
                                                                $quantity = $product_info['quantity_of_products'];
                                                                $product_info_strings[] = "$quantity kg $product_name";
                                                            }
                                                            echo implode(', ', $product_info_strings);
                                                            ?>
                                                        </td>
                                                        <td><?php echo $order['address']; ?></td>
                                                        <td><?php echo $order['city_address']; ?></td>
                                                        <td><?php echo $order['district_address']; ?></td>
                                                        <td><?php echo $order['phone']; ?></td>
                                                        <td><?php echo $order['email_address']; ?></td>
                                                        <td><?php echo $order['cart_total']; ?>.000 vnđ</td>

                                                        <td>
                                                            <form action="change_role1.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận giao hàng thành công')">Thành Công</button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="change_role2.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận hủy đơn hàng?')">Hủy</button>
                                                            </form>
                                                        </td>
                                                        
                                                        <td>
                                                            <form action="delete.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa Đơn Hàng Này?')">Xóa</button>

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
                        <p>Không có đơn hàng nào</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
    <?php include("../include/footer.php"); ?>
</body>

</html>
