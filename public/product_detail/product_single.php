<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
}
?>
<?php foreach ($products as $row) : ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 ">
                    <img src="../uploads/<?php echo $row['image'] ?>" class="img-fluid" alt="Colorlib Template">
                </div>
                <div class="col-lg-6 product-details pl-md-5">
                    <h3><?php echo $row['product_name'] ?></h3>

                    <p class="price"><span></strong><?php echo $row['price'] ?>.000 vnđ/Kg</span></p>
                    <p><?php echo $row['content'] ?></p>
                    <div class="row mt-4">
                        <div class="w-100"></div>
                        <div class="input-group col-md-6 d-flex mb-3">
                            <span class="input-group-btn mr-2">
                                <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                    <i class="ion-ios-remove"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                            <span class="input-group-btn ml-2">
                                <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                    <i class="ion-ios-add"></i>
                                </button>
                            </span>
                        </div>
                        <div class="w-100"></div>
                        
                    </div>
                    <p><a href="cart.html" class="btn btn-black py-3 px-5 ml-4">Add to Cart</a></p>
                </div>
            </div>
        </div>
    </section>
<?php endforeach ?>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.quantity-left-minus').click(function () {
            var quantityField = $(this).closest('.input-group').find('.input-number');
            var currentValue = parseInt(quantityField.val());
            if (!isNaN(currentValue) && currentValue > 1) {
                quantityField.val(currentValue - 1);
            }
        });

        $('.quantity-right-plus').click(function () {
            var quantityField = $(this).closest('.input-group').find('.input-number');
            var currentValue = parseInt(quantityField.val());
            if (!isNaN(currentValue)) {
                quantityField.val(currentValue + 1);
            }
        });
    });
</script>
