<?php
session_start();
require_once '../../../config.php';

if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    try {
        $warehouse_ids = [];
        $warehouse_query = $conn->prepare('SELECT warehouse_id FROM warehouse WHERE supplier_id = :supplier_id');
        $warehouse_query->bindParam(':supplier_id', $supplier_id);
        $warehouse_query->execute();
        $warehouse_rows = $warehouse_query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($warehouse_rows as $warehouse_row) {
            $warehouse_ids[] = $warehouse_row['warehouse_id'];
        }

  
        $supplier_delete_sql = "DELETE FROM supplier WHERE supplier_id = :supplier_id";
        $supplier_delete_stmt = $conn->prepare($supplier_delete_sql);
        $supplier_delete_stmt->bindParam(':supplier_id', $supplier_id);

        if ($supplier_delete_stmt->execute()) {

            $warehouse_delete_sql = "DELETE FROM warehouse WHERE supplier_id = :supplier_id";
            $warehouse_delete_stmt = $conn->prepare($warehouse_delete_sql);
            $warehouse_delete_stmt->bindParam(':supplier_id', $supplier_id);
            $warehouse_delete_stmt->execute();

            $product_delete_sql = "DELETE FROM product WHERE warehouse_id IN (" . implode(',', $warehouse_ids) . ")";
            $product_delete_stmt = $conn->prepare($product_delete_sql);
            $product_delete_stmt->execute();

            $success = "Nhà cung cấp và thông tin liên quan đã được xóa thành công.";
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
