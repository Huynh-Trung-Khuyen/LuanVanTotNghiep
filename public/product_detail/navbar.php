<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="../../public/index.php">Vegefoods</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="searchbar">
            <input class="search_input" type="text" name="" placeholder="Tìm Kiếm" style="width: 400px;">
            <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="../../public/index.php" class="nav-link">Trang Chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danh Mục</a>
                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                        <?php foreach ($categories as $row) : ?>
                            <a class="dropdown-item" href="#"><?php echo $row['category_name']  ?></a>
                        <?php endforeach ?>
                    </div>
                </li>

                <?php
                if (!isset($_SESSION['user'])) : ?>

                    <li class="nav-item"><a href="../../public/account/login.php" class="nav-link">Đăng Nhập</a></li>
                    <li class="nav-item"><a href="../../public/account/register.php" class="nav-link">Đăng Ký</a></li>

                <?php endif ?>

                <?php
                if (isset($_SESSION['user'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            echo $_SESSION['user']['name']
                            ?>
                        </a>
                        <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                            <a class="dropdown-item" href="../../public/account/logout.php">Đăng Xuất</a>
                        </div>
                    </li>
                <?php endif ?>
                <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
            </ul>
        </div>
    </div>
</nav>