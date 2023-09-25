<?php

$user_id = $_SESSION['user_id'];


$sql = "SELECT pb.product_bid_id, pb.product_bid_name, pb.product_bid_description
        FROM product_bid pb
        WHERE pb.winner_id = :user_id AND pb.is_active = 0";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$wonProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body>
    <h1>Các sản phẩm đã được xác nhận thanh toán</h1>
    <?php if (!empty($wonProducts)) : ?>
        <ul>
            <?php foreach ($wonProducts as $product) : ?>
                <li>
                    <strong>Sản phẩm: </strong><?php echo $product['product_bid_name']; ?><br>
                    <strong>Mô tả: </strong><?php echo $product['product_bid_description']; ?><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Bạn chưa có bất kỳ sản phẩm.</p>
    <?php endif; ?>
</body>
</html>
