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
            <h3>Cart Totals</h3>
            <hr>
            <p class="d-flex total-price">
                <span>Total</span>
            <p class="total">
                <?php echo number_format($cart_total, 0, ',', '.'); ?>.000 vnđ
            </p>
            </p>
        </div>
        <p><a href="checkout.html" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
    </div>
</div>