<?php
if (isset($_POST['update_is_active'])) {
    $product_bid_id = $_POST['product_bid_id'];


    $sql = "UPDATE product_bid SET is_active = 0 WHERE product_bid_id = :product_bid_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

$sql = "SELECT pb.*, u.fullname AS winner_fullname
        FROM product_bid pb
        LEFT JOIN user u ON pb.winner_id = u.user_id
        WHERE pb.user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <?php if (!empty($productList)) : ?>
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Tên Phiên</th>
                                    <th>Giá Khởi Điểm</th>
                                    <th>Giá Hiện Tại</th>
                                    <th>Người ra giá gần đây</th>
                                    <th>Thời Gian Kết Thúc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productList as $product) : ?>
                                    <?php if ($product['is_active'] == 1) : ?>
                                        <tr class="text-center">
                                            <td class="product_bid_name">
                                                <h5><?php echo $product['product_bid_name']; ?></h5>
                                            </td>
                                            <td class="start_price">
                                                <h5><?php echo number_format($product['start_price'], 0, ',', '.'); ?>.000vnđ</h5>
                                            </td>
                                            <td class="current_price">
                                                <h5><?php echo number_format($product['current_price'], 0, ',', '.'); ?>.000vnđ</h5>
                                            </td>

                                            <td class="winner_fullname">
                                                <?php if ($product['winner_fullname']) : ?>
                                                    <h5><?php echo $product['winner_fullname']; ?></h5>
                                                <?php else : ?>
                                                    <h5>Chưa có người ra giá.</h5>
                                                <?php endif; ?>
                                            </td>
                                            <td class="real_end_time">
                                                <h5><?php echo $product['real_end_time']; ?></h5>
                                            </td>
                                        
                                           
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            <?php else : ?>
                <p>Bạn chưa thêm sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </div>
</section>