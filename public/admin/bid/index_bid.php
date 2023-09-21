<?php
session_start();


require_once '../../../config.php';


$sql = "SELECT * FROM product_bid WHERE end_time > NOW()";
$stmt = $conn->prepare($sql);
$stmt->execute();
$product_bids = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include("./head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("./sidebar.php"); ?>
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
                    <?php if (isset($product_bids) && !empty($product_bids)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="orderTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tên Sản Phẩm</th>
                                                    <th>Mô Tả</th>
                                                    <th>Giá Khởi Điểm</th>
                                                    <th>Giá Hiện Tại</th>
                                                    <th>Thời Gian Kết Thúc</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($product_bids as $product) : ?>
                                                    <tr>
                                                        <td><?php echo $product['product_bid_name']; ?></td>
                                                        <td><?php echo $product['product_bid_description']; ?></td>
                                                        <td><?php echo $product['start_price']; ?></td>
                                                        <td><?php echo $product['current_price']; ?></td>
                                                        <td><?php echo $product['end_time']; ?></td>
                                                        <td>
                                                            <form action="delete.php" method="POST">
                                                                <input type="hidden" name="product_bid_id" value="<?php echo $product['product_bid_id']; ?>">
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn Muốn Xóa Phiên Đấu Giá Này?')">Xoá</button>
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
                        <p>Không có phiên đấu giá nào.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
    <?php include("./footer.php"); ?>
</body>

</html>