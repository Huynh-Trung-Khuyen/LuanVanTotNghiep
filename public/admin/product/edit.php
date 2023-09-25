<?php
session_start();

require_once '../../../config.php';

$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
$query->bindParam(':id', $id);
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $content = $_POST['content'];
    $price = $_POST['price'];

    // Kiểm tra xem người dùng đã tải lên hình ảnh mới hay chưa
    if (!empty($_FILES['hinhanh']['name'])) {
        $image = $_FILES['hinhanh']['name'];
        $image_tmp_name = $_FILES['hinhanh']['tmp_name'];
        
        // Di chuyển tệp tải lên và cập nhật cơ sở dữ liệu
        move_uploaded_file($image_tmp_name, '../../uploads/' . $image);
        $query = $conn->prepare('UPDATE product SET product_name=:product_name, content=:content, price=:price, image=:image WHERE product_id = :id');
        $query->bindParam(':image', $image);
    } else {
        // Không tải lên hình ảnh mới, không cần cập nhật cột 'image' trong cơ sở dữ liệu
        $query = $conn->prepare('UPDATE product SET product_name=:product_name, content=:content, price=:price WHERE product_id = :id');
    }

    // Thực hiện cập nhật cơ sở dữ liệu
    $query->bindParam(':id', $id);
    $query->bindParam(':product_name', $product_name);
    $query->bindParam(':content', $content);
    $query->bindParam(':price', $price);
    $query->execute();

    header('location:./index_product.php');
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
            $product_id = $_GET['id'];
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Sửa Sản Phẩm</h1>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>

            <?php
            if (isset($_GET['id'])) {
                $product_id = $_GET['id'];
            }
            ?>
            <?php foreach ($products as $row) : ?>
                <form action="#" method="POST" class="" role="form" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu">Tên Sản Phẩm</label>
                                    <input type="text" name="product_name" value="<?php echo $row['product_name'] ?>" class="form-control" placeholder="Nhập tên sản phẩm">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="text" name="price" value="<?php echo $row['price'] ?>" class="form-control" placeholder="Giá Sản Phẩm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nội Dung</label>
                            <input type="text" name="content" value="<?php echo $row['content'] ?>" class="form-control" placeholder="Nội Dung Sản Phẩm">
                        </div>
                        <div class="form-group">
                            <label for="menu">Ảnh Sản Phẩm</label>
                            <input type="file" name="hinhanh" value="" class="form-control">
                            <img src="../../uploads/<?php echo $row['image'] ?>" alt="" width="100px;">
                        </div>
                        <div class="card-footer">
                            
                            <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
                        </div>
                    </div>
                </form>
        </div>
    <?php endforeach ?>
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