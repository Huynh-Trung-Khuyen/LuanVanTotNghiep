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
                                       
                                        <th>Xóa Người Dùng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo $user['user_id']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['fullname']; ?></td>
                                            

                                            
                                            <td>
                                                <form method="post" action="user_delete.php">
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