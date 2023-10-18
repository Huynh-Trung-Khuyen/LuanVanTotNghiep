<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    $query = $conn->prepare('
        SELECT category_name
        FROM category
        WHERE category_name = :category_name
    ');
    $query->bindValue(':category_name', $category_name);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        $query = $conn->prepare('
        INSERT INTO category (category_name)
        VALUES (:category_name)
    ');
        $query->bindParam(':category_name', $category_name);
        $query->execute();

        $success = 'Thêm danh mục thành công!';
    } else {
        $error = 'Danh mục đã tồn tại!';
    }
}

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM business WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM user WHERE role = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">

<?php
include("../include/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("../include/sidebar.php");
        ?>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Trang Chủ</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("../main_page/dash_board.php");
            ?>

        </div>
        <?php if (isset($error)) : ?>
            <div style="width: 300px;" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php endif ?>

        <?php if (isset($success)) : ?>
            <div style="width: 300px;" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> <?php echo $success ?>
            </div>
        <?php endif ?>
    </div>
    <!-- ./wrapper -->
    <?php
    include("../include/footer.php");
    ?>
</body>


</html>