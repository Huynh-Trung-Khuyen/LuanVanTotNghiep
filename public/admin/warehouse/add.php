<?php
session_start();

require_once '../../../config.php';


$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imported_product_name = $_POST['imported_product_name'];
    $quantity = $_POST['quantity'];
    $input_day = $_POST['input_day'];
    $expired_date = $_POST['expired_date'];
    $supplier_id = $_POST['supplier_id'];

    if (empty($imported_product_name) || empty($quantity) || empty($input_day) || empty($expired_date) || empty($supplier_id)) {
        $error = 'Không được để trống!';
    } else {
        $query = $conn->prepare('
            INSERT INTO warehouse
            (imported_product_name, quantity, input_day, expired_date, supplier_id)
            VALUES
            (:imported_product_name, :quantity, :input_day, :expired_date, :supplier_id)
        ');
        $query->bindParam(':imported_product_name', $imported_product_name);
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':input_day', $input_day);
        $query->bindParam(':expired_date', $expired_date);
        $query->bindParam(':supplier_id', $supplier_id);
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
                        <label for="supplier_id">Nhà Cung Cấp</label>
                        <select name="supplier_id" class="form-control">
                            <?php foreach ($suppliers as $row) : ?>
                                <option value="<?php echo $row['supplier_id'] ?>"><?php echo $row['supplier_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm Vào Kho</button>
                    </div>
                </div>
            </form>
        </div>
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
