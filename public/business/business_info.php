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

if ($user && $user['role'] == 1) {
} elseif ($user && $user['role'] == 2) {
  echo "Chỉ có doanh nghiệp được tham gia đấu giá";
  exit;
} else {

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
    ?>
    <?php
    try {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header('location:../../public/account/login.php');
            exit;
        }

  
        $user_id = $_SESSION['user_id'];


        $sql = "SELECT 
        b.business_id,
        b.user_id,
        u.fullname AS user_fullname,
        b.city_address,
        b.district_address,
        b.address,
        b.phone,
        b.email_address,
        b.money  
    FROM
        business AS b
    JOIN
        user AS u
    ON
        b.user_id = u.user_id
    WHERE
        u.user_id = :user_id";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Lặp qua kết quả và hiển thị thông tin nếu có, ngược lại hiển thị nút để điền thông tin
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "User Fullname: " . $row['user_fullname'] . "<br>";
            echo "City Address: " . $row['city_address'] . "<br>";
            echo "District Address: " . $row['district_address'] . "<br>";
            echo "Address: " . $row['address'] . "<br>";
            echo "Phone: " . $row['phone'] . "<br>";
            echo "Email Address: " . $row['email_address'] . "<br>";
            echo "Money: " . $row['money'] .".000vnđ" . "<br><br>";
            echo "<a href='./edit_info_b.php'>Nhấn vào đây để sửa thông tin doanh nghiệp</a>";
        } else {
            echo "Bạn chưa có thông tin doanh nghiệp.<br>";
            echo "<a href='./add_info_b.php'>Nhấn vào đây để điền thông tin doanh nghiệp</a>";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
    ?>

    <?php
    include("../../partials/include/footer.php");
    ?>

</body>

</html>