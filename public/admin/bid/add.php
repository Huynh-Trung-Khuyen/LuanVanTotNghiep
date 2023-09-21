<?php
session_start();

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_bid_name = $_POST['product_bid_name'];
    $product_bid_description = $_POST['product_bid_description'];
    $start_price = $_POST['start_price'];
    $current_price = $start_price; // Ban đầu, current_price bằng start_price
    $end_time = $_POST['end_time'];

    if (empty($product_bid_name) || empty($product_bid_description) || empty($start_price) || empty($end_time)) {
        $error = 'Không được để trống!';
    } else {
        // Thực hiện thêm phiên đấu giá vào cơ sở dữ liệu
        $query = $conn->prepare('
            INSERT INTO product_bid
            (product_bid_name, product_bid_description, start_price, current_price, end_time)
            VALUES
            (:product_bid_name, :product_bid_description, :start_price, :current_price, :end_time)
        ');

        $query->bindParam(':product_bid_name', $product_bid_name);
        $query->bindParam(':product_bid_description', $product_bid_description);
        $query->bindParam(':start_price', $start_price);
        $query->bindParam(':current_price', $current_price);
        $query->bindParam(':end_time', $end_time);

        if ($query->execute()) {
            $success = 'Thêm phiên đấu giá thành công!';
        } else {
            $error = 'Thêm phiên đấu giá thất bại!';
        }
    }
}

require_once '../../../config.php';
$query = $conn->prepare('SELECT * FROM product_bid');
$query->execute();
$product_bids = $query->fetchAll(PDO::FETCH_ASSOC);
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
 
                        <div class="form-group">
                            <label>Danh Mục</label>
                            <select style="width: 500px;" name="category_id" id="category_id" class="form-control" required="required">
                                <?php foreach ($categories as $row) : ?>
                                    <option value="<?php echo $row['category_id'] ?>"> <?php echo $row['category_name'] ?></option>
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
    include("./footer.php");
    ?>
</body>

</html>