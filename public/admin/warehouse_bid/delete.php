<?php
session_start();

require_once '../../../config.php';

if (isset($_GET['id'])) {
    $warehouse_bid_id = $_GET['id'];

    $deleteWarehouseQuery = $conn->prepare('DELETE FROM warehouse_bid WHERE warehouse_bid_id = :warehouse_bid_id');
    $deleteWarehouseQuery->bindParam(':warehouse_bid_id', $warehouse_bid_id);
    $deleteWarehouseQuery->execute();

    header('location:./index_warehouse_bid.php');
} else {
    header('location:./index_warehouse_bid.php');
}

?>
