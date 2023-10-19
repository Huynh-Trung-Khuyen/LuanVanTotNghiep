<?php
// Kết nối với cơ sở dữ liệu
session_start();
require_once '../../config.php'; 
if (isset($_GET['product_bid_id'])) {
    $product_bid_id = $_GET['product_bid_id'];

    // Thực hiện truy vấn để lấy giá trị winner_id
    $sql = "SELECT winner_id FROM product_bid WHERE product_bid_id = :product_bid_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Trả về giá trị winner_id dưới dạng JSON
    echo json_encode($result);
}
?>


