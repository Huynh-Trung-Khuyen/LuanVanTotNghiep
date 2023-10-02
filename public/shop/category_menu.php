<?php
session_start();

require_once '../../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<?php
  include("../../partials/include/head.php");
  ?>

<body class="goto-here">

  <?php
  include("../../partials/include/navbar.php");


  if (isset($_GET['category_id'])) {
      $categoryId = $_GET['category_id'];
  
      try {
          // Sử dụng prepared statement để tránh SQL injection
          $stmt = $conn->prepare("SELECT product_id, product_name, content, price, image FROM product WHERE category_id = :category_id");
          $stmt->execute(['category_id' => $categoryId]);
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
          if (count($results) > 0) {

                include("../../partials/shop_main/main_category.php");

              echo "</ul>";
          } else {
              echo "Không tìm thấy sản phẩm nào trong danh mục này.";
          }
      } catch (PDOException $e) {
          echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
      }
  }

  include("../../partials/include/footer.php");
  ?>