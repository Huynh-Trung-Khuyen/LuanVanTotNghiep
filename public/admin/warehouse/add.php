<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imported_product_name = $_POST['imported_product_name'];
    $quantity = $_POST['quantity'];
    $input_day = $_POST['input_day'];
    $expired_date = $_POST['expired_date'];

    if (empty($imported_product_name) || empty($quantity) || empty($input_day) || empty($expired_date)) {
        $error = 'Không được để trống!';
    } else {
        $query = $conn->prepare('
            INSERT INTO warehouse
            (imported_product_name, quantity, input_day, expired_date)
            VALUES
            (:imported_product_name, :quantity, :input_day, :expired_date)
        ');
        $query->bindParam(':imported_product_name', $imported_product_name);
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':input_day', $input_day);
        $query->bindParam(':expired_date', $expired_date);
        $query->execute();
        $success = 'Thêm sản phẩm vào kho thành công!';
    }
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
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Thêm Sản Phẩm Vào Kho</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="POST" class="" role="form">
                <div class="card-body">
                    <div class="form-group">
                        <label for="imported_product_name">Tên Sản Phẩm Nhập Kho</label>
                        <input type="text" name="imported_product_name" class="form-control" placeholder="Nhập tên sản phẩm nhập kho">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Số Lượng</label>
                        <input type="text" name="quantity" class="form-control" placeholder="Số lượng sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="input_day">Ngày Nhập Kho</label>
                        <input type="date" name="input_day" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="expired_date">Hạn Sử Dụng</label>
                        <input type="date" name="expired_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm Vào Kho</button>
                    </div>
                </div>
            </form>

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

</html>
