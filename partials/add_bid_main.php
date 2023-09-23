<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        // Lấy user_id của người dùng đăng nhập (đã xác thực)
        $user_id = $_SESSION['user_id']; // Giả định bạn đã lưu user_id trong phiên sau khi đăng nhập

        // Lấy thông tin sản phẩm đấu giá từ biểu mẫu
        $product_bid_name = $_POST['product_bid_name'];
        $product_bid_description = $_POST['product_bid_description'];
        $start_price = $_POST['start_price'];
        $current_price = $start_price; // Ban đầu, current_price bằng start_price
        $end_time = $_POST['end_time'];

        // Xử lý hình ảnh
        $image_name = '';

        if (!empty($_FILES['product_bid_image']['name'])) {
            $image_name = time() . '_' . $_FILES['product_bid_image']['name'];
            $image_tmp = $_FILES['product_bid_image']['tmp_name'];
            $image_path = '../public/uploads/' . $image_name;

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
            // Thực hiện thêm phiên đấu giá vào cơ sở dữ liệu với user_id và tên hình ảnh
            $query = $conn->prepare('
                INSERT INTO product_bid
                (user_id, product_bid_name, product_bid_description, start_price, current_price, end_time, product_bid_image)
                VALUES
                (:user_id, :product_bid_name, :product_bid_description, :start_price, :current_price, :end_time, :product_bid_image)
            ');

            $query->bindParam(':user_id', $user_id);
            $query->bindParam(':product_bid_name', $product_bid_name);
            $query->bindParam(':product_bid_description', $product_bid_description);
            $query->bindParam(':start_price', $start_price);
            $query->bindParam(':current_price', $current_price);
            $query->bindParam(':end_time', $end_time);
            $query->bindParam(':product_bid_image', $image_name);

            if ($query->execute()) {
                $success = 'Thêm phiên đấu giá thành công!';
            } else {
                $error = 'Thêm phiên đấu giá thất bại!';
            }
        }
    }
}

// Tìm user_id trong phiên hoặc token và lưu vào biến session sau khi đăng nhập


$query = $conn->prepare('SELECT * FROM product_bid');
$query->execute();
$product_bids = $query->fetchAll(PDO::FETCH_ASSOC);
?>





<form action="" method="POST" enctype="multipart/form-data">
    <label for="product_bid_name">Tên Sản Phẩm Đấu Giá:</label>
    <input type="text" id="product_bid_name" name="product_bid_name" required><br><br>

    <label for="product_bid_description">Mô Tả Sản Phẩm Đấu Giá:</label>
    <textarea id="product_bid_description" name="product_bid_description" required></textarea><br><br>

    <label for="start_price">Giá Khởi Điểm:</label>
    <input type="number" id="start_price" name="start_price" required><br><br>

    <label for="end_time">Thời Gian Kết Thúc:</label>
    <input type="datetime-local" id="end_time" name="end_time" required><br><br>

    <label for="product_bid_image">Hình Ảnh Sản Phẩm Đấu Giá:</label>
    <input type="file" id="product_bid_image" name="product_bid_image" accept="image/*" required><br><br>

    <button type="submit" class="btn btn-primary py-3 px-4">Thêm Phiên Đấu Giá</button>
</form>