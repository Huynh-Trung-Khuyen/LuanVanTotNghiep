<?php
$itemsPerPage = 16;

$totalItems = count($products);
$totalPages = ceil($totalItems / $itemsPerPage);

$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($currentpage - 1) * $itemsPerPage;
$end = $start + $itemsPerPage;

?>


    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Cửa Hàng Nông Sản Sạch</span>
                <h2 class="mb-4">Các Sản Phẩm Của Chúng Tôi</h2>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 mb-5 text-center">
        <ul class="product-category">
    <li><a href="../public/category_menu.php">All</a></li>
    <?php foreach ($categories as $row) : ?>
        <li><a href="category_menu.php?category_id=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a></li>
    <?php endforeach; ?>
</ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php for ($i = $start; $i < $end && $i < count($products); $i++) : ?>
                <?php $product = $products[$i]; ?>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="product">
                        <a href="../public/product_detail.php?id=<?php echo $product['product_id'] ?>" class="img-prod">
                            <img class="img-fluid" src="../public/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" style="width: 100%; height: 250px;">
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3><a href="../public/product_detail.php?id=<?php echo $product['product_id'] ?>"><?php echo $product['product_name']; ?></a></h3>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="price"><span>
                                        <?php echo $product['price'] ?>.000vnđ/Kg
                                    </span></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <?php if ($currentpage > 1) : ?>
                            <li><a href="?page=<?php echo ($currentpage - 1); ?>">&lt;</a></li>
                        <?php endif; ?>
                        <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                            <li class="<?php echo ($page == $currentpage) ? 'active' : ''; ?>">
                                <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($currentpage < $totalPages) : ?>
                            <li><a href="?page=<?php echo ($currentpage + 1); ?>">&gt;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>