<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_name = $_POST['order_name'];
    $address = $_POST['address'];
    $city_address = $_POST['city_address'];
    $district_address = $_POST['district_address'];
    $phone = $_POST['phone'];
    $email_address = $_POST['email_address'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "
            SELECT c.product_id, c.quantity_of_products
            FROM cart AS c
            WHERE c.user_id = :user_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $cart_contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conn->beginTransaction();

        $cart_total = 0;
        $query = "INSERT INTO `order` (order_name, address, city_address, district_address, phone, email_address, cart_total, user_id) 
                  VALUES (:order_name, :address, :city_address, :district_address, :phone, :email_address, 0, :user_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':order_name', $order_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city_address', $city_address);
        $stmt->bindParam(':district_address', $district_address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            $order_id = $conn->lastInsertId();

            foreach ($cart_contents as $item) {
                $product_id = $item['product_id'];
                $quantity_of_products = $item['quantity_of_products'];


                $product_query = "SELECT price, warehouse_id FROM product WHERE product_id = :product_id";
                $product_stmt = $conn->prepare($product_query);
                $product_stmt->bindParam(':product_id', $product_id);
                $product_stmt->execute();
                $product_result = $product_stmt->fetch(PDO::FETCH_ASSOC);

                if ($product_result) {
                    $product_price = $product_result['price'];
                    $warehouse_id = $product_result['warehouse_id'];


                    $item_total = $product_price * $quantity_of_products;
                    $cart_total += $item_total;


                    $insertOrderedProductsQuery = "INSERT INTO ordered_products (order_id, product_id, quantity_of_products) VALUES (:order_id, :product_id, :quantity_of_products)";
                    $insertOrderedProductsStmt = $conn->prepare($insertOrderedProductsQuery);
                    $insertOrderedProductsStmt->bindParam(':order_id', $order_id);
                    $insertOrderedProductsStmt->bindParam(':product_id', $product_id);
                    $insertOrderedProductsStmt->bindParam(':quantity_of_products', $quantity_of_products);
                    $insertOrderedProductsStmt->execute();

                    $updateWarehouseQuery = "UPDATE warehouse SET quantity = quantity - :quantity_of_products WHERE warehouse_id = :warehouse_id";
                    $updateWarehouseStmt = $conn->prepare($updateWarehouseQuery);
                    $updateWarehouseStmt->bindParam(':quantity_of_products', $quantity_of_products);
                    $updateWarehouseStmt->bindParam(':warehouse_id', $warehouse_id);
                    $updateWarehouseStmt->execute();
                } else {
                }
            }


            $updateOrderQuery = "UPDATE `order` SET cart_total = :cart_total WHERE order_id = :order_id";
            $updateOrderStmt = $conn->prepare($updateOrderQuery);
            $updateOrderStmt->bindParam(':cart_total', $cart_total, PDO::PARAM_INT);
            $updateOrderStmt->bindParam(':order_id', $order_id);
            $updateOrderStmt->execute();

            $deleteQuery = "DELETE FROM cart WHERE user_id = :user_id";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':user_id', $user_id);
            $deleteStmt->execute();


            $conn->commit();

            $successMessage = 'Đặt hàng thành công!';
        } else {

            $conn->rollback();
            echo "Lỗi khi thêm hóa đơn: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Người dùng chưa đăng nhập.";
    }
}
?>



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

<section class="ftco-section">
    <?php if (isset($successMessage)) : ?>
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thành công</h5>
                        <a href="../../public/bid/add_bid.php" class=" ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></a>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $successMessage; ?></p>
                        <a href="../../public/cart/checkout.php" class="btn btn-primary btn-block">Xem Thông Tin Giao Hàng</a>
                       
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="container">
        <form action="#" method="POST" class="billing-form">
            <div class="row justify-content-center">
                <div class="col-xl-7 ftco-animate">
                    <h3 class="mb-4 billing-heading">Hóa Đơn Thanh Toán</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="order_name">Họ Và Tên Người Nhận</label>
                                <input type="text" class="form-control" name="order_name" placeholder="Nhập Tên Người Nhận">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Địa Chỉ</label>
                                <input type="text" class="form-control" name="address" placeholder="Nhập Địa Chỉ Nhận Hàng">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_address">Thành Phố</label>
                                <input type="text" class="form-control" name="city_address" placeholder="Nhập Thành Phố">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district_address">Huyện</label>
                                <input type="text" class="form-control" name="district_address" placeholder="Nhập Huyện">
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Số Điện Thoại</label>
                                <input type="text" class="form-control" name="phone" placeholder="Nhập Số Điện Thoại">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address">Email</label>
                                <input type="text" class="form-control" name="email_address" placeholder="Nhập Email">
                            </div>
                        </div>
                        <div class="w-100"></div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="row mt-5 pt-3">
                        <div class="cart-total mb-3">
                            <h3>Tổng Giỏ Hàng</h3>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Tổng Số Tiền</span>
                            <p class="total">
                                <?php echo number_format($cart_total, 0, ',', '.'); ?>.000 vnđ
                            </p>
                            <div class="cart-detail p-3 p-md-4">
                                <p><button type="submit" class="btn btn-primary py-3 px-4">Đặt Hàng</button></p>
                            </div>
                            </p>
                        </div>
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    <?php if (isset($successMessage)) : ?>
        document.getElementById("successMessage").textContent = "<?php echo $successMessage; ?>";
        $("#successModal").modal("show");
    <?php endif; ?>

    <?php if (isset($errorMessage)) : ?>
        document.getElementById("errorMessage").textContent = "<?php echo $errorMessage; ?>";
        $("#errorModal").modal("show");
    <?php endif; ?>
</script>