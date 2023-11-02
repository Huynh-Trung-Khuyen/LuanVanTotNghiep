<section class="content">
    <div class="container-fluid">
        <?php if (isset($users) && !empty($users)) : ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="orderTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tên Đăng Nhập</th>
                                        <th>Tên Người Dùng</th>
                                        <th>Thông tin</th>
                                        <th>Nhập thông tin</th>
                                        <th>Xóa Người Dùng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <?php
                                        $businessQuery = $conn->prepare('SELECT * FROM business WHERE user_id = :user_id');
                                        $businessQuery->bindParam(':user_id', $user['user_id']);
                                        $businessQuery->execute();
                                        $businessInfo = $businessQuery->fetch(PDO::FETCH_ASSOC);
                                        ?>

                                        <tr>
                                            <td><?php echo $user['user_id']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['fullname']; ?></td>  
                                            <td>
                                                <?php if ($businessInfo) : ?>
                                                    <?php if ($user['role'] == 1 && $businessInfo) : ?>
                                                        <strong>Thông tin doanh nghiệp:</strong><br>
                                                        Thành phố: <?php echo $businessInfo['city_address']; ?><br>
                                                        Quận/Huyện: <?php echo $businessInfo['district_address']; ?><br>
                                                        Địa chỉ: <?php echo $businessInfo['address']; ?><br>
                                                        Số điện thoại: <?php echo $businessInfo['phone']; ?><br>
                                                        Email: <?php echo $businessInfo['email_address']; ?><br>
                                                        Mã Số Thuế: <?php echo $businessInfo['tax_code']; ?><br>
                                                        Tính Dụng: <?php echo number_format(floatval(str_replace(',', '', $businessInfo['money']))) . '.000vnđ'; ?><br>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p>Doanh Nghiệp chưa cập nhật thông tin</p>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($businessInfo) : ?>
                                                   
                                                    <a href="./edit_business.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-primary">Sửa Thông Tin Doanh Nghiệp</a>
                                                <?php else : ?>
                                                    <a href="./add_business.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-success">Thêm thông tin</a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form method="post" action="business_delete.php">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                    <button type="submit" class="btn btn-danger" name="delete_user">Xóa Người Dùng</button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Không có người dùng nào.</p>
        <?php endif; ?>
    </div>
</section>