<br>
<form enctype="multipart/form-data" action="#" method="POST" class="form-inline mb-3" role="form">
    <table style="width: 700px;" class="table table-bordered">
        <tr>
            <td style="width: 200px;">Tên sản phẩm</td>
            <td><input style="width: 500px;" type="text" name="product_name"></td>
        </tr>
        <tr>
            <td style="width: 200px;">Nội dung</td>
            <td><textarea style="resize: none; width: 500px;" rows="5" name="content"></textarea></td>
        </tr>
        <tr>
            <td style="width: 200px;">Giá</td>
            <td><input style="width: 500px;" type="text" name="price"></td>
        </tr>
        <tr>
            <td style="width: 200px;">Hình ảnh</td>
            <td><input style="width: 500px;" type="file" name="image" required></td>
        </tr>
        <tr>
            <td style="width: 200px;">Danh mục</td>
            <td>
                <select style="width: 500px;" name="category_id" id="category_id" class="form-control" required="required">
                    <?php foreach ($categories as $row) : ?>
                        <option value="<?php echo $row['category_id'] ?>"> <?php echo $row['category_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" value="Thêm sản phẩm"></td>
        </tr>
    </table>
</form>