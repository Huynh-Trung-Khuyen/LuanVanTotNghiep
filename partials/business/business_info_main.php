<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Thông Tin Doanh Nghiệp</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Tên Doanh Nghiệp:</strong> <?php echo $row['user_fullname']; ?></li>
                        <li class="list-group-item"><strong>Thành Phố:</strong> <?php echo $row['city_address']; ?></li>
                        <li class="list-group-item"><strong>Quận/Huyện:</strong> <?php echo $row['district_address']; ?></li>
                        <li class="list-group-item"><strong>Địa Chỉ:</strong> <?php echo $row['address']; ?></li>
                        <li class="list-group-item"><strong>Số Điện Thoại:</strong> <?php echo $row['phone']; ?></li>
                        <li class="list-group-item"><strong>Địa Chỉ Email:</strong> <?php echo $row['email_address']; ?></li>
                        <li class="list-group-item"><strong>Mã Số Thuế:</strong> <?php echo $row['tax_code']; ?></li>
                        <li class="list-group-item"><strong>Tính Dụng:</strong> <?php echo number_format($row['money'], 0, ',', '.'); ?> Coin</li>

                    </ul>
                </div>
                <div class="card-footer">
                    <a href="./edit_info_b.php" class="btn btn-primary">Sửa Thông Tin Doanh Nghiệp</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Nạp Tiền <i class="fa-solid fa-coins"></i></h4>
                </div>
                <div class="card-body">
                    <form action="add_money_b.php" method="post" onsubmit="addZeros()">
                        <div class="form-group">
                            <label for="amount">Số Coin<i class="fa-solid fa-coins"></i> Bạn Muốn Nạp: (Mỗi 1.000vnđ = 1 Coin, Chỉ Được Nạp Từ 1.000.000vnđ Trở lên)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Nhập số tiền">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Nạp Coin</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function addZeros() {
        var amountInput = document.getElementById('amount');
        var currentAmount = amountInput.value;

        // Kiểm tra xem giá trị hiện tại có phải là số không
        if (!isNaN(currentAmount)) {
            // Thêm 5 số 0 vào giá trị
            var newAmount = parseFloat(currentAmount) * 100000;
            amountInput.value = newAmount;
        }
    }
</script>