<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 ">
                <img src="<?php echo $product_bid['product_image_path'] ?>" class="img-fluid" alt="Colorlib Template">
            </div>
            <div class="col-lg-8 product-details pl-md-5">
                <h3>Tên sản phẩm: <?php echo $product_bid['product_bid_name'] ?></h3>
                <p class="price"><span>Người tạo phiên: </strong><?php echo $product_bid['creator_fullname'] ?></span></p>
                <p class="price"><span>Thời gian kết thúc: <?php echo $product_bid['real_end_time']; ?></span></p>

                <p class="price"><span>Giá khởi điểm: </strong><?php echo number_format($product_bid['start_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                <p class="price"><span>Giá hiện tại: </strong><?php echo number_format($product_bid['current_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                <p class="price"><span>Người ra giá gần đây: </strong><?php echo $product_bid['winner_fullname'] ?></span></p>
                <form method="POST">
                    <label for="bid_price">Giá đặt mới: </label>
                    <input type="text" name="bid_price" id="bid_price" required>
                    <input type="submit" value="Đặt giá">
                </form>
                <p>Giá đã được mặc định từ .000vnđ</p>
            </div>
        </div>
    </div>
</section>