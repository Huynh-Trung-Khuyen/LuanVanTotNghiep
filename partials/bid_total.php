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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Các sản phẩm đã chiến thắng</title>
</head>
<body>
    <h1>Các sản phẩm bạn đã chiến thắng</h1>
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
        <p>Bạn chưa chiến thắng bất kỳ sản phẩm nào hoặc tất cả các sản phẩm bạn chiến thắng đều có is_active = 1.</p>
    <?php endif; ?>
</body>
</html>
