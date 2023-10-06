<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        require_once '../../../config.php';

        // Bước 1: Xóa các mục liên quan trong bảng ordered_products
        $deleteOrderedProductsQuery = $conn->prepare('DELETE FROM ordered_products WHERE order_id = :order_id');
        $deleteOrderedProductsQuery->bindParam(':order_id', $order_id);
        $deleteOrderedProductsQuery->execute();

        // Bước 2: Xóa đơn hàng từ bảng order
        $deleteOrderQuery = $conn->prepare('DELETE FROM `order` WHERE order_id = :order_id');
        $deleteOrderQuery->bindParam(':order_id', $order_id);

        if ($deleteOrderQuery->execute()) {
            $_SESSION['success_message'] = 'Xóa đơn hàng và các sản phẩm liên quan thành công.';
        } else {
            $_SESSION['error_message'] = 'Lỗi khi xóa đơn hàng và các sản phẩm liên quan.';
        }

        header('Location:./index_order.php');
        exit;
    }
}
?>

