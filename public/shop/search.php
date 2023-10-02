<?php
session_start();

require_once '../../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<?php
include("../../partials/include/head.php");
?>

<body class="goto-here">

  <?php
  include("../../partials/include/navbar.php");

  if (isset($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    try {
      $stmt = $conn->prepare("SELECT product_id, product_name, content, price, image FROM product WHERE product_name LIKE :product_name");
      $stmt->execute(['product_name' => "%$productName%"]);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($results) > 0) {
        include("../../partials/shop_main/main_search.php");
      } else {
        echo "Không tìm thấy sản phẩm nào.";
      }
    } catch (PDOException $e) {
      echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
    }
  }
  include("../../partials/include/footer.php");
  ?>