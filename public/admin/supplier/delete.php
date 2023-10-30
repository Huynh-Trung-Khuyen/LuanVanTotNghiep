<?php
session_start();
require_once '../../../config.php';

if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    try {
        $supplier_delete_sql = "DELETE FROM supplier WHERE supplier_id = :supplier_id";
        $supplier_delete_stmt = $conn->prepare($supplier_delete_sql);
        $supplier_delete_stmt->bindParam(':supplier_id', $supplier_id);

        if ($supplier_delete_stmt->execute()) {
            $success = "Nhà cung cấp đã được xóa thành công.";
        } else {
            $error = "Lỗi khi xóa nhà cung cấp.";
        }
    } catch (PDOException $e) {
        $error = "Lỗi truy vấn: " . $e->getMessage();
    }
}

header("Location: ./index_supplier.php");
exit;
?>
