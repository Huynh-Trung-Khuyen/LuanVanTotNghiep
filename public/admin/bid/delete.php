<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_bid_id'])) {
        $product_bid_id = $_POST['product_bid_id']; // Gán giá trị từ form vào biến
        require_once '../../../config.php';
        $query = $conn->prepare('DELETE FROM `product_bid` WHERE product_bid_id = :product_bid_id');
        $query->bindParam(':product_bid_id', $product_bid_id); // Gán giá trị cho :product_bid_id

        if ($query->execute()) {
            $_SESSION['success_message'] = 'Xóa thành công.';
        } else {
            $_SESSION['error_message'] = 'Lỗi khi xóa.';
        }

        header('Location:./index_bid.php');
        exit;
    }
}
?>

