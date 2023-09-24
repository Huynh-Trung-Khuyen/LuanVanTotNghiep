<?php
// Kiểm tra xem người dùng đã đăng nhập chưa

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Kết nối CSDL (thay thế thông tin kết nối của bạn ở đây)


// Lấy user_id của người dùng đang đăng nhập
$user_id = $_SESSION['user_id'];

// Truy vấn danh sách các sản phẩm mà người dùng đã chiến thắng
$sql = "SELECT pb.product_bid_id, pb.product_bid_name, pb.product_bid_description
        FROM product_bid pb
        WHERE pb.winner_id = :user_id";
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
        <p>Bạn chưa chiến thắng bất kỳ sản phẩm nào.</p>
    <?php endif; ?>
</body>
</html>
