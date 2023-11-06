<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_GET['id'];
    $quantity_of_products = $_POST['quantity'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $query = $conn->prepare('SELECT w.quantity FROM warehouse w JOIN product p ON w.warehouse_id = p.warehouse_id WHERE p.product_id = :product_id');
        $query->bindParam(':product_id', $product_id);
        $query->execute();
        $product_quantity = $query->fetch(PDO::FETCH_ASSOC);

        if ($product_quantity) {
            if ($quantity_of_products < 1) {
                $error = "Vui lòng chọn số lượng hợp lệ.";
            } elseif ($quantity_of_products > $product_quantity['quantity']) {
                $error = "Số lượng sản phẩm vượt quá số lượng hiện có.";
            } else {
                $query = "SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $existingCartItem = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingCartItem) {
                    $newQuantity = $existingCartItem['quantity_of_products'] + $quantity_of_products;
                    $updateQuery = "UPDATE cart SET quantity_of_products = :quantity WHERE cart_id = :cart_id";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bindParam(':quantity', $newQuantity);
                    $updateStmt->bindParam(':cart_id', $existingCartItem['cart_id']);
                    $updateStmt->execute();
                } else {
                    $insertQuery = "INSERT INTO cart (user_id, product_id, quantity_of_products) VALUES (:user_id, :product_id, :quantity)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bindParam(':user_id', $user_id);
                    $insertStmt->bindParam(':product_id', $product_id);
                    $insertStmt->bindParam(':quantity', $quantity_of_products);
                    $insertStmt->execute();
                }
                $success = "Sản phẩm đã được thêm vào giỏ hàng.";
            }
        } else {
            $error = "Không có sản phẩm hoặc đã hết hàng.";
        }
    } else {
        $error = "Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.";
    }
}


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $query = $conn->prepare('
        SELECT p.*, w.quantity, s.supplier_name
        FROM product p
        JOIN warehouse w ON p.warehouse_id = w.warehouse_id
        JOIN supplier s ON w.supplier_id = s.supplier_id
        WHERE p.product_id = :product_id
    ');
    $query->bindParam(':product_id', $product_id);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_ASSOC);
}
?>
<?php if (!empty($product)) : ?>
    <form method="POST">
        <section class="ftco-section">
            <div class="container">
                <?php if (isset($error)) : ?>
                    <div style="width: auto;" class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>
                            <i class="fa-regular fa-face-sad-cry"></i>
                            Xin Lỗi!
                        </strong> <?php echo $error ?>
                    </div>
                <?php endif ?>
                <?php if (isset($success)) : ?>
                    <div style="width: auto;" class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fa-solid fa-face-smile-wink"></i>
                            Tuyệt Vời!
                        </strong> <?php echo $success ?>
                    </div>
                <?php endif ?>
                <div class="row">
                    <div class="col-lg-6 mb-5">
                        <img src="../../public/uploads/<?php echo $product['image'] ?>" class="img-fluid" alt="Colorlib Template">
                    </div>
                    <div class="col-lg-6 product-details pl-md-5">
                        <h3><?php echo $product['product_name'] ?></h3>
                        <p class="price"><span><?php echo $product['price'] ?>.000 vnđ/Kg</span></p>
                        <p><?php echo $product['content'] ?></p>
                        <p>Số lượng hiện có: <?php echo $product['quantity'] ?>Kg</p>
                        <p>Nhà cung cấp: <?php echo $product['supplier_name'] ?></p>
                        <div class="row mt-4">
                            <div class="w-100"></div>
                            <div class="input-group col-md-6 d-flex mb-3">
                                <span class="input-group-btn mr-2">
                                    <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                        <i class="ion-ios-remove"></i>
                                    </button>
                                </span>
                                <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                                <span class="input-group-btn ml-2">
                                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                        <i class="ion-ios-add"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="w-100"></div>
                        </div>
                        <button type="submit" class="btn" name="add_to_cart">Thêm Vào Giỏ Hàng</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
<?php endif ?>
<script>
    $(document).ready(function() {
        $(".quantity-left-minus").click(function() {
            var quantityInput = $(this).parent().siblings("input");
            var quantity = parseInt(quantityInput.val());
            if (quantity > 1) {
                quantityInput.val(quantity - 1);
            }
        });

        $(".quantity-right-plus").click(function() {
            var quantityInput = $(this).parent().siblings("input");
            var quantity = parseInt(quantityInput.val());
            var maxQuantity = parseInt(quantityInput.attr("max"));
            if (quantity < maxQuantity) {
                quantityInput.val(quantity + 1);
            }
        });
    });
</script>