<?php
session_start();

require_once '../../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  header('location:../account/login.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
  include("../../partials/include/head.php");
  ?>

<body class="goto-here">
  <?php
  include("../../partials/include/navbar.php");
  include("../../partials/cart/order_main.php");
  include("../../partials/include/footer.php");
  ?>
</body>
</html>