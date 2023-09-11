<?php
 // Bắt đầu hoặc tiếp tục phiên
if (isset($_GET['id']) && isset($_POST['add_to_cart'])) {
    $product_id = $_GET['id']; 
    $quantity_of_products = $_POST['quantity']; 


    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $query = "SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $existingCartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingCartItem) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $newQuantity = $existingCartItem['quantity_of_products'] + $quantity_of_products;
            $updateQuery = "UPDATE cart SET quantity_of_products = :quantity WHERE cart_id = :cart_id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':cart_id', $existingCartItem['cart_id']);
            $updateStmt->execute();
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm vào
            $insertQuery = "INSERT INTO cart (user_id, product_id, quantity_of_products) VALUES (:user_id, :product_id, :quantity)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $user_id);
            $insertStmt->bindParam(':product_id', $product_id);
            $insertStmt->bindParam(':quantity', $quantity_of_products);
            $insertStmt->execute();
        }

        // Hiển thị thông báo sản phẩm đã được thêm vào giỏ hàng
        echo "Sản phẩm đã được thêm vào giỏ hàng.";
    } else {
        // Xử lý trường hợp 'user_id' không tồn tại trong phiên
        echo "Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.";
    }
}
?>



<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
}
?>
<?php foreach ($products as $row) : ?>
    <form method="POST">
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 ">
                    <img src="../public/uploads/<?php echo $row['image'] ?>" class="img-fluid" alt="Colorlib Template">
                </div>
                <div class="col-lg-6 product-details pl-md-5">
                    <h3><?php echo $row['product_name'] ?></h3>

                    <p class="price"><span></strong><?php echo $row['price'] ?>.000 vnđ/Kg</span></p>
                    <p><?php echo $row['content'] ?></p>
                    <div class="row mt-4">
                        <div class="w-100"></div>
                        <div class="input-group col-md-6 d-flex mb-3">
                            <span class="input-group-btn mr-2">
                                <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                    <i class="ion-ios-remove"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                            <span class="input-group-btn ml-2">
                                <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                    <i class="ion-ios-add"></i>
                                </button>
                            </span>
                        </div>
                        <div class="w-100"></div>
                        
                    </div>
      
                    <button type="submit" class="btn  " name="add_to_cart">Add to Cart</button>
                </div>
            </div>
        </div>
    </section>
    </form>
<?php endforeach ?>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.quantity-left-minus').click(function () {
            var quantityField = $(this).closest('.input-group').find('.input-number');
            var currentValue = parseInt(quantityField.val());
            if (!isNaN(currentValue) && currentValue > 1) {
                quantityField.val(currentValue - 1);
            }
        });

        $('.quantity-right-plus').click(function () {
            var quantityField = $(this).closest('.input-group').find('.input-number');
            var currentValue = parseInt(quantityField.val());
            if (!isNaN(currentValue)) {
                quantityField.val(currentValue + 1);
            }
        });
    });
</script>




