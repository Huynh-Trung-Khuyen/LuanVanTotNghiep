<?php
session_start();

require_once '../../config.php';

$query = $conn->prepare('SELECT * FROM category');
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

$products = [];
$selectedProduct = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->prepare('SELECT * FROM product WHERE product_id = :id LIMIT 1');
    $query->bindParam(':id', $id);
    $query->execute();
    $selectedProduct = $query->fetch(PDO::FETCH_ASSOC);
}

$query = $conn->prepare('SELECT * FROM product');
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['vnp_Amount'])) {
    $vnp_Amount = $_GET['vnp_Amount'];

    // Loại bỏ 3 số 0 cuối cùng
    $vnp_Amount = substr($vnp_Amount, 0, -5);

    // Kiểm tra xác thực secure hash
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    if ($secureHash == $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            // Cộng tiền vào cơ sở dữ liệu
            $user_id = $_SESSION['user_id'];
            $query = $conn->prepare('SELECT business_id FROM business WHERE user_id = :user_id');
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $business_id = $row['business_id'];
                $query = $conn->prepare('UPDATE business SET money = money + :vnp_Amount WHERE business_id = :business_id');
                $query->bindParam(':vnp_Amount', $vnp_Amount);
                $query->bindParam(':business_id', $business_id);
                $query->execute();
                header("Location: ../../public/business/business_info.php");
            } else {
                echo "Không tìm thấy doanh nghiệp cho người dùng này";
            }
        } else {
            echo "<span style='color:red'>GD Không thành công</span>";
        }
    } else {
        echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include("../../partials/include/head.php");
?>

<body class="goto-here">

    <?php
    include("../../partials/include/navbar.php");
    ?>

    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>
                <label><?php echo $_GET['vnp_TxnRef'] ?></label>
            </div>
            <div class="form-group">
                <label>Số tiền:</label>
                <label><?php echo $_GET['vnp_Amount'] ?></label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $_GET['vnp_BankCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo $_GET['vnp_PayDate'] ?></label>
            </div>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y') ?></p>
        </footer>
    </div>

</body>
<?php
  include("../../partials/include/footer.php");
    ?>
</html>
