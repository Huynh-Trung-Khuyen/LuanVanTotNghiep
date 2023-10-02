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

<?php
include("../../partials/include/head.php");
?>

<body>
  <?php
  include("../../partials/include/navbar.php");
  include("../../partials/shop_main/product_single.php");
  include("../../partials/include/footer.php");
  ?>
</body>

</html>