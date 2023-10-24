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
                        <li class="list-group-item"><strong>Tính Dụng:</strong> <?php echo $row['money']; ?>.000vnđ</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="./edit_info_b.php" class="btn btn-primary">Sửa Thông Tin Doanh Nghiệp</a>
                </div>
            </div>
        </div>
    </div>
</div>
