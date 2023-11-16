<?php
$user_id = $_SESSION['user_id'];

$sql = "SELECT pb.*, u.fullname AS winner_fullname, u.user_id AS winner_user_id, b.business_id, b.city_address, b.district_address, b.address, b.phone, b.email_address
        FROM product_bid pb
        LEFT JOIN user u ON pb.winner_id = u.user_id
        LEFT JOIN business b ON u.user_id = b.user_id
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
                                    <th>Thông tin Giao Hàng</th>
                                    <th>Trạng Thái</th>
                                    <th>Xuất Hóa Đơn</th>
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
                                        <td class="business_info">
                                            <ul style="list-style-type: none; padding: 0;">
                                                <li><strong>Thành Phố:</strong> <?php echo $product['city_address']; ?></li>
                                                <li><strong>Huyện:</strong> <?php echo $product['district_address']; ?></li>
                                                <li><strong>Địa chỉ:</strong> <?php echo $product['address']; ?></li>
                                                <li><strong>Điện Thoại:</strong> <?php echo $product['phone']; ?></li>
                                                <li><strong>Email:</strong> <?php echo $product['email_address']; ?></li>
                                            </ul>
                                        </td>
                                        <td class="product_bid_name">
                                            <h5>Đã Giao Hàng</h5>
                                        </td>
                                       
                                        <td class="">
                                            <div class="col-md-12 ftco-animate">                                           
                                                <button onclick="exportToExcel(<?php echo $product['product_bid_id']; ?>)">Xuất Hóa Đơn</button>
                                            </div>
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

            <script>
                function exportToExcel(product_bid_id) {
                    window.location.href = '../../partials/bid_partials/export.php?product_bid_id=' + product_bid_id;
                }
            </script>
        </div>
    </div>
</section>
