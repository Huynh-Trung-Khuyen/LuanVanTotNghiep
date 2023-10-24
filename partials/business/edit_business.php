<?php

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../../public/account/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $successMessage = 'Cập Nhật Thông Tin Thành Công';
        } else {
            $errorMessage = 'Cập Nhật Thông Tin Thất Bại :(((';
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}

$business_info = null;

try {
    $sql = "SELECT 
                    city_address,
                    district_address,
                    address,
                    phone,
                    email_address,
                    tax_code
                FROM business
                WHERE user_id = :user_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $business_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
}
?>

<?php if ($business_info) : ?>

    <div class="container">
        <br>
        <h2>Chỉnh sửa thông tin doanh nghiệp</h2>
        <form method="POST" action="#" class="form" role="form">
            <div class="form-group">
                <label for="city_address">Địa chỉ thành phố:</label>
                <input type="text" name="city_address" value="<?php echo $business_info['city_address']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="district_address">Địa chỉ quận/huyện:</label>
                <input type="text" name="district_address" value="<?php echo $business_info['district_address']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ chi tiết:</label>
                <input type="text" name="address" value="<?php echo $business_info['address']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" value="<?php echo $business_info['phone']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email_address">Email:</label>
                <input type="email" name="email_address" value="<?php echo $business_info['email_address']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tax_code">Mã số thuế:</label>
                <input type="text" name="tax_code" maxlength="13" value="<?php echo $business_info['tax_code']; ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
        </form>

    <?php else : ?>
        <p>Bạn chưa có thông tin doanh nghiệp. Hãy tạo thông tin doanh nghiệp trước.</p>
    <?php endif; ?>

    <!-- Success Modal -->
    <?php if (isset($successMessage)) : ?>
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thành công</h5>
                        <a href="../../public/business/business_info.php" class=" ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></a>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $successMessage; ?></p>
                        
                    </div>
                    <div class="modal-footer">
                        <a href="../../public/business/business_info.php" class=" ">Trở về trang thông tin</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Error Modal -->
    <?php if (isset($errorMessage)) : ?>
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lỗi</h5>
                        <a href="../../public/business/business_info.php" class=" ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></a>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $errorMessage; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <script>
        <?php if (isset($successMessage)) : ?>
            document.getElementById("successMessage").textContent = "<?php echo $successMessage; ?>";
            $("#successModal").modal("show");
        <?php endif; ?>

        <?php if (isset($errorMessage)) : ?>
            document.getElementById("errorMessage").textContent = "<?php echo $errorMessage; ?>";
            $("#errorModal").modal("show");
        <?php endif; ?>
    </script>