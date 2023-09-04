<?php
session_start();

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image_name = $_FILES['image']['name'];

    if (empty($product_name) or empty($content) or empty($price)) {
        $error = 'Không được để trống!';
    }

    if (!empty($image_name)) {

        $tmp = $_FILES['image']['tmp_name']; //tránh upload ảnh trùng tên
        $image_name = time() . $image_name;
        $new_path = '../../uploads/' . $image_name;

        if (!move_uploaded_file($tmp, $new_path)) {
            $error = 'Upload ảnh thất bại!';
        } else {
            move_uploaded_file($tmp, $new_path);

            $query = $conn->prepare('
            INSERT INTO product
            (product_name, content, price, image, category_id)
            VALUES
            (:product_name, :content, :price, :image, :category_id)
            ');
            $query->bindParam(':product_name', $product_name);
            $query->bindParam(':content', $content);
            $query->bindParam(':price', $price);
            $query->bindParam(':image', $image_name);
            $query->bindParam(':category_id', $category_id);
            $query->execute();
            $success = 'Thêm sản phẩm thành công!';
        }
    } else {
        $error = 'Ảnh Không được để trống!';
    }
}

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<?php
include("./head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("./sidebar.php");
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
                            <div class="form-group">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Danh Mục</label>
                            <select style="width: 500px;" name="category_id" id="category_id" class="form-control" required="required">
                                <?php foreach ($categories as $row) : ?>
                                    <option value="<?php echo $row['category_id'] ?>"> <?php echo $row['category_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
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
    include("./footer.php");
    ?>
</body>

</html>