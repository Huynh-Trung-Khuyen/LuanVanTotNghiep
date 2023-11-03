<?php
$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            pb.product_bid_id, 
            pb.product_bid_name, 
            pb.product_bid_description, 
            pb.current_price  -- Lấy giá cuối cùng
        FROM product_bid pb
        WHERE pb.winner_id = :user_id AND pb.is_active = 3";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$wonProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <?php if (!empty($wonProducts)) : ?>
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Tên Phiên</th>
                                    <th>Số Tiền Cần Thanh Toán</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wonProducts as $product) : ?>

                                    <tr class="text-center">
                                        <td class="product_bid_name">
                                            <h5><?php echo $product['product_bid_name']; ?></h5>
                                        </td>
                                        <td class="current_price">
                                            <h5><?php echo number_format($product['current_price'], 0, ',', '.'); ?>.000vnđ</h5>
                                        </td>

                                        <td class="product_bid_name">
                                            <h5>Đã Giao Hàng</h5>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            <?php else : ?>
                <p>Bạn chưa thêm sản phẩm nào.</p>
            <?php endif; ?>