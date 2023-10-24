<?php
session_start();
require_once '../../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$products = [];
$selectedProduct = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
    $query->bindParam(':id', $id);
    $query->execute();
    $selectedProduct = $query->fetch(PDO::FETCH_ASSOC);
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../public/account/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = $conn->prepare('SELECT role FROM user WHERE user_id = :user_id LIMIT 1');
$query->bindParam(':user_id', $user_id);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("../../partials/include/head.php"); ?>

<body class="goto-here">
    <?php include("../../partials/include/navbar.php"); ?>

    <?php
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
        b.money,
        b.tax_code  
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

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        include('../../partials/business/business_info_main.php');
    } else {
    ?>
        <div class="alert alert-warning" role="alert">
            <strong>Thông báo:</strong> Bạn chưa có thông tin doanh nghiệp.
            <a href="./add_info_b.php" class="alert-link">Nhấn vào đây để điền thông tin doanh nghiệp</a>
        </div>

    <?php
    }
    ?>

    <?php include("../../partials/include/footer.php"); ?>
</body>

</html>