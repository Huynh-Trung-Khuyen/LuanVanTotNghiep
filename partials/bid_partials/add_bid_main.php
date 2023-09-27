<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy user_id của người dùng đã đăng nhập (đã xác thực)
    $user_id = $_SESSION['user_id'];

    // Lấy thông tin sản phẩm đấu giá từ biểu mẫu
    $product_bid_name = $_POST['product_bid_name'];
    $product_bid_description = $_POST['product_bid_description'];
    $start_price = $_POST['start_price'];
    $end_time = $_POST['end_time'];

    // Xử lý hình ảnh
    $image_name = '';

    if (!empty($_FILES['product_bid_image']['name'])) {
        $image_name = time() . '_' . $_FILES['product_bid_image']['name'];
        $image_tmp = $_FILES['product_bid_image']['tmp_name'];
        $image_path = '../../public/uploads/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Hình ảnh đã được tải lên thành công, tiếp tục thêm phiên đấu giá
        } else {
            // Lỗi khi tải lên hình ảnh
            $error = 'Lỗi khi tải lên hình ảnh.';
        }
    }

    // Kiểm tra các trường thông tin sản phẩm đấu giá
    if (empty($product_bid_name) || empty($product_bid_description) || empty($start_price) || empty($end_time)) {
        $error = 'Không được để trống!';
    } else {
        // Tính toán real_end_time từ end_time và thời gian hiện tại
        $end_time = date('Y-m-d H:i:s', strtotime($end_time)); // Chuyển đổi end_time sang định dạng datetime

        // Thực hiện thêm phiên đấu giá vào cơ sở dữ liệu với user_id, end_time và tên hình ảnh
        $query = $conn->prepare('
            INSERT INTO product_bid
            (user_id, product_bid_name, product_bid_description, start_price, current_price, end_time, real_end_time, product_bid_image)
            VALUES
            (:user_id, :product_bid_name, :product_bid_description, :start_price, :start_price, :end_time, :real_end_time, :product_bid_image)
        ');

        $query->bindParam(':user_id', $user_id);
        $query->bindParam(':product_bid_name', $product_bid_name);
        $query->bindParam(':product_bid_description', $product_bid_description);
        $query->bindParam(':start_price', $start_price);
        $query->bindParam(':end_time', $end_time);
        $query->bindParam(':real_end_time', $end_time); // Đặt real_end_time ban đầu là end_time
        $query->bindParam(':product_bid_image', $image_name);

        if ($query->execute()) {
            $success = 'Thêm phiên đấu giá thành công!';
        } else {
            $error = 'Thêm phiên đấu giá thất bại!';
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
    <h1>Thêm Phiên Đấu Giá Mới</h1>
    
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product_bid_name">Tên Sản Phẩm Đấu Giá:</label>
        <input type="text" id="product_bid_name" name="product_bid_name" required><br><br>

        <label for="product_bid_description">Mô Tả Sản Phẩm Đấu Giá:</label>
        <textarea id="product_bid_description" name="product_bid_description" required></textarea><br><br>

        <label for="start_price">Giá Khởi Điểm:</label>
        <input type="number" id="start_price" name="start_price" required>.000vnđ<br><br>

        <label for="end_time">Thời Gian Kết Thúc:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br><br>

        <label for="product_bid_image">Hình Ảnh Sản Phẩm Đấu Giá:</label>
        <input type="file" id="product_bid_image" name="product_bid_image" accept="image/*" required><br><br>

        <button type="submit">Thêm Phiên Đấu Giá</button>
    </form>

    <p><a href="../../public/bid/bid.php">Quay lại danh sách sản phẩm</a></p>
</body>
</html>
