<?php
// Kiểm tra và cập nhật giá cuối cùng cho các phiên đấu giá đã kết thúc
$current_time = date('Y-m-d H:i:s');
$sql = "SELECT * FROM product_bid WHERE real_end_time <= :current_time";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':current_time', $current_time);
$stmt->execute();
$expired_bids = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($expired_bids as $expired_bid) {
    $sql = "SELECT MAX(bid_price) AS last_bid_price, user_id FROM bid WHERE product_bid_id = :product_bid_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $expired_bid['product_bid_id']);
    $stmt->execute();
    $last_bid = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($last_bid['last_bid_price'] > $expired_bid['current_price']) {
        $sql = "UPDATE product_bid SET current_price = :last_bid_price, user_id = :user_id WHERE product_bid_id = :product_bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':last_bid_price', $last_bid['last_bid_price']);
        $stmt->bindParam(':user_id', $last_bid['user_id']);
        $stmt->bindParam(':product_bid_id', $expired_bid['product_bid_id']);
        $stmt->execute();
    }
}

// Câu truy vấn SQL để lấy danh sách sản phẩm đang được đấu giá
$sql = "SELECT 
            pb.product_bid_id, 
            pb.product_bid_name, 
            pb.product_bid_description, 
            pb.start_price, 
            pb.current_price, 
            pb.real_end_time,  -- Sử dụng real_end_time thay vì end_time
            u1.username AS seller_username, 
            b1.bid_price AS last_bid_price, 
            u2.username AS last_bidder_username 
        FROM product_bid pb
        LEFT JOIN user u1 ON pb.user_id = u1.user_id
        LEFT JOIN (
            SELECT 
                b.product_bid_id, 
                b.bid_price, 
                b.user_id 
            FROM bid b
            WHERE b.bid_id IN (
                SELECT MAX(bid_id) 
                FROM bid 
                GROUP BY product_bid_id
            )
        ) b1 ON pb.product_bid_id = b1.product_bid_id
        LEFT JOIN user u2 ON b1.user_id = u2.user_id
        WHERE pb.real_end_time > NOW()"; // Sử dụng real_end_time thay vì end_time

$stmt = $conn->prepare($sql);
$stmt->execute();
$productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<section class="ftco-section">
    <h1>Danh sách sản phẩm đang được đấu giá</h1>
    <?php if (!empty($productList)) : ?>
        <ul>
            <?php foreach ($productList as $product) : ?>
                <li>
                    <strong>Sản phẩm: </strong><?php echo $product['product_bid_name']; ?><br>
                    <strong>Mô tả: </strong><?php echo $product['product_bid_description']; ?><br>
                    <strong>Giá khởi điểm: </strong>$<?php echo $product['start_price']; ?><br>
                    <strong>Giá hiện tại: </strong>$<?php echo $product['current_price']; ?><br>
                    <strong>Thời gian kết thúc: </strong><?php echo $product['real_end_time']; ?><br>
                    <strong>Người thêm đấu giá: </strong><?php echo $product['seller_username']; ?><br>
                    <strong>Người ra giá cuối cùng: </strong><?php echo $product['last_bidder_username']; ?><br>
                    <strong>Giá ra cuối cùng: </strong>$<?php echo $product['last_bid_price']; ?><br>
                    <a href='../public/bid_detail.php?product_bid_id=<?php echo $product['product_bid_id']; ?>'>Đặt giá</a><br><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Không có sản phẩm đang được đấu giá.</p>
    <?php endif; ?>

</section>
