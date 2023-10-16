<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $city_address = $_POST['city_address'];
    $district_address = $_POST['district_address'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email_address = $_POST['email_address'];
    $tax_code = $_POST['tax_code'];

    try {
        $sql = "UPDATE business 
                SET city_address = :city_address, 
                    district_address = :district_address, 
                    address = :address, 
                    phone = :phone, 
                    email_address = :email_address,
                    tax_code = :tax_code
                WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':city_address', $city_address);
        $stmt->bindParam(':district_address', $district_address);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':tax_code', $tax_code);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            header('Location: ./index_business.php');
            exit();
        } else {
            echo "Lỗi khi cập nhật thông tin doanh nghiệp.";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}


$user_id = $_GET['user_id'];
$businessQuery = $conn->prepare('SELECT * FROM business WHERE user_id = :user_id');
$businessQuery->bindParam(':user_id', $user_id);
$businessQuery->execute();
$businessInfo = $businessQuery->fetch(PDO::FETCH_ASSOC);



?>

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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Người Dùng</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <label for="city_address">Địa chỉ thành phố:</label>
                <input type="text" name="city_address" value="<?php echo $businessInfo['city_address']; ?>" required><br>

                <label for="district_address">Địa chỉ quận/huyện:</label>
                <input type="text" name="district_address" value="<?php echo $businessInfo['district_address']; ?>" required><br>

                <label for="address">Địa chỉ chi tiết:</label>
                <input type="text" name="address" value="<?php echo $businessInfo['address']; ?>" required><br>

                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" value="<?php echo $businessInfo['phone']; ?>" required><br>

                <label for="email_address">Email:</label>
                <input type="email" name="email_address" value="<?php echo $businessInfo['email_address']; ?>" required><br>

                <label for="tax_code">Mã số thuế:</label>
                <input type="text" name="tax_code" value="<?php echo $businessInfo['tax_code']; ?>" maxlength="13" required><br>

                <input type="submit" value="Cập Nhật Thông Tin">
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