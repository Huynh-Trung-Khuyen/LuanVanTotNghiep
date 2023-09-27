<?php
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../public/account/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city_address = $_POST['city_address'];
    $district_address = $_POST['district_address'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email_address = $_POST['email_address'];

    try {

        $sql = "INSERT INTO business (user_id, city_address, district_address, address, phone, email_address)
                    VALUES (:user_id, :city_address, :district_address, :address, :phone, :email_address)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':city_address', $city_address);
        $stmt->bindParam(':district_address', $district_address);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email_address', $email_address);

        if ($stmt->execute()) {
            echo "Thông tin doanh nghiệp đã được thêm thành công!";
        } else {
            echo "Lỗi khi thêm thông tin doanh nghiệp.";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <label for="city_address">Địa chỉ thành phố:</label>
    <input type="text" name="city_address" required><br>

    <label for="district_address">Địa chỉ quận/huyện:</label>
    <input type="text" name="district_address" required><br>

    <label for="address">Địa chỉ chi tiết:</label>
    <input type="text" name="address" required><br>

    <label for="phone">Số điện thoại:</label>
    <input type="text" name="phone" required><br>

    <label for="email_address">Email:</label>
    <input type="email" name="email_address" required><br>

    <input type="submit" value="Thêm Doanh Nghiệp">
</form>