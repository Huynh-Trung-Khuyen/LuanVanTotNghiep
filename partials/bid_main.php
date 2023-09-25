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
        $sql = "UPDATE product_bid SET current_price = :last_bid_price, user_id = :user_id, winner_id = :user_id WHERE product_bid_id = :product_bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':last_bid_price', $last_bid['last_bid_price']);
        $stmt->bindParam(':user_id', $last_bid['user_id']);
        $stmt->bindParam(':product_bid_id', $expired_bid['product_bid_id']);
        $stmt->execute();
    }
}

$sql = "UPDATE product_bid SET is_active = 0 WHERE real_end_time <= :current_time";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':current_time', $current_time);
$stmt->execute();


$sql = "SELECT 
    pb.product_bid_id, 
    pb.product_bid_name, 
    pb.product_bid_description, 
    pb.start_price, 
    pb.current_price, 
    pb.real_end_time,
    pb.product_bid_image,
    u1.fullname AS seller_fullname,  -- Lấy fullname thay vì username
    b1.bid_price AS last_bid_price, 
    u2.fullname AS last_bidder_fullname  -- Lấy fullname thay vì username
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
WHERE pb.real_end_time > NOW() AND pb.is_active = 1"; // Sử dụng real_end_time thay vì end_time và kiểm tra is_active
$stmt = $conn->prepare($sql);
$stmt->execute();
$productList = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container">
    <div class="row justify-content-center mb-3 pb-3">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Cửa Hàng Nông Sản Sạch</span>
            <h2 class="mb-4">Các Sản Phẩm Được Đấu Giá</h2>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-10 mb-5 text-center">
    </div>
</div>

<div class="container">
    <div class="row">
        <?php foreach ($productList as $product) : ?>
            <div class="col-md-6 col-lg-3 ftco-animate">
                <div class="product">
                    <a href="../public/bid_detail.php?product_bid_id=<?php echo $product['product_bid_id']; ?>" class="img-prod">
                        <img src="../public/uploads/<?php echo $product['product_bid_image'] ?>" class="img-fluid" alt="Ảnh">
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="../public/bid_detail.php?product_bid_id=<?php echo $product['product_bid_id']; ?>"><?php echo $product['product_bid_name']; ?></a></h3>
                        <h7>Người bán: <?php echo $product['seller_fullname']; ?></h7>
                        <div class="d-flex justify-content-center align-items-center">
                            <p class="price"><span>
                                    Giá khởi điểm: <?php echo number_format($product['start_price'], 0, ',', '.') ?>.000vnđ
                                    <?php if ($product['last_bid_price'] > 0) : ?>
                                        Giá hiện tại: <?php echo number_format($product['last_bid_price'], 0, ',', '.') ?>.000vnđ
                                    <?php else : ?>
                                        Chưa có người tham gia
                                    <?php endif; ?>
                                </span></p>
                        </div>
                        <h7>Thời Gian Kết Thúc:<br><?php echo $product['real_end_time']; ?></h7>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>