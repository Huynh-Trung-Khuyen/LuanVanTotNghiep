<?php
session_start();

require_once '../../../config.php';


$query = $conn->prepare('SELECT * FROM warehouse WHERE expired_date <= CURDATE()');
$query->execute();
$warehouses = $query->fetchAll(PDO::FETCH_ASSOC);
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
                            <h1 class="m-0">Danh Sách Kho Hàng</h1>
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
                                    <table id="warehouseTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Kho</th>
                                                <th>Tên Sản Phẩm Nhập Kho</th>
                                                <th>Số Lượng</th>
                                                <th>Ngày Nhập Kho</th>
                                                <th>Hạn Sử Dụng</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($warehouses as $warehouse) : ?>
                                                <tr>
                                                    <td><?php echo $warehouse['warehouse_id']; ?></td>
                                                    <td><?php echo $warehouse['imported_product_name']; ?></td>
                                                    <td><?php echo $warehouse['quantity']; ?></td>
                                                    <td><?php echo $warehouse['input_day']; ?></td>
                                                    <td><?php echo $warehouse['expired_date']; ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?php echo $warehouse['warehouse_id']; ?>"><i class="fas fa-edit"></i></a>
                                                        <a href="delete.php?id=<?php echo $warehouse['warehouse_id']; ?>"><i class="fas fa-trash"></i></a>
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
</body>
<?php
    include("../include/footer.php");
    ?>
</html>
