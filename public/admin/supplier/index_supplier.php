<?php
session_start();

require_once '../../../config.php';

$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Danh Sách Nhà Cung Cấp</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="supplierTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Nhà Cung Cấp</th>
                                                <th>Tên Nhà Cung Cấp</th>
                                                <th>Mã Số Thuế</th>
                                                <th>Tên Người Đại Diện</th>
                                                <th>Tùy Chỉnh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $supplier) : ?>
                                                <tr>
                                                    <td><?php echo $supplier['supplier_id']; ?></td>
                                                    <td><?php echo $supplier['supplier_name']; ?></td>
                                                    <td><?php echo $supplier['supplier_tax']; ?></td>
                                                    <td><?php echo $supplier['agent']; ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?php echo $supplier['supplier_id']; ?>"><i class="fas fa-edit"></i></a>
                                                        <a href="delete.php?id=<?php echo $supplier['supplier_id']; ?>"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include("../include/footer.php");
?>
</html>
