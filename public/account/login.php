<?php
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 1) {
        header('location: ../index/index.php');
    } else {
        header('location: ../index/index.php');
    }
    exit();
}

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Không được để trống!';
    } else {
        if (strlen($username) < 5 || strlen($username) > 50) {
            $error = 'Tài khoản phải từ 4 đến 50 kí tự!';
        }
        if (strlen($password) < 5 || strlen($password) > 50) {
            $error = 'Mật khẩu phải từ 4 đến 50 kí tự!';
        }
    }

    if (!isset($error)) {
        $query = $conn->prepare('SELECT user_id, username, password, fullname, role FROM user WHERE username = :username');
        $query->bindValue(':username', $username);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = 'Tài khoản không tồn tại!';
        } else {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'name' => $user['fullname'],
                    'role' => $user['role']
                ];

                $_SESSION['user_id'] = $user['user_id']; 

                if ($user['role'] == 1) {
                    header('location: ../index/index.php');
                } else {
                    header('location: ../index/index.php');
                }
                exit();
            } else {
                $error = 'Mật khẩu không đúng!';
            }
        }
    }
}

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
    <title>Login</title>
</head>

<body>
    <form method="POST" action="#">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-7">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">

                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Error!</strong> <?php echo $error ?>
                                </div>
                            <?php endif ?>

                            <h2 class="text-uppercase text-center mb-5">Login</h2>
                            <label for="username" class="sr-only">UserName</label>
                            <input type="text" id="username" class="form-control mb-4" placeholder="Nhập tên tài khoản của bạn" name="username" autofocus>
                            <label for="inputPassword" class="sr-only">Mật khẩu</label>
                            <input type="password" id="inputPassword" class="form-control mb-4" placeholder="Nhập mật khẩu của bạn" name="password" autofocus>

                            <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-center">Login</button>
                        </div>
                        <p class="text-center text-muted mt-5 mb-0">Don't have an account<a href="#!" class="fw-bold text-body"><u> Register here</u></a></p>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </form>
</body>

</html>