<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="../../public/index/index.php"><i class="fa-solid fa-seedling"></i>FarmBids</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <form method="GET" action="../../public/shop/search.php">
            <div class="searchbar">
                <input class="search_input" type="text" name="product_name" placeholder="Tìm Kiếm" style="width: 300px;">
            </div>
        </form>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($_SESSION['user']['role'] == 1) : ?>

                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            
                            $check_business_sql = "SELECT * FROM business WHERE user_id = :user_id";
                            $check_business_stmt = $conn->prepare($check_business_sql);
                            $check_business_stmt->bindParam(':user_id', $user_id);
                            $check_business_stmt->execute();

                            if ($check_business_stmt->rowCount() > 0) {
                        ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Đấu Giá
                                    </a>
                                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                        <a class="dropdown-item" href="../../public/bid/bid.php">Phiên Đấu Giá</a>
                                    </div>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Đấu Giá
                                    </a>
                                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                        <a href="#" data-toggle="modal" data-target="#infoModal" class="dropdown-item">
                                            Phiên Đấu Giá
                                        </a>
                                    </div>
                            <?php
                            }
                        }
                            ?>


                        <?php elseif ($_SESSION['user']['role'] == 0) : ?>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Đấu Giá
                                    </a>
                                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                        <a class="dropdown-item" href="../../public/bid/bid.php">Phiên Đấu Giá</a>
                                        <a class="dropdown-item" href="../../public/bid/add_bid.php">Thêm Đấu Giá</a>
                                        <a class="dropdown-item" href="../../public/bid/bid_manage.php">Quản Lý Giao Hàng</a>
                                        <a class="dropdown-item" href="../../public/bid/bid_confirm.php">Phiên Đấu Giá Kết Thúc</a>
                                        <a class="dropdown-item" href="../../public/bid/bid_all.php">Danh Sách Phiên Đấu Giá</a>
                                    </div>
                                </li>

                            <?php endif; ?>

                        <?php endif; ?>



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
                            <li class="nav-item"><a href="#" data-toggle="modal" data-target="#registerModal" class="nav-link">
                                    Đăng Ký
                                </a>
                            </li>

                        <?php endif ?>

                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 0) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php
                                        $username = $_SESSION['user']['name'];
                                        $maxUsernameLength = 10;
                                        if (strlen($username) > $maxUsernameLength) {
                                            $truncatedUsername = substr($username, 0, $maxUsernameLength) . '...';
                                            echo $truncatedUsername;
                                        } else {
                                            echo $username;
                                        }
                                        ?>
                                    </a>

                                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                        <a class="dropdown-item" href="../../public/cart/checkout.php">Đơn Mua</a>
                                        <a class="dropdown-item" href="../../public/bid/bid_totals.php">Đơn Mua Đấu Giá</a>
                                        <a class="dropdown-item" href="../../public/bid/bid_totals2.php">Đấu Giá Thành Công</a>
                                        <a class="dropdown-item" href="../../public/business/business_info.php">Thông Tin Doanh Nghiệp</a>
                                        <a class="dropdown-item" href="../../public/bid/history_bid.php">Lịch Sử Đấu Giá</a>
                                        <a class="dropdown-item" href="../../public/account/logout.php">Đăng Xuất</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <?php
                                    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
                                    }

                                    $user_id = $_SESSION['user_id'];

                                    $sql = "SELECT 
    b.business_id,
    b.user_id,
    u.fullname AS user_fullname,
    b.city_address,
    b.district_address,
    b.address,
    b.phone,
    b.email_address,
    b.money,
    b.tax_code  
FROM
    business AS b
JOIN
    user AS u
ON
    b.user_id = u.user_id
WHERE
    u.user_id = :user_id";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->execute();

                                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        include('../../partials/include/money.php');
                                    } else {
                                    }
                                    ?>
                                </li>

                            <?php else : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo $_SESSION['user']['name']; ?>
                                    </a>
                                    <div class="dropdown-menu" style="margin-top: 0px;" aria-labelledby="dropdown04">
                                        <a class="dropdown-item" href="../../public/cart/checkout.php">Đơn Mua</a>
                                        <a class="dropdown-item" href="../../public/account/logout.php">Đăng Xuất</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Hiển Thị Tiền -->





                        <?php
                        include("../../partials/include/cart_cout.php"); ?>

            </ul>
        </div>
    </div>
</nav>


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModal">Bạn Muốn Đăng Ký Loại Tài Khoản Nào?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="../../public/account/register.php" class="btn btn-primary btn-block">Tôi Là Khách</a>
                <a href="../../public/account/register_business.php" class="btn btn-secondary btn-block">Tôi Là Doanh Nghiệp</a>
            </div>
            <div class="modal-footer">
                <a href="../../public/account/login.php" class=" ">Đã có tài khoản</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModal">Bạn Cần Cập Nhật Thông Tin Doanh Nghiệp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="../../public/business/business_info.php" class="btn btn-primary btn-block">Điền Thông Tin Ngay</a>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>