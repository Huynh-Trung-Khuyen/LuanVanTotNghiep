<?php if (!empty($categories)) : ?>

<h6>Liệt kê danh mục sản phẩm</h6>
<table class="table table-bordered text-center">
    <tr>
        <th class="text-success text-decoration-none">ID</th>
        <th class="text-success text-decoration-none">Tên danh mục</th>
        <th style="width: 250px;" class="text-success text-decoration-none">Xóa</th>
    </tr>

    <?php foreach ($categories as $row) : ?>
        <tr>
            <td><?php echo $row['category_id']  ?></td>
            <td><?php echo $row['category_name']  ?></td>
            <td>
                <button type="button" class="btn btn-danger">
                    <a class="text-light text-decoration-none" href="../../admin/category/delete.php?id=<?php echo $row['category_id']?>">
                        Xóa
                    </a>
                    <button type="button" class="btn btn-success">
                    <a class="text-light text-decoration-none" href="../../admin/category/edit.php?id=<?php echo $row['category_id']?>">
                        Edit
                    </a>   
            </td>
        </tr>
    <?php endforeach ?>
<?php endif ?>