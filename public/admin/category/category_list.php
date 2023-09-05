<?php if (!empty($categories)) : ?>
<table class="table">
    <thead>
        <tr>
            <th style="width: 100px">ID</th>
            <th style="width: 200px">Tên Sản Phẩm</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $row) : ?>
            <tr>
                <td><?php echo $row['category_id']  ?></td>
                <td><?php echo $row['category_name']  ?></td>
                <td>
                    <a class="btn btn-primary btn-sm" href="../../admin/category/edit.php?id=<?php echo $row['category_id'] ?>">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a  class="btn btn-danger btn-sm" href="../../admin/category/delete.php?id=<?php echo $row['category_id'] ?>">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php endif ?>