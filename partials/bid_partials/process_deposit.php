<?php
session_start();

require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['product_bid_id'])) {
        $product_bid_id = $_POST['product_bid_id'];
        $sqlCheck = "SELECT COUNT(*) FROM deposit WHERE user_id = :user_id AND product_bid_id = :product_bid_id";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtCheck->bindParam(':product_bid_id', $product_bid_id, PDO::PARAM_INT);
        $stmtCheck->execute();

        $count = $stmtCheck->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO deposit (user_id, product_bid_id) VALUES (:user_id, :product_bid_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_bid_id', $product_bid_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $sqlUpdate = "UPDATE business SET money = money - 200 WHERE user_id = :user_id";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmtUpdate->execute();

                header("Location: ../../public/bid/bid_detail.php?product_bid_id=" . $product_bid_id);
                exit();
            } else {
                echo "Có lỗi xảy ra khi thêm dữ liệu vào bảng.";
            }
        } else {
            header("Location: ../../public/bid/bid_detail.php?product_bid_id=" . $product_bid_id);
            exit();
        }
    } else {
        echo "Thiếu thông tin product_bid_id.";
    }
}
?>
