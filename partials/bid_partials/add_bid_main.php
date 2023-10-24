<?php


$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_bid_name = $_POST['product_bid_name'];
    $product_bid_description = $_POST['product_bid_description'];
    $start_price = $_POST['start_price'];
    $end_time = $_POST['end_time'];
    $supplier_id = $_POST['supplier_id'];

    $image_name = '';

    if (!empty($_FILES['product_bid_image']['name'])) {
        $image_name = time() . '_' . $_FILES['product_bid_image']['name'];
        $image_tmp = $_FILES['product_bid_image']['tmp_name'];
        $image_path = '../../public/uploads/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            $conn->beginTransaction();

            try {
                $check_money_query = $conn->prepare('SELECT money FROM business WHERE user_id = :user_id');
                $check_money_query->bindParam(':user_id', $user_id);
                $check_money_query->execute();
                $money = $check_money_query->fetch(PDO::FETCH_COLUMN);

                if ($money < 200) {
                    $error = 'Số tiền không đủ, vui lòng nạp thêm tiền.';
                } else {
                    $new_money = $money - 200;
                    $update_money_query = $conn->prepare('UPDATE business SET money = :money WHERE user_id = :user_id');
                    $update_money_query->bindParam(':money', $new_money);
                    $update_money_query->bindParam(':user_id', $user_id);
                    $update_money_query->execute();

                    $end_time = date('Y-m-d H:i:s', strtotime($end_time));

                    $query = $conn->prepare('
                        INSERT INTO product_bid
                        (user_id, product_bid_name, product_bid_description, start_price, current_price, end_time, real_end_time, product_bid_image, supplier_id)
                        VALUES
                        (:user_id, :product_bid_name, :product_bid_description, :start_price, :start_price, :end_time, :real_end_time, :product_bid_image, :supplier_id)
                    ');

                    $query->bindParam(':user_id', $user_id);
                    $query->bindParam(':product_bid_name', $product_bid_name);
                    $query->bindParam(':product_bid_description', $product_bid_description);
                    $query->bindParam(':start_price', $start_price);
                    $query->bindParam(':end_time', $end_time);
                    $query->bindParam(':real_end_time', $end_time);
                    $query->bindParam(':product_bid_image', $image_name);
                    $query->bindParam(':supplier_id', $supplier_id);

                    if ($query->execute()) {
                        $conn->commit();
                        $successMessage = 'Thêm phiên đấu giá thành công!';
                    } else {
                        $conn->rollBack();
                        $errorMessage = 'Thêm phiên đấu giá thất bại!';
                    }
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
                <input type="number" id="start_price" name="start_price" class="form-control" placeholder="Giá khởi điểm" required>.000vnđ<br>

                <label for="end_time">Thời Gian Kết Thúc:</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-control" required><br>

                <label for="supplier_id">Nhà Cung Cấp:</label>
                <select name="supplier_id" id="supplier_id" class="form-control" required>
                    <?php foreach ($suppliers as $row) : ?>
                        <option value="<?php echo $row['supplier_id'] ?>"><?php echo $row['supplier_name'] ?></option>
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