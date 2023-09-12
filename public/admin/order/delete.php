<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        require_once '../../../config.php';
        $query = $conn->prepare('DELETE FROM `order` WHERE order_id = :order_id');
        $query->bindParam(':order_id', $order_id);

        if ($query->execute()) {
            $_SESSION['success_message'] = 'Giao đơn hàng thành công.';
        } else {

            $_SESSION['error_message'] = 'Lỗi khi xác nhận đơn hàng.';
        }

        header('Location:./index_order.php');
        exit;
    }
}
?>
