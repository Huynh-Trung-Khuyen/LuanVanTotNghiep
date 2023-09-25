<?php
if (isset($_GET['product_bid_id'])) {
    $product_bid_id = $_GET['product_bid_id'];
    $sql = "SELECT * FROM product_bid WHERE product_bid_id = :product_bid_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Sản phẩm không tồn tại";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bid_price = $_POST['bid_price'];
        $user_id = $_SESSION['user_id'];

    
        $sql = "UPDATE product_bid SET winner_id = :user_id WHERE product_bid_id = :product_bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_bid_id', $product_bid_id);
        if ($stmt->execute()) {
            echo "Đặt giá thành công và bạn là người chiến thắng.";
        } else {
            $error_message = "Đã có lỗi xảy ra khi cập nhật winner_id.";
        }

        if ($bid_price > $product['current_price']) {
            $sql = "INSERT INTO bid (product_bid_id, user_id, bid_price) VALUES (:product_bid_id, :user_id, :bid_price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_bid_id', $product_bid_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':bid_price', $bid_price);

            if ($stmt->execute()) {
                $sql = "UPDATE product_bid SET current_price = :bid_price WHERE product_bid_id = :product_bid_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':bid_price', $bid_price);
                $stmt->bindParam(':product_bid_id', $product_bid_id);
                $stmt->execute();
                echo "Đặt giá thành công.";
            } else {
                $error_message = "Đã có lỗi xảy ra khi thêm lượt đặt giá mới.";
            }
        } else {
            $error_message = "Giá đặt phải lớn hơn giá hiện tại.";
        }
    }
} else {
    echo "Không có phiên đấu giá.";
    exit;
}


?>



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

    <p><a href="../public/bid_detail.php">Quay lại danh sách sản phẩm</a></p>
</body>

