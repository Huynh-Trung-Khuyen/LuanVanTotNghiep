<?php
session_start();

require_once '../../../config.php';

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    try {
        $user_delete_sql = "DELETE FROM user WHERE user_id = :user_id";
        $user_delete_stmt = $conn->prepare($user_delete_sql);
        $user_delete_stmt->bindParam(':user_id', $user_id);

        if ($user_delete_stmt->execute()) {

            $business_delete_sql = "DELETE FROM business WHERE user_id = :user_id";
            $business_delete_stmt = $conn->prepare($business_delete_sql);
            $business_delete_stmt->bindParam(':user_id', $user_id);
            $business_delete_stmt->execute();

            $success = "Người dùng và thông tin liên quan đã được xóa thành công.";
        } else {
            $error = "Lỗi khi xóa người dùng.";
        }
    } catch (PDOException $e) {
        $error = "Lỗi truy vấn: " . $e->getMessage();
    }
}

header("Location: ./index_business.php");
exit;

