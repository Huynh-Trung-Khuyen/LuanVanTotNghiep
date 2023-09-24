<?php


// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Lấy thông tin sản phẩm dựa trên product_bid_id truyền vào từ URL
if (isset($_GET['product_bid_id'])) {
    $product_bid_id = $_GET['product_bid_id'];
    $sql = "SELECT * FROM product_bid WHERE product_bid_id = :product_bid_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem sản phẩm có tồn tại không
    if (!$product) {
        header('Location:../public/bid_detail.php'); // Chuyển hướng về trang danh sách sản phẩm
        exit;
    }

    // Xử lý việc đặt giá
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bid_price = $_POST['bid_price'];
        $user_id = $_SESSION['user_id'];

        // Kiểm tra xem giá đặt có lớn hơn giá hiện tại không
        if ($bid_price > $product['current_price']) {
            // Thực hiện thêm dữ liệu vào bảng "bid"
            $sql = "INSERT INTO bid (product_bid_id, user_id, bid_price) VALUES (:product_bid_id, :user_id, :bid_price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_bid_id', $product_bid_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':bid_price', $bid_price);

            if ($stmt->execute()) {
                // Cập nhật giá hiện tại trong bảng "product_bid"
                $sql = "UPDATE product_bid SET current_price = :bid_price WHERE product_bid_id = :product_bid_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':bid_price', $bid_price);
                $stmt->bindParam(':product_bid_id', $product_bid_id);
                $stmt->execute();
                
                header('Location:../public/bid_detail.php'); // Chuyển hướng về trang danh sách sản phẩm sau khi đặt giá thành công
                exit;
            } else {
                $error_message = "Đã có lỗi xảy ra. Vui lòng thử lại.";
            }
        } else {
            $error_message = "Giá đặt phải lớn hơn giá hiện tại.";
        }
    }
} else {
    header('Location:../public/bid_detail.php'); // Chuyển hướng về trang danh sách sản phẩm nếu không có product_bid_id
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đấu giá sản phẩm</title>
</head>
<body>
    <h1>Đấu giá sản phẩm: <?php echo $product['product_bid_name']; ?></h1>
    
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="bid_price">Giá đặt mới:</label>
        <input type="text" name="bid_price" id="bid_price" required>
        <input type="submit" value="Đặt giá">
    </form>

    <p><a href="index.php">Quay lại danh sách sản phẩm</a></p>
</body>
</html>
