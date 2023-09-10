
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Cửa Hàng Nông Sản Sạch</span>
                <h2 class="mb-4">Các Sản Phẩm Mà Bạn Đang Tìm Kiếm</h2>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-10 mb-5 text-center">
        <ul class="product-category">
    <li><a href="../public/index.php">All</a></li>
    <?php foreach ($categories as $row) : ?>
        <li><a href="category_menu.php?category_id=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a></li>
    <?php endforeach; ?>
</ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
        <?php foreach ($results as $row) : ?>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="product">
                        <a href="product_detail/product_detail.php?id=<?php echo $row['product_id'] ?>" class="img-prod">
                            <img class="img-fluid" src="../public/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" style="width: 100%; height: 250px;">
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3><a href="product_detail/product_detail.php?id=<?php echo $row['product_id'] ?>"><?php echo $row['product_name']; ?></a></h3>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="price"><span>
                                        <?php echo $row['price'] ?>.000vnđ/Kg
                                    </span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
        </div>
    </div>
</section>