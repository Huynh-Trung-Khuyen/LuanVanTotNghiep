<table class="table">
    <thead>
        <tr>
            <th style="width: 100px">ID</th>
            <th style="width: 200px">Tên Sản Phẩm</th>
            <th style="width: 200px">Ảnh</th>
            <th style="width: 200px">Giá</th>
            <th>Nội Dung</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $row) : ?>
            <tr>
                <td><?php echo $row['product_id'] ?></td>
                <td><?php echo $row['product_name'] ?></td>
                <td><a href="" target="_blank">
                        <img src="../../uploads/<?php echo $row['image'] ?>" height="100px" width="100px">
                    </a>
                </td>
                <td><?php echo $row['price'] ?>.000vnđ/Kg</td>
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
            </tr>
        <?php endforeach ?>
    </tbody>
</table>