<?php


// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:../../public/account/login.php');
    exit;
}

// Lấy user_id của người đang đăng nhập
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $city_address = $_POST['city_address'];
    $district_address = $_POST['district_address'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email_address = $_POST['email_address'];

    try {
        // Thực hiện truy vấn SQL để cập nhật thông tin doanh nghiệp trong CSDL
        $sql = "UPDATE business 
                    SET city_address = :city_address, 
                        district_address = :district_address, 
                        address = :address, 
                        phone = :phone, 
                        email_address = :email_address
                    WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':city_address', $city_address);
        $stmt->bindParam(':district_address', $district_address);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            echo "Thông tin doanh nghiệp đã được cập nhật thành công!";
        } else {
            echo "Lỗi khi cập nhật thông tin doanh nghiệp.";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}

// Truy vấn thông tin doanh nghiệp hiện tại của người đang đăng nhập
$business_info = null;

try {
    $sql = "SELECT 
                    city_address,
                    district_address,
                    address,
                    phone,
                    email_address
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
    <form method="POST">
        <label for="city_address">Địa chỉ thành phố:</label>
        <input type="text" name="city_address" value="<?php echo $business_info['city_address']; ?>" required><br>

        <label for="district_address">Địa chỉ quận/huyện:</label>
        <input type="text" name="district_address" value="<?php echo $business_info['district_address']; ?>" required><br>

        <label for="address">Địa chỉ chi tiết:</label>
        <input type="text" name="address" value="<?php echo $business_info['address']; ?>" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" value="<?php echo $business_info['phone']; ?>" required><br>

        <label for="email_address">Email:</label>
        <input type="email" name="email_address" value="<?php echo $business_info['email_address']; ?>" required><br>

        <input type="submit" value="Cập Nhật Thông Tin">
    </form>
<?php else : ?>
    <p>Bạn chưa có thông tin doanh nghiệp. Hãy tạo thông tin doanh nghiệp trước.</p>
<?php endif; ?>