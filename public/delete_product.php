<?php
session_start();

if (isset($_POST['xoa_san_pham'])) {
    $cart_id_to_delete = $_POST['cart_id'];

    // Kết nối đến cơ sở dữ liệu và thực hiện xóa sản phẩm
    require_once '../config.php'; // Thay thế 'config.php' bằng tệp cấu hình của bạn

    $query = $conn->prepare('DELETE FROM cart WHERE cart_id = :cart_id');
    $query->bindParam(':cart_id', $cart_id_to_delete);
    
    if ($query->execute()) {
        // Xóa thành công
        header('location:./cart.php'); // Chuyển hướng người dùng sau khi xóa
        exit();
    } else {
        echo "Lỗi khi xóa sản phẩm: " . $query->errorInfo()[2];
    }
}
?>
