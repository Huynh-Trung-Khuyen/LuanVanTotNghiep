<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;

    if ($order_id) {

        $query = "UPDATE `order` SET role = 3 WHERE order_id = :order_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        header('Location:./index_order.php');
    }
}
?>
