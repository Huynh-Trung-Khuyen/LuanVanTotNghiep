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

// Lấy danh sách tất cả sản phẩm (nếu cần)
$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

// if (isset($_SESSION['user_id'])) {

//   $user_id = $_SESSION['user_id'];
//   echo "Bạn đã đăng nhập với user_id: $user_id";
// } else {

//   echo "Bạn chưa đăng nhập hoặc phiên đã hết hạn.";
// }
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../public/account/login.php');
    exit;
}
// Lấy thông tin người dùng từ CSDL
$user_id = $_SESSION['user_id'];
$query = $conn->prepare('SELECT role FROM user WHERE user_id = :user_id LIMIT 1');
$query->bindParam(':user_id', $user_id);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

// Kiểm tra quyền của người dùng
if ($user && $user['role'] == 2) {
    // Người dùng có role là 2 (doanh nghiệp), cho phép truy cập vào trang này
} elseif ($user && $user['role'] == 1) {
    // Người dùng có role là 1 (người dùng thông thường), hiển thị thông báo
    echo "Chỉ có doanh nghiệp được tham gia đấu giá";
    exit; // Dừng xử lý tiếp theo
} else {
    // Người dùng có role khác hoặc không tồn tại, có thể xử lý tùy theo yêu cầu
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
  include("../../partials/business/edit_business.php");
  include("../../partials/include/footer.php");
    ?>

</body>
</html>