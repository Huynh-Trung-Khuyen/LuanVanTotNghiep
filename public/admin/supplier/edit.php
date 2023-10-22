<?php
session_start();

require_once '../../../config.php';

$id = $_GET['id'];

$query = $conn->prepare('SELECT * FROM supplier WHERE supplier_id = :id');
$query->bindParam(':id', $id);
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

// Khi nút Submit được nhấn
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $supplier_tax = $_POST['supplier_tax'];
    $agent = $_POST['agent'];

    $query = $conn->prepare('
        UPDATE supplier
        SET supplier_name = :supplier_name, supplier_tax = :supplier_tax, agent = :agent
        WHERE supplier_id = :id
    ');
    $query->bindParam(':id', $id);
    $query->bindParam(':supplier_name', $supplier_name);
    $query->bindParam(':supplier_tax', $supplier_tax);
    $query->bindParam(':agent', $agent);
    $query->execute();

    header('location:./index_supplier.php');
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
            $supplier_id = $_GET['id'];
        }
        ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Chỉnh Sửa Nhà Cung Cấp</h1>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>
            <?php foreach ($suppliers as $row) : ?>
                <form action="#" method="POST" class="" role="form" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="supplier_name">Tên Nhà Cung Cấp</label>
                            <input type="text" name="supplier_name" value="<?php echo $row['supplier_name'] ?>" class="form-control" placeholder="Nhập tên nhà cung cấp">
                        </div>
                        <div class="form-group">
                            <label for="supplier_tax">Mã Số Thuế</label>
                            <input type="text" name="supplier_tax" value="<?php echo $row['supplier_tax'] ?>" class="form-control" placeholder="Nhập mã số thuế">
                        </div>
                        <div class="form-group">
                            <label for="agent">Người Đại Diện</label>
                            <input type="text" name="agent" value="<?php echo $row['agent'] ?>" class="form-control" placeholder="Nhập tên người đại diện">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật Nhà Cung Cấp</button>
                        </div>
                    </div>
                </form>
            <?php endforeach ?>
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
