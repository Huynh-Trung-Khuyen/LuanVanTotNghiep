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
        $image_name = time().$image_name;
        $new_path = '../../uploads/'.$image_name;

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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Trang Admin</title>
</head>

<body>
    <div class="container">
        <header class="d-flex  align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="../index.php" class="d-flex align-items-center col-md-0  mb-md-0 text-dark text-decoration-none">
                <img style="width: 130px; height: auto;" src="../../img/logo.png" alt="">
            </a>

            <form class="col-12 col-lg-7 mb-lg-0 text-center text-success">
                <h2>Quản lý sản phẩm</h2>
            </form>
            <a class="btn btn-outline-success me-2 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 160px;">
                <?php
                echo $_SESSION['user']['name']
                ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-center" href="../../account/logout.php">Thoát</a></li>
            </ul>
        </header>

        <div class=" nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 h3">
            <a href="../category/index_category.php" class="nav-link px-5 text-success">Thêm danh mục</a>
            <a href="./index_product.php" class="nav-link px-5 text-success">Thêm sản phẩm</a>
        </div>

        <?php if (isset($error)) : ?>
            <div style="width: 700px;" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php endif ?>

        <?php if (isset($success)) : ?>
            <div style="width: 700px;" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> <?php echo $success ?>
            </div>
        <?php endif ?>


        <?php
        include("./add.php");
        include("./product_list.php");
        ?>


    </div>
</body>

</html>