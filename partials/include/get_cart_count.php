<?php
session_start();
require_once '../../config.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['cart_count' => $result['cart_count']]);
} else {
    echo json_encode(['cart_count' => 0]);
}
?>
