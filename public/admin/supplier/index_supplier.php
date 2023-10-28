<?php
session_start();

require_once '../../../config.php';

$items_per_page = 10;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$start_index = ($current_page - 1) * $items_per_page;

$query = $conn->prepare('
    SELECT * FROM supplier LIMIT :start, :items_per_page
');
$query->bindParam(':start', $start_index, PDO::PARAM_INT);
$query->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

$count_query = $conn->query('SELECT COUNT(*) FROM supplier');
$total_items = $count_query->fetchColumn();

$total_pages = ceil($total_items / $items_per_page);

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
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                                                <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </nav>

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