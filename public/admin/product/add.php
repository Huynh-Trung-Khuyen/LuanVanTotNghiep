<?php
session_start();

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare('SELECT * FROM warehouse');
$query->execute();
$warehouses = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image_name = $_FILES['image']['name'];
    $warehouse_id = $_POST['warehouse_id'];

    if (empty($product_name) || empty($content) || empty($price)) {
        $error = 'Không được để trống!';
    } else {
        if (!empty($image_name)) {
            $tmp = $_FILES['image']['tmp_name'];
            $image_name = time() . $image_name;
            $new_path = '../../uploads/' . $image_name;

            if (move_uploaded_file($tmp, $new_path)) {
                $query = $conn->prepare('
                    INSERT INTO product
                    (product_name, content, price, image, category_id, warehouse_id)
                    VALUES
                    (:product_name, :content, :price, :image, :category_id, :warehouse_id)
                ');
                $query->bindParam(':product_name', $product_name);
                $query->bindParam(':content', $content);
                $query->bindParam(':price', $price);
                $query->bindParam(':image', $image_name);
                $query->bindParam(':category_id', $category_id);
                $query->bindParam(':warehouse_id', $warehouse_id);
                $query->execute();
                $success = 'Thêm sản phẩm thành công!';
            } else {
                $error = 'Upload ảnh thất bại!';
            }
        } else {
            $error = 'Ảnh không được để trống!';
        }
    }
}

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Các phần HTML giữ nguyên như trước -->

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
                            <h1 class="m-0">Thêm Sản Phẩm</h1>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>
            <form action="#" method="POST" class="" role="form" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Tên Sản Phẩm</label>
                                <input type="text" name="product_name" class="form-control" placeholder="Nhập tên sản phẩm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div>
                                <label>Giá</label>
                                <input type="text" name="price" class="form-control" placeholder="Giá Sản Phẩm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nội Dung</label>
                        <input type="text" name="content" class="form-control" placeholder="Nội Dụng">
                    </div>
                    <div class="form-group">
                        <label for="menu">Ảnh Sản Phẩm</label>
                        <input style="width: 500px;" type="file" name="image" required>
                    </div>

                    <div class="form-group">
                        <label>Danh Mục</label>
                        <select style="width: 500px;" name="category_id" id="category_id" class="form-control" required="required">
                            <?php foreach ($categories as $row) : ?>
                                <option value="<?php echo $row['category_id'] ?>"> <?php echo $row['category_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="warehouse_id">Nhà kho</label>
                        <select style="width: 500px;" name="warehouse_id" id="warehouse_id" class="form-control" required="required">
                            <?php foreach ($warehouses as $row) : ?>
                                <option value="<?php echo $row['warehouse_id'] ?>"><?php echo $row['imported_product_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if (isset($error)) : ?>
            <div style="width: 300px;" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php endif ?>

        <?php if (isset($success)) : ?>
            <div style="width: 300px;" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> <?php echo $success ?>
            </div>
        <?php endif ?>
    </div>
    <!-- ./wrapper -->

    <?php
    include("../include/footer.php");
    ?>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#category_id').select2({
            placeholder: "Chọn danh mục",
            allowClear: true,
            minimumInputLength: 0
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#warehouse_id').select2({
            placeholder: "Chọn nhà kho",
            allowClear: true,
            minimumInputLength: 0
        });
    });
</script>
<style>
    .select2-selection__clear {
        display: none !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 17px;
    }
</style>