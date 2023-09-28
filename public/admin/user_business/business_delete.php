<?php
session_start();

require_once '../../../config.php';

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    try {
        $sql = "DELETE FROM user WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            $success = "Người dùng đã được xóa thành công.";
        } else {
            $error = "Lỗi khi xóa người dùng.";
        }
    } catch (PDOException $e) {
        $error = "Lỗi truy vấn: " . $e->getMessage();
    }
}

header("Location: ./index_business.php");
exit;
