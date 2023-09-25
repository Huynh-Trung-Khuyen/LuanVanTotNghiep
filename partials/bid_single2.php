<?php
$sql = "SELECT 
            pb.product_bid_id, 
            pb.product_bid_name, 
            pb.product_bid_description, 
            pb.start_price, 
            pb.current_price, 
            pb.real_end_time,  
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
        WHERE pb.real_end_time > NOW() AND pb.is_active = 1"; 

$stmt = $conn->prepare($sql);
$stmt->execute();
$productList = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 ">
                <img src="<?php echo $product_bid['product_image_path'] ?>" class="img-fluid" alt="Colorlib Template">
            </div>
            <div class="col-lg-8 product-details pl-md-5">
                <h3>Tên sản phẩm: <?php echo $product_bid['product_bid_name'] ?></h3>
                <p class="price"><span>Người tạo phiên: </strong><?php echo $product_bid['creator_fullname'] ?></span></p>
            <?php foreach ($productList as $product) : ?>
                <p class="price"><span>Thời gian kết thúc: </strong><?php echo $product_bid['real_end_time'] ?></span></p>
            <?php endforeach; ?>
                <p class="price"><span>Giá khởi điểm: </strong><?php echo number_format($product_bid['start_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                <p class="price"><span>Giá hiện tại: </strong><?php echo number_format($product_bid['current_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                <p class="price"><span>Người ra giá gần đây: </strong><?php echo $product_bid['winner_fullname'] ?></span></p>
                <form method="POST">
                    <label for="bid_price">Giá đặt mới: </label>
                    <input type="text" name="bid_price" id="bid_price" required>
                    <input type="submit" value="Đặt giá">
                </form>
                <p>Giá đã được mặc định từ .000vnđ</p>
            </div>
        </div>
    </div>
</section>