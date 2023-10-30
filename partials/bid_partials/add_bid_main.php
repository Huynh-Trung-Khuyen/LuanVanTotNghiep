<?php

$query = $conn->prepare('SELECT * FROM warehouse_bid');
$query->execute();
$warehouse_bids = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_bid_name = $_POST['product_bid_name'];
    $product_bid_description = $_POST['product_bid_description'];
    $start_price = $_POST['start_price'];
    $end_time = $_POST['end_time'];
    $warehouse_bid_id = $_POST['warehouse_bid_id'];

    $image_name = '';

    if (!empty($_FILES['product_bid_image']['name'])) {
        $image_name = time() . '_' . $_FILES['product_bid_image']['name'];
        $image_tmp = $_FILES['product_bid_image']['tmp_name'];
        $image_path = '../../public/uploads/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            $conn->beginTransaction();

            try {
                $end_time = date('Y-m-d H:i:s', strtotime($end_time));

                $query = $conn->prepare('
                    INSERT INTO product_bid
                    (user_id, product_bid_name, product_bid_description, start_price, current_price, end_time, real_end_time, product_bid_image, warehouse_bid_id)
                    VALUES
                    (:user_id, :product_bid_name, :product_bid_description, :start_price, :start_price, :end_time, :real_end_time, :product_bid_image, :warehouse_bid_id)
                ');

                $query->bindParam(':user_id', $user_id);
                $query->bindParam(':product_bid_name', $product_bid_name);
                $query->bindParam(':product_bid_description', $product_bid_description);
                $query->bindParam(':start_price', $start_price);
                $query->bindParam(':end_time', $end_time);
                $query->bindParam(':real_end_time', $end_time);
                $query->bindParam(':product_bid_image', $image_name);
                $query->bindParam(':warehouse_bid_id', $warehouse_bid_id);

                if ($query->execute()) {
                    $conn->commit();
                    $successMessage = 'Thêm phiên đấu giá thành công!';
                } else {
                    $conn->rollBack();
                    $errorMessage = 'Thêm phiên đấu giá thất bại!';
                }
            } catch (PDOException $e) {
                $conn->rollBack();
                $error = 'Có lỗi xảy ra: ' . $e->getMessage();
            }
        } else {
            $error = 'Lỗi khi tải lên hình ảnh.';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm Phiên Đấu Giá Mới</title>
</head>

<body>
    <div class="container">


        <h1>Thêm Phiên Đấu Giá Mới</h1>

        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <p><?php echo $success; ?></p>
        <?php endif; ?>

        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                <label for="product_bid_name">Tên Sản Phẩm Đấu Giá:</label>
                <input type="text" id="product_bid_name" name="product_bid_name" class="form-control" placeholder="Nhập tên sản phẩm đấu giá" required><br>

                <label for="product_bid_description">Mô Tả Sản Phẩm Đấu Giá:</label>
                <textarea id="product_bid_description" name="product_bid_description" class="form-control" placeholder="Nhập mô tả sản phẩm đấu giá" required></textarea><br>

                <label for="start_price">Giá Khởi Điểm:</label>
                <input type="number" id="start_price" name="start_price" class="form-control" placeholder="Giá khởi điểm" required>

                <label for="end_time">Thời Gian Kết Thúc:</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-control" required><br>

                <label for="warehouse_bid_id">Sản Phẩm Nhập Kho:</label>
                <select name="warehouse_bid_id" id="warehouse_bid_id" class="form-control" required>
                    <?php foreach ($warehouse_bids as $row) : ?>
                        <option value="<?php echo $row['warehouse_bid_id'] ?>"><?php echo $row['imported_bid_name'] ?></option>
                    <?php endforeach ?>
                </select><br><br>

                <label for="product_bid_image">Hình Ảnh Sản Phẩm Đấu Giá:</label>
                <input type="file" id="product_bid_image" name="product_bid_image" class="form-control" accept="image/*" required><br>

                <button type="submit" class="btn btn-primary">Thêm Phiên Đấu Giá</button>
                <p><a href="../../public/bid/bid.php">Quay lại danh sách sản phẩm</a></p>
            </form>
        </div>

        <!-- Success Modal -->
        <?php if (isset($successMessage)) : ?>
            <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thành công</h5>
                            <a href="../../public/bid/add_bid.php" class=" ">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></a>
                        </div>
                        <div class="modal-body">
                            <p><?php echo $successMessage; ?></p>
                            <a href="../../public/bid/bid.php" class="btn btn-primary btn-block">Đi Đến Trang Đấu Giá</a>
                            <a href="../../public/bid/bid_all.php" class="btn btn-secondary btn-block">Xem Các Phiên Đấu Giá Của Tôi</a>
                        </div>
                        <div class="modal-footer">
                            <a href="../../public/bid/add_bid.php" class=" ">Tiếp Tục Thêm Phiên Đấu Giá</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- Error Modal -->
        <?php if (isset($errorMessage)) : ?>
            <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lỗi</h5>
                            <a href="../../public/bid/add_bid.php" class=" ">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></a>
                        </div>
                        <div class="modal-body">
                            <p><?php echo $errorMessage; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


    </div>
</body>

<script>
    <?php if (isset($successMessage)) : ?>
        document.getElementById("successMessage").textContent = "<?php echo $successMessage; ?>";
        $("#successModal").modal("show");
    <?php endif; ?>

    <?php if (isset($errorMessage)) : ?>
        document.getElementById("errorMessage").textContent = "<?php echo $errorMessage; ?>";
        $("#errorModal").modal("show");
    <?php endif; ?>
</script>

</html>