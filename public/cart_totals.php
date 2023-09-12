<?php
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "
        SELECT SUM(p.price * c.quantity_of_products) as cart_total
        FROM cart AS c
        INNER JOIN product AS p ON c.product_id = p.product_id
        WHERE c.user_id = :user_id
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart_total = $result['cart_total'];
} else {
    $cart_total = 0; 
}
?>
<div class="row justify-content-end">
    <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
            <h3>Tổng Giỏ Hàng</h3>
            <hr>
            <p class="d-flex total-price">
                <span>Tổng Số Tiền</span>
            <p class="total">
                <?php echo number_format($cart_total, 0, ',', '.'); ?>.000 vnđ
            </p>
            </p>
        </div>
        <p><a href="../public/checkout.php" class="btn btn-primary py-3 px-4">Đặt Hàng Ngay</a></p>
    </div>
</div>