<h6>Liệt kê sản phẩm</h6>
<table class="table table-bordered text-center">
    <tr>
        <th class="text-success text-decoration-none">id</th>
        <th class="text-success text-decoration-none">Tên sản phẩm</th>
        <th class="text-success text-decoration-none">Hình ảnh</th>
        <th class="text-success text-decoration-none">Giá</th>
        <th class="text-success text-decoration-none">Nội dung</th>
    </tr>
    <?php foreach ($products as $row) : ?>
        <tr>
            <td><?php echo $row['product_id'] ?></td>
            <td><?php echo $row['product_name'] ?></td>
            <td><img src="../../uploads/<?php echo $row['image'] ?>" width="100px"></td>
            <td><?php echo $row['price'] ?>.000 vnđ</td>
            <td><?php echo $row['content'] ?></td>
            <td>
                <button type="button" class="btn btn-danger">
                    <a class="text-light text-decoration-none" href="../../admin/product/delete.php?id=<?php echo $row['product_id'] ?>">
                        Xóa
                    </a>
                    <button type="button" class="btn btn-success">
                        <a class="text-light text-decoration-none" href="../../admin/product/edit.php?id=<?php echo $row['product_id'] ?>">
                            Edit
                        </a>
            </td>
        <?php endforeach ?>
</table>