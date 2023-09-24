<?php
// Đảm bảo bạn đã có phiên đăng nhập ở đây, và có user_id của người dùng đã đăng nhập

// Kiểm tra nếu có sự kiện POST từ form để cập nhật trạng thái is_active
if (isset($_POST['update_is_active'])) {
    $product_bid_id = $_POST['product_bid_id'];
    
    // Thực hiện cập nhật trạng thái is_active từ 1 thành 0 cho sản phẩm cụ thể
    $sql = "UPDATE product_bid SET is_active = 0 WHERE product_bid_id = :product_bid_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->bindParam(':user_id', $user_id); // user_id của người dùng đã đăng nhập
    $stmt->execute();
}

// Câu truy vấn SQL để lấy danh sách sản phẩm của người dùng đã đăng nhập
$sql = "SELECT * FROM product_bid WHERE user_id = :user_id";
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
