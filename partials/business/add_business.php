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

        $sql = "INSERT INTO business (user_id, city_address, district_address, address, phone, email_address, tax_code)
                    VALUES (:user_id, :city_address, :district_address, :address, :phone, :email_address, :tax_code)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':city_address', $city_address);
        $stmt->bindParam(':district_address', $district_address);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':tax_code', $tax_code);

        if ($stmt->execute()) {
            $successMessage = 'Cập Nhật Thông Tin Thành Công';
        } else {
            $errorMessage = 'Cập Nhật Thông Tin Thất Bại :(((';
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
?>


<div class="container">
    <h2>Thêm Thông Tin Doanh Nghiệp</h2>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="city_address">Địa chỉ thành phố:</label>
                <input type="text" id="city_address" name="city_address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="district_address">Địa chỉ quận/huyện:</label>
                <input type="text" id="district_address" name="district_address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ chi tiết:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email_address">Email:</label>
                <input type="email" id="email_address" name="email_address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tax_code">Mã số thuế:</label>
                <input type="text" id="tax_code" name="tax_code" maxlength="13" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Doanh Nghiệp</button>
        </form>
    </div>
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