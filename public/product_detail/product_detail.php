<?php
session_start();

require_once '../../config.php';
$id = $_GET['id'];
$query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
$query->bindParam(':id', $id);
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
  <title>Trang chủ</title>
</head>

<body>
  <div class="container">
    <?php
    include("../../partials/navbar.php");
    ?>


    <?php
    if (isset($_GET['id'])) {
      $product_id = $_GET['id'];
    }
    ?>
    <?php foreach ($products as $row) : ?>
      <section class="py-5">
            <div class="container px-lg-5 ">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div  class="col-md-6">
                      <img width="400px" height="400px" class="card-img-top mb-5 mb-md-0"
                     src="../uploads/<?php echo $row['image'] ?>">
                    </div>
                    <div class="col-md-6 text-success">
                        <h1 class="display-5 fw-bolder"> <?php echo $row['product_name'] ?></h1>
                        <div class="fs-5 mb-5">
                           <div class="m-bot15"> <strong>Giá : </strong><?php echo $row['price'] ?>.000 vnđ</div>
                        </div>
                        <p class="lead"><?php echo $row['content'] ?></p>
                        <div class="d-flex">
                        <button class="btn btn-round btn-success" type="button">Thêm vào giỏ hàng</button>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach ?>




    <?php
    include("../../partials/footer.php");
    ?>

  </div>

</body>

</html>