<?php
session_start();

require_once '../../../config.php';

if (isset($_POST['change_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = ($_POST['current_role'] == 2) ? 1 : 2;

    try {
        $sql = "UPDATE user SET role = :new_role WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':new_role', $new_role);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            $success = "Role đã được cập nhật thành công.";
        } else {
            $error = "Lỗi khi cập nhật role.";
        }
    } catch (PDOException $e) {
        $error = "Lỗi truy vấn: " . $e->getMessage();
    }
}

$sql = "SELECT * FROM user WHERE role = 2";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
                            <h1 class="m-0">Người Dùng</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("../user_business/user_list.php");
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