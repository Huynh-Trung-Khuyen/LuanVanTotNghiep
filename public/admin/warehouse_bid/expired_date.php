<?php
session_start();

require_once '../../../config.php';

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$items_per_page = 10;

$start_index = ($current_page - 1) * $items_per_page;

$query = $conn->prepare('
    SELECT w.warehouse_bid_id, w.imported_bid_name, w.quantity, w.purchase_price, w.input_day, w.expired_date, w.seri_number, w.supplier_id, s.supplier_name
    FROM warehouse_bid w
    LEFT JOIN supplier s ON w.supplier_id = s.supplier_id
    WHERE w.expired_date >= CURDATE()
    ORDER BY w.seri_number
    LIMIT :start, :items_per_page
');
$query->bindParam(':start', $start_index, PDO::PARAM_INT);
$query->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$query->execute();
$warehouses = $query->fetchAll(PDO::FETCH_ASSOC);

$count_query = $conn->query('SELECT COUNT(*) FROM warehouse_bid WHERE expired_date <= CURDATE()');
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
                    <div class "row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="warehouseTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Số Seri</th>
                                                <th>ID Kho</th>
                                                <th>Tên Sản Phẩm Nhập Kho</th>
                                                <th>Số Lượng</th>
                                                <th>Giá</th>
                                                <th>Ngày Nhập</th>
                                                <th>HSD</th>
                                                <th>Nhà Cung Cấp</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($warehouses as $warehouse) : ?>
                                                <tr>
                                                    <td><?php echo $warehouse['seri_number']; ?></td>
                                                    <td><?php echo $warehouse['warehouse_bid_id']; ?></td>
                                                    <td><?php echo $warehouse['imported_bid_name']; ?></td>
                                                    <td><?php echo $warehouse['quantity']; ?>Kg</td>
                                                    <td><?php echo number_format($warehouse['purchase_price'], 0, '.', '.'); ?>.000vnđ</td>
                                                    <td><?php echo $warehouse['input_day']; ?></td>
                                                    <td><?php echo $warehouse['expired_date']; ?></td>
                                                    <td><?php echo $warehouse['supplier_name']; ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?php echo $warehouse['warehouse_bid_id']; ?>"><i class="fas fa-edit"></i></a>
                                                        <a href="delete.php?id=<?php echo $warehouse['warehouse_bid_id']; ?>"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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

