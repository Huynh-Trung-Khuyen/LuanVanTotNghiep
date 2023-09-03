<div class="col-3">
    <div class="list-group" id="list-tab">
    <?php foreach ($categories as $row) : ?>
        <a class="list-group-item list-group-item-action"><?php echo $row['category_name']  ?></a>
        <?php endforeach ?>
    </div>

