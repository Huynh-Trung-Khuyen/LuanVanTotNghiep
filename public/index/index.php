<?php
session_start();

require_once '../../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$products = []; 
$selectedProduct = null; // Khởi tạo biến cho sản phẩm cụ thể

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
  $query->bindParam(':id', $id);
  $query->execute();
  $selectedProduct = $query->fetch(PDO::FETCH_ASSOC); // Sản phẩm cụ thể
}

$query = $conn->prepare('SELECT * FROM warehouse');
$query->execute();
$warehouse = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$supplier = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $key => $productItem) {
  $warehouseId = $productItem['warehouse_id'];
  
  $supplierName = '';
  foreach ($warehouse as $warehouseItem) {
      if ($warehouseItem['warehouse_id'] == $warehouseId) {
          $supplierId = $warehouseItem['supplier_id'];
          
          foreach ($supplier as $supplierItem) {
              if ($supplierItem['supplier_id'] == $supplierId) {
                  $supplierName = $supplierItem['supplier_name'];
                  break;
              }
          }
          break;
      }
  }

  $products[$key]['supplier_name'] = $supplierName;
}



// if (isset($_SESSION['user_id'])) {
  
//   $user_id = $_SESSION['user_id'];
//   echo "Bạn đã đăng nhập với user_id: $user_id";
// } else {
  
//   echo "Bạn chưa đăng nhập hoặc phiên đã hết hạn.";
// }
?>

<!DOCTYPE html>
<html lang="en">

<?php
  include("../../partials/include/head.php");
  ?>

<body class="goto-here">

  <?php
  include("../../partials/include/navbar.php");
  include("../../partials/include/slider.php");
  include("../../partials/include/main.php");
  include("../../partials/include/footer.php");
  ?>
</body>

</html>