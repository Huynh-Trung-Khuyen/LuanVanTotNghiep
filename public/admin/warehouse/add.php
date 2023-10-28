<?php
session_start();

require_once '../../../config.php';

$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imported_product_name = $_POST['imported_product_name'];
    $quantity = $_POST['quantity'];
    $input_day = $_POST['input_day'];
    $expired_date = $_POST['expired_date'];
    $supplier_id = $_POST['supplier_id'];
    $seri_number = $_POST['seri_number'];
    $purchase_price = $_POST['purchase_price']; 

    if (empty($imported_product_name) || empty($quantity) || empty($input_day) || empty($expired_date) || empty($supplier_id) || empty($seri_number)) {
        $error = 'Không được để trống!';
    } else {
        $query = $conn->prepare('
            INSERT INTO warehouse
            (imported_product_name, quantity, input_day, expired_date, supplier_id, seri_number, purchase_price)  
            VALUES
            (:imported_product_name, :quantity, :input_day, :expired_date, :supplier_id, :seri_number, :purchase_price)  
        ');
        $query->bindParam(':imported_product_name', $imported_product_name);
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':input_day', $input_day);
        $query->bindParam(':expired_date', $expired_date);
        $query->bindParam(':supplier_id', $supplier_id);
        $query->bindParam(':seri_number', $seri_number);
        $query->bindParam(':purchase_price', $purchase_price); 
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
                        <label for="purchase_price">Giá Nhập Hàng</label>
                        <input type="text" name="purchase_price" class="form-control" placeholder=".000vnđ/kg">
                    </div>
                    <div class="form-group">
                        <label for="seri_number"> Số Seri Xe Hàng</label>
                        <input type="text" name="seri_number" class="form-control" placeholder="Nhập số seri xe hàng">
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
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm Vào Kho</button>
                        </div>
                        <div class="col-6 text-right">
                            <a href="./excel.php" class="btn btn-primary">Thêm Sản Phẩm Bằng File Excel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ./wrapper -->
</body>
<?php
include("../include/footer.php");
?>

</html>