<?php
session_start();
require_once '../../../config.php';

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$query = $conn->prepare('SELECT p.product_id, p.product_name, p.price, p.image, p.warehouse_id, p.category_id, w.imported_product_name, c.category_name, w.quantity, w.supplier_id
                          FROM product p
                          LEFT JOIN warehouse w ON p.warehouse_id = w.warehouse_id
                          LEFT JOIN category c ON p.category_id = c.category_id');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách nhà cung cấp từ cơ sở dữ liệu
$query = $conn->prepare('SELECT * FROM supplier');
$query->execute();
$suppliers = $query->fetchAll(PDO::FETCH_ASSOC);

$itemsPerPage = 10;
$totalItems = count($products);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentpage - 1) * $itemsPerPage;
$end = $start + $itemsPerPage;

$productsToDisplay = array_slice($products, $start, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("../include/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("../include/sidebar.php"); ?>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Danh Sách Sản Phẩm</h1>
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
                                    <table id="productTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Sản Phẩm</th>
                                                <th>Tên Sản Phẩm</th>
                                                <th>Giá</th>
                                                <th>Ảnh</th>
                                                <th>Tên Sản Phẩm Nhập Kho</th>
                                                <th>Danh Mục</th>
                                                <th>Số Lượng</th>
                                                <th>Nhà Cung Cấp</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productsToDisplay as $product) : ?>
                                                <tr>
                                                    <td><?php echo $product['product_id']; ?></td>
                                                    <td><?php echo $product['product_name']; ?></td>
                                                    <td><?php echo $product['price']; ?>.000vnđ/Kg</td>
                                                    <td><a href="" target="_blank"><img src="../../uploads/<?php echo $product['image']; ?>" height="100px" width="100px"></a></td>
                                                    <td><?php echo $product['imported_product_name']; ?></td>
                                                    <td><?php echo $product['category_name']; ?></td>
                                                    <td><?php echo $product['quantity']; ?></td>
                                                    <td>
                                                        <?php
                                                        // Lấy tên nhà cung cấp từ danh sách nhà cung cấp
                                                        $supplierId = $product['supplier_id'];
                                                        $supplierName = '';
                                                        foreach ($suppliers as $supplier) {
                                                            if ($supplier['supplier_id'] == $supplierId) {
                                                                $supplierName = $supplier['supplier_name'];
                                                                break;
                                                            }
                                                        }
                                                        echo $supplierName;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="../../admin/product/edit.php?id=<?php echo $product['product_id']; ?>"><i class="fas fa-edit"></i></a>
                                                        <a href="../../admin/product/delete.php?id=<?php echo $product['product_id']; ?>"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <ul class="pagination">
                                <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                    <li class="page-item<?php echo ($page == $currentpage) ? ' active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include("../include/footer.php"); ?>
</html>
