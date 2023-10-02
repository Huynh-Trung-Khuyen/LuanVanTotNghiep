
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="../../public/index/index.php">Vegefoods</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <form method="GET" action="../../public/shop/search.php">
            <div class="searchbar">
                <input class="search_input" type="text" name="product_name" placeholder="Tìm Kiếm" style="width: 400px;">
            </div>
        </form>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Đấu Giá
                    </a>
                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="../../public/bid/bid.php">Phiên Đấu Giá</a>
                        <a class="dropdown-item" href="../../public/bid/add_bid.php">Thêm Đấu Giá</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danh Mục</a>
                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                        <?php foreach ($categories as $row) : ?>
                            <a class="dropdown-item" href="../../public/shop/category_menu.php?category_id=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']  ?></a>
                        <?php endforeach ?>
                    </div>
                </li>

                <?php
                if (!isset($_SESSION['user'])) : ?>

                    <li class="nav-item"><a href="../../public/account/login.php" class="nav-link">Đăng Nhập</a></li>
                    <li class="nav-item"><a href="../../public/account/register.php" class="nav-link">Đăng Ký</a></li>

                <?php endif ?>

                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($_SESSION['user']['role'] == 2) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['user']['name']; ?>
                            </a>
                            <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                <a class="dropdown-item" href="../../public/cart/checkout.php">Đơn Mua</a>
                                <a class="dropdown-item" href="../../public/business/business_info.php">Thông Tin Doanh Nghiệp</a>
                                <a class="dropdown-item" href="../../public/bid/bid_totals.php">Đơn Hàng Đấu Giá</a>
                                <a class="dropdown-item" href="../../public/bid/bid_manage.php">Quản Lý Phiên</a>
                                <a class="dropdown-item" href="../../public/account/logout.php">Đăng Xuất</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['user']['name']; ?>
                            </a>
                            <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                <a class="dropdown-item" href="../public/checkout.php">Đơn Mua</a>
                                <a class="dropdown-item" href="../../public/account/logout.php">Đăng Xuất</a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php
                include("../../partials/include/cart_cout.php"); ?>

            </ul>
        </div>
    </div>
</nav>