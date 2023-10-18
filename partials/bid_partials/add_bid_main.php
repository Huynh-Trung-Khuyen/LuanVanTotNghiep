<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_SESSION['user_id'];


    $product_bid_name = $_POST['product_bid_name'];
    $product_bid_description = $_POST['product_bid_description'];
    $start_price = $_POST['start_price'];
    $end_time = $_POST['end_time'];


    $image_name = '';

    if (!empty($_FILES['product_bid_image']['name'])) {
        $image_name = time() . '_' . $_FILES['product_bid_image']['name'];
        $image_tmp = $_FILES['product_bid_image']['tmp_name'];
        $image_path = '../../public/uploads/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
  
            $conn->beginTransaction();

            try {
              
                $check_money_query = $conn->prepare('SELECT money FROM business WHERE user_id = :user_id');
                $check_money_query->bindParam(':user_id', $user_id);
                $check_money_query->execute();
                $money = $check_money_query->fetch(PDO::FETCH_COLUMN);

                if ($money < 200) {
                    $error = 'Số tiền không đủ, vui lòng nạp thêm tiền.';
                } else {
               
                    $new_money = $money - 200;
                    $update_money_query = $conn->prepare('UPDATE business SET money = :money WHERE user_id = :user_id');
                    $update_money_query->bindParam(':money', $new_money);
                    $update_money_query->bindParam(':user_id', $user_id);
                    $update_money_query->execute();

                    $end_time = date('Y-m-d H:i:s', strtotime($end_time)); 

       
                    $query = $conn->prepare('
                        INSERT INTO product_bid
                        (user_id, product_bid_name, product_bid_description, start_price, current_price, end_time, real_end_time, product_bid_image)
                        VALUES
                        (:user_id, :product_bid_name, :product_bid_description, :start_price, :start_price, :end_time, :real_end_time, :product_bid_image)
                    ');

                    $query->bindParam(':user_id', $user_id);
                    $query->bindParam(':product_bid_name', $product_bid_name);
                    $query->bindParam(':product_bid_description', $product_bid_description);
                    $query->bindParam(':start_price', $start_price);
                    $query->bindParam(':end_time', $end_time);
                    $query->bindParam(':real_end_time', $end_time);
                    $query->bindParam(':product_bid_image', $image_name);

                    if ($query->execute()) {
                        $conn->commit(); 
                        $success = 'Thêm phiên đấu giá thành công!';
                    } else {
                        $conn->rollBack(); 
                        $error = 'Thêm phiên đấu giá thất bại!';
                    }
                }
            } catch (PDOException $e) {
                $conn->rollBack(); 
                $error = 'Có lỗi xảy ra: ' . $e->getMessage();
            }
        } else {

            $error = 'Lỗi khi tải lên hình ảnh.';
        }
    }
}

?>




<!DOCTYPE html>
<html>
<head>
    <title>Thêm Phiên Đấu Giá Mới</title>
</head>
<body>
    <h1>Thêm Phiên Đấu Giá Mới</h1>
    
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product_bid_name">Tên Sản Phẩm Đấu Giá:</label>
        <input type="text" id="product_bid_name" name="product_bid_name" required><br><br>

        <label for="product_bid_description">Mô Tả Sản Phẩm Đấu Giá:</label>
        <textarea id="product_bid_description" name="product_bid_description" required></textarea><br><br>

        <label for="start_price">Giá Khởi Điểm:</label>
        <input type="number" id="start_price" name="start_price" required>.000vnđ<br><br>

        <label for="end_time">Thời Gian Kết Thúc:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br><br>

        <label for="product_bid_image">Hình Ảnh Sản Phẩm Đấu Giá:</label>
        <input type="file" id="product_bid_image" name="product_bid_image" accept="image/*" required><br><br>

        <button type="submit">Thêm Phiên Đấu Giá</button>
    </form>

    <p><a href="../../public/bid/bid.php">Quay lại danh sách sản phẩm</a></p>
</body>
</html>
