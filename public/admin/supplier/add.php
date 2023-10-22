<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $supplier_tax = $_POST['supplier_tax'];
    $agent = $_POST['agent'];

    if (empty($supplier_name) || empty($supplier_tax) || empty($agent)) {
        $error = 'Không được để trống!';
    } else {
        $query = $conn->prepare('
            INSERT INTO supplier
            (supplier_name, supplier_tax, agent)
            VALUES
            (:supplier_name, :supplier_tax, :agent)
        ');
        $query->bindParam(':supplier_name', $supplier_name);
        $query->bindParam(':supplier_tax', $supplier_tax);
        $query->bindParam(':agent', $agent);
        $query->execute();
        $success = 'Thêm nhà cung cấp thành công!';
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
                            <h1 class="m-0">Thêm Nhà Cung Cấp</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="POST" class="" role="form">
                <div class="card-body">
                    <div class="form-group">
                        <label for="supplier_name">Tên Nhà Cung Cấp</label>
                        <input type="text" name="supplier_name" class="form-control" placeholder="Nhập tên nhà cung cấp">
                    </div>
                    <div class="form-group">
                        <label for="supplier_tax">Mã Số Thuế</label>
                        <input type="text" name="supplier_tax" class="form-control" placeholder="Nhập mã số thuế">
                    </div>
                    <div class="form-group">
                        <label for="agent">Người Đại Diện</label>
                        <input type="text" name="agent" class="form-control" placeholder="Nhập tên người đại diện">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm Nhà Cung Cấp</button>
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
