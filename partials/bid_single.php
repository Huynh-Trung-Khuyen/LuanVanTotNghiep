<?php
if (isset($_GET['product_bid_id'])) {
    $product_bid_id = $_GET['product_bid_id'];
    $sql = "SELECT pb.*, CONCAT('../public/uploads/', pb.product_bid_image) AS product_image_path, u.fullname AS creator_fullname, w.fullname AS winner_fullname
            FROM product_bid pb
            LEFT JOIN user u ON pb.user_id = u.user_id
            LEFT JOIN user w ON pb.winner_id = w.user_id
            WHERE pb.product_bid_id = :product_bid_id";
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
            } else {
                echo "Đã có lỗi xảy ra khi thêm lượt đặt giá mới.";
            }
        } else {
            echo "Giá đặt phải lớn hơn giá hiện tại.";
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
    <?php
    if (isset($_GET['product_bid_id'])) {
        $product_bid_id = $_GET['product_bid_id'];

        $sql = "SELECT pb.*, 
               CONCAT('../public/uploads/', pb.product_bid_image) AS product_image_path, 
               u.fullname AS creator_fullname, 
               w.fullname AS winner_fullname,
               pb.real_end_time
        FROM product_bid pb
        LEFT JOIN user u ON pb.user_id = u.user_id
        LEFT JOIN user w ON pb.winner_id = w.user_id
        WHERE pb.product_bid_id = :product_bid_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_bid_id', $product_bid_id);
        $stmt->execute();
        $product_bid = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product_bid) {
            echo "Sản phẩm không tồn tại";
        }
        $sql = "SELECT MAX(b.bid_time) AS last_bid_time, MAX(b.bid_price) AS last_bid_price
                FROM bid b
                WHERE b.product_bid_id = :product_bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_bid_id', $product_bid_id);
        $stmt->execute();
        $latestBid = $stmt->fetch(PDO::FETCH_ASSOC);

        include("../partials/bid_single2.php");
    } else {
        echo "Vui lòng cung cấp product_bid_id trong URL.";
    }
    ?>



</body>