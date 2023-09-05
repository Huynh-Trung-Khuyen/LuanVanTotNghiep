<?php
session_start();

require_once '../../../config.php';

$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM category WHERE category_id = :id');
$query->bindParam(':id', $id);
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);



// Khi nhan Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $query = $conn->prepare('UPDATE category SET category_name =:category_name  WHERE category_id = :id ');
    $query->bindParam(':id', $id);
    $query->bindParam(':category_name', $category_name);
    $query->execute();

    header('location:./index_category.php');
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
            $category_id = $_GET['id'];
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
            <?php foreach ($categories as $row) : ?>
                <form action="#" method="POST" class="" role="form" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu">Tên Danh Mục</label>
                                    <input type="text" name="category_name" value="<?php echo $row['category_name'] ?>" class="form-control" placeholder="Nhập tên sản phẩm">
                                </div>
                            </div>

                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Cập Nhật Danh Mục</button>
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