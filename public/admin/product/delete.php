<?php
session_start();

require_once '../../../config.php';

if (!isset($_GET['id'])) {
     header('location:./index_product.php');
} else {
    $query = $conn->prepare('DELETE FROM product WHERE product_id = :id');
    $query->bindParam(':id', $_GET['id']);
    $query->execute();

    header('location:./index_product.php');
}

?>