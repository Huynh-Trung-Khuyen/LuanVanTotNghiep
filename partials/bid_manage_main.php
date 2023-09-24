<?php
if (isset($_POST['update_is_active'])) {
    $product_bid_id = $_POST['product_bid_id'];
    

    $sql = "UPDATE product_bid SET is_active = 0 WHERE product_bid_id = :product_bid_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->bindParam(':user_id', $user_id); 
    $stmt->execute();
}

$sql = "SELECT pb.*, u.username AS winner_username
        FROM product_bid pb
        LEFT JOIN user u ON pb.winner_id = u.user_id
        WHERE pb.user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id); 
$stmt->execute();
$productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="ftco-section">
    <h1>Danh sách sản phẩm của bạn</h1>
    <?php if (!empty($productList)) : ?>
        <ul>
            <?php foreach ($productList as $product) : ?>
                <?php if ($product['is_active'] == 1) : ?>
                    <li>
                        <strong>Sản phẩm: </strong><?php echo $product['product_bid_name']; ?><br>
                        <strong>Mô tả: </strong><?php echo $product['product_bid_description']; ?><br>
                        <strong>Giá khởi điểm: </strong>$<?php echo $product['start_price']; ?><br>
                        <strong>Giá hiện tại: </strong>$<?php echo $product['current_price']; ?><br>
                        <strong>Thời gian kết thúc: </strong><?php echo $product['real_end_time']; ?><br>

                        <?php if ($product['winner_username']) : ?>
                            <strong>Người chiến thắng: </strong><?php echo $product['winner_username']; ?><br>
                        <?php else : ?>
                            <strong>Chưa có người chiến thắng.</strong><br>
                        <?php endif; ?>

                        <form method="post">
                            <input type="hidden" name="product_bid_id" value="<?php echo $product['product_bid_id']; ?>">
                            <input type="submit" name="update_is_active" value="Chuyển trạng thái">
                        </form>

                        <br><br>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Bạn chưa thêm sản phẩm nào.</p>
    <?php endif; ?>

</section>
