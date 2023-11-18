<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
}


?>

<body>
    <div class="container">
        <h3>Tạo mới đơn hàng</h3>
        <div class="table-responsive">
            <form action="../../partials/business/vnpay_create_payment.php" id="frmCreateOrder" method="post">
                <div class="form-group">
                    <label for="amount">Số tiền Cần Thanh Toán</label>
                    <h3>
                        <?php
                        $displayAmount = isset($amount) ? number_format(substr($amount, 0, -2)) . '.VNĐ' : '.VNĐ';
                        echo $displayAmount;
                        ?>
                    </h3>


                    <div hidden class="input-group">
                        <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="number" value="<?php echo isset($amount) ? $amount : 10000; ?>" readonly />
                        <div class="input-group-append">
                            <span class="input-group-text" id="vnd">.VNĐ</span>
                        </div>
                    </div>
                </div>

                <h4 hidden>Chọn phương thức thanh toán</h4>
                <div hidden class="form-group">
                    <h5>Cách 1: Chuyển hướng sang Cổng VNPAY chọn phương thức thanh toán</h5>
                    <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
                    <label for="bankCode">Cổng thanh toán VNPAYQR</label><br>

                    <h5>Cách 2: Tách phương thức tại site của đơn vị kết nối</h5>
                    <input type="radio" id="bankCode" name="bankCode" value="VNPAYQR">
                    <label for="bankCode">Thanh toán bằng ứng dụng hỗ trợ VNPAYQR</label><br>

                    <input type="radio" id="bankCode" name="bankCode" value="VNBANK">
                    <label for="bankCode">Thanh toán qua thẻ ATM/Tài khoản nội địa</label><br>

                    <input type="radio" id="bankCode" name="bankCode" value="INTCARD">
                    <label for="bankCode">Thanh toán qua thẻ quốc tế</label><br>

                </div>
                <div hidden class="form-group">
                    <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
                    <input type="radio" id="language" Checked="True" name="language" value="vn">
                    <label for="language">Tiếng việt</label><br>
                    <input type="radio" id="language" name="language" value="en">
                    <label for="language">Tiếng anh</label><br>

                </div>
                <button type="submit" class="btn btn-success" href>Thanh toán</button>
            </form>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY 2023</p>
        </footer>
    </div>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var amountInput = document.getElementById('amount');
        var vndSpan = document.getElementById('vnd');

        amountInput.addEventListener('input', function() {
            var inputValue = amountInput.value;

            // Kiểm tra xem giá trị hiện tại có phải là số không
            if (!isNaN(inputValue)) {
                // Ẩn đi 2 số cuối
                var hiddenValue = inputValue.slice(0, -2) + 'XX';
                amountInput.value = hiddenValue;

                // Hiển thị ".VNĐ" bên cạnh giá trị ẩn đi 2 số cuối
                vndSpan.textContent = '.VNĐ';
            }
        });
    });
</script>