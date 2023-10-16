<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_bid_id'])) {
        $product_bid_id = $_POST['product_bid_id'];

        require_once '../../config.php';

        $queryDeleteBid = $conn->prepare('DELETE FROM `bid` WHERE product_bid_id = :product_bid_id');
        $queryDeleteBid->bindParam(':product_bid_id', $product_bid_id);
        $queryDeleteBid->execute();


        $queryDeleteProductBid = $conn->prepare('DELETE FROM `product_bid` WHERE product_bid_id = :product_bid_id');
        $queryDeleteProductBid->bindParam(':product_bid_id', $product_bid_id);

        if ($queryDeleteProductBid->execute()) {
            $_SESSION['success_message'] = 'Xóa thành công.';
        } else {
            $_SESSION['error_message'] = 'Lỗi khi xóa.';
        }

        header('Location:../../public/bid/bid_manage.php');
        exit;
    }
}
?>

