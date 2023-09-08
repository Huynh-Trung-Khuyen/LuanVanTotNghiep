<?php
session_start();

require_once '../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vegefoods</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="../css/css/animate.css">

  <link rel="stylesheet" href="../css/css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/css/magnific-popup.css">

  <link rel="stylesheet" href="../css/css/aos.css">

  <link rel="stylesheet" href="../css/css/ionicons.min.css">

  <link rel="stylesheet" href="../css/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../css/css/jquery.timepicker.css">


  <link rel="stylesheet" href="../css/css/flaticon.css">
  <link rel="stylesheet" href="../css/css/icomoon.css">
  <link rel="stylesheet" href="../css/css/style.css">
</head>

<body class="goto-here">

  <?php
  include("../partials/navbar.php");

  if (isset($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    try {
        $stmt = $conn->prepare("SELECT product_id, product_name, content, price, image FROM product WHERE product_name LIKE :product_name");
        $stmt->execute(['product_name' => "%$productName%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            include("../partials/main_search.php");
        } else {
            echo "Không tìm thấy sản phẩm nào.";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
    }
}
  include("../partials/footer.php");
  ?>