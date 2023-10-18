<?php
session_start();

require_once '../../../config.php';

if (!isset($_GET['id'])) {
    header('location:./index_warehouse.php');
} else {
    $warehouse_id = $_GET['id'];

    $deleteProductsQuery = $conn->prepare('DELETE FROM product WHERE warehouse_id = :warehouse_id');
    $deleteProductsQuery->bindParam(':warehouse_id', $warehouse_id);
    $deleteProductsQuery->execute();

    $deleteWarehouseQuery = $conn->prepare('DELETE FROM warehouse WHERE warehouse_id = :warehouse_id');
    $deleteWarehouseQuery->bindParam(':warehouse_id', $warehouse_id);
    $deleteWarehouseQuery->execute();

    header('location:./index_warehouse.php');
}
?>
