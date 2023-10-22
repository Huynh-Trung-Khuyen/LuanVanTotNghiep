<?php
session_start();

require_once '../../../config.php';

$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM warehouse WHERE warehouse_id = :id');
$query->bindParam(':id', $id);
$query->execute();
$warehouses = $query->fetchAll(PDO::FETCH_ASSOC);

// Khi nút Submit được nhấn
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imported_product_name = $_POST['imported_product_name'];
    $quantity = $_POST['quantity'];
    $input_day = $_POST['input_day'];
    $expired_date = $_POST['expired_date'];
    $seri_number = $_POST['seri_number'];

    $query = $conn->prepare('
        UPDATE warehouse
        SET imported_product_name = :imported_product_name, 
            quantity = :quantity, 
            input_day = :input_day, 
            expired_date = :expired_date, 
            seri_number = :seri_number
        WHERE warehouse_id = :id
    ');
    $query->bindParam(':id', $id);
    $query->bindParam(':imported_product_name', $imported_product_name);
    $query->bindParam(':quantity', $quantity);
    $query->bindParam(':input_day', $input_day);
    $query->bindParam(':expired_date', $expired_date);
    $query->bindParam(':seri_number', $seri_number);
    $query->execute();

    header('location:./index_warehouse.php');
}
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
        <?php
        if (isset($_GET['id'])) {
            $warehouse_id = $_GET['id'];
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Sửa Sản Phẩm</h1>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>
            <?php foreach ($warehouses as $row) : ?>
                <form action="#" method="POST" class="" role="form" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imported_product_name">Tên Sản Phẩm Nhập Kho</label>
                                    <input type="text" name="imported_product_name" value="<?php echo $row['imported_product_name'] ?>" class="form-control" placeholder="Nhập tên sản phẩm nhập kho">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Số Lượng</label>
                                    <input type="text" name="quantity" value="<?php echo $row['quantity'] ?>" class="form-control" placeholder="Số lượng sản phẩm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_day">Ngày Nhập Kho</label>
                            <input type="date" name="input_day" value="<?php echo $row['input_day'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="expired_date">Hạn Sử Dụng</label>
                            <input type="date" name="expired_date" value="<?php echo $row['expired_date'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="seri_number">Seri Number</label>
                            <input type="text" name="seri_number" value="<?php echo $row['seri_number'] ?>" class="form-control" placeholder="Nhập Seri Number">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
                        </div>
                    </div>
                </form>
            <?php endforeach ?>
        </div>

        <?php if (isset($error)) : ?>
            <div style="width: 300px;" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Lỗi!</strong> <?php echo $error ?>
            </div>
        <?php endif ?>

        <?php if (isset($success)) : ?>
            <div style="width: 300px;" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Thành Công!</strong> <?php echo $success ?>
            </div>
        <?php endif ?>
    </div>
    <!-- ./wrapper -->

    <?php
    include("../include/footer.php");
    ?>
</body>
<?php
    include("../include/footer.php");
    ?>
</html>
