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

    $query = $conn->prepare('UPDATE product SET product_name =:product_name, content=:content, price=:price WHERE product_id = :id ');
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
include("./head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("./sidebar.php");
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
                            <input type="text" name="content" value="<?php echo $row['content'] ?>" class="form-control" placeholder="Giá Sản Phẩm">
                        </div>
                        <!-- <div class="form-group">
                            <label for="menu">Ảnh Sản Phẩm</label>
                            <input type="file" class="form-control" id="upload">
                            <div id="image_show">
                                <a href="{{ $product->thumb }}" target="_blank">
                                    <img src="{{ $product->thumb }}" width="100px">
                                </a>
                            </div>
                            <input type="hidden" name="thumb" value="{{ $product->thumb }}" id="thumb">
                        </div> -->
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
    include("./footer.php");
    ?>
</body>

</html>