<?php
session_start();


require_once '../../config.php';
$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
$query->bindParam(':id', $id);
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC)
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

  <link rel="stylesheet" href="../../css/css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="../../css/css/animate.css">

  <link rel="stylesheet" href="../../css/css/owl.carousel.min.css">
  <link rel="stylesheet" href="../../css/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../css/css/magnific-popup.css">

  <link rel="stylesheet" href="../../css/css/aos.css">

  <link rel="stylesheet" href="../../css/css/ionicons.min.css">

  <link rel="stylesheet" href="../../css/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../../css/css/jquery.timepicker.css">


  <link rel="stylesheet" href="../../css/css/flaticon.css">
  <link rel="stylesheet" href="../../css/css/icomoon.css">
  <link rel="stylesheet" href="../../css/css/style.css">
</head>

<body >

<?php
  include("../../partials/include/navbar.php");
  include("../../partials/shop_main/product_single.php");
  include("../../partials/include/footer.php");
  ?>

</body>

</html>