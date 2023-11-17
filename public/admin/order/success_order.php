<?php
session_start();

require_once '../../../config.php';

$items_per_page = 10;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$start_index = ($current_page - 1) * $items_per_page;

$query = $conn->prepare('
    SELECT * FROM `order` WHERE role = 2 LIMIT :start, :items_per_page
');
$query->bindParam(':start', $start_index, PDO::PARAM_INT);
$query->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);

$count_query = $conn->prepare('SELECT COUNT(*) FROM `order` WHERE role = 2');
$count_query->execute();
$total_items = $count_query->fetchColumn();

$total_pages = ceil($total_items / $items_per_page);
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
                            <h1 class="m-0">Đơn Hàng Thành Công</h1>
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
                                                    <th>Ngày Đặt</th>
                                                    <th>Sản Phẩm và Số Lượng</th>
                                                    <th>Địa Chỉ</th>
                                                    <th>Thành Phố</th>
                                                    <th>Huyện</th>
                                                    <th>Số Điện Thoại</th>
                                                    <th>Email</th>
                                                    <th>Tiền</th>
                                                    
                                                    <th>Xóa Đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order) : ?>
                                                    <tr>
                                                        <td><?php echo $order['order_id']; ?></td>
                                                        <td><?php echo $order['order_name']; ?></td>
                                                        <td><?php echo $order['date_ordered']; ?></td>
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
                                                            <form action="delete.php" method="POST">
                                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa Đơn Hàng Này?')">Xóa</button>

                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">
                                                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                                                    <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </nav>

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