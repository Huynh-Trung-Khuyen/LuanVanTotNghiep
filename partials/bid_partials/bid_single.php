<?php
function getProductBid($product_bid_id, $conn)
{
    $sql = "SELECT pb.*, 
           CONCAT('../../public/uploads/', pb.product_bid_image) AS product_image_path, 
           s.supplier_name AS supplier_name,
           pb.real_end_time,
           pb.product_bid_description,
           pb.end_time,
           b.user_id AS recent_bidder_id,
           u2.fullname AS recent_bidder_fullname
    FROM product_bid pb
    LEFT JOIN warehouse_bid wb ON pb.warehouse_bid_id = wb.warehouse_bid_id
    LEFT JOIN supplier s ON wb.supplier_id = s.supplier_id
    LEFT JOIN bid b ON pb.product_bid_id = b.product_bid_id
    LEFT JOIN user u2 ON b.user_id = u2.user_id
    WHERE pb.product_bid_id = :product_bid_id
    ORDER BY b.bid_time DESC LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_bid_id', $product_bid_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




if (isset($_GET['product_bid_id'])) {
    $product_bid_id = $_GET['product_bid_id'];
    $product_bid = getProductBid($product_bid_id, $conn);

    if (!$product_bid) {
        echo "Sản phẩm không tồn tại";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bid_price = $_POST['bid_price'];
        $user_id = $_SESSION['user_id'];

        $sql = "UPDATE product_bid SET winner_id = :user_id WHERE product_bid_id = :product_bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_bid_id', $product_bid_id);
        if ($stmt->execute()) {
        } else {
            $error_message = "Đã có lỗi xảy ra khi cập nhật winner_id.";
        }

        if ($bid_price > $product_bid['current_price']) {
            $sql = "INSERT INTO bid (product_bid_id, user_id, bid_price) VALUES (:product_bid_id, :user_id, :bid_price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_bid_id', $product_bid_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':bid_price', $bid_price);

            if ($stmt->execute()) {
                $sql = "UPDATE product_bid SET current_price = :bid_price WHERE product_bid_id = :product_bid_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':bid_price', $bid_price);
                $stmt->bindParam(':product_bid_id', $product_bid_id);
                $stmt->execute();
            } else {
                echo "Đã có lỗi xảy ra khi thêm lượt đặt giá mới.";
            }
        } else {
            echo "Giá đặt phải lớn hơn giá hiện tại.";
        }
    }
} else {
    echo "Không có phiên đấu giá.";
    exit;
}


// Hiển thị các doanh nghiệp tham gia
$productBidId = isset($_GET['product_bid_id']) ? $_GET['product_bid_id'] : null;

if ($productBidId !== null) {
    $sqlCountPaidUsers = "
        SELECT COUNT(DISTINCT user_id) AS total_paid_users
        FROM deposit
        WHERE product_bid_id = :productBidId
    ";

    $stmtCountPaidUsers = $conn->prepare($sqlCountPaidUsers);
    $stmtCountPaidUsers->bindParam(':productBidId', $productBidId, PDO::PARAM_INT);
    $stmtCountPaidUsers->execute();

    $resultCountPaidUsers = $stmtCountPaidUsers->fetch(PDO::FETCH_ASSOC);

    $totalPaidUsers = $resultCountPaidUsers['total_paid_users'];
    if ($totalPaidUsers > 0) {
        $sqlGetUserFullName = "
            SELECT DISTINCT u.fullname
            FROM deposit d
            INNER JOIN user u ON d.user_id = u.user_id
            WHERE d.product_bid_id = :productBidId
        ";

        $stmtGetUserFullName = $conn->prepare($sqlGetUserFullName);
        $stmtGetUserFullName->bindParam(':productBidId', $productBidId, PDO::PARAM_INT);
        $stmtGetUserFullName->execute();
        $userFullNames = $stmtGetUserFullName->fetchAll(PDO::FETCH_COLUMN);
    } else {
    }
} else {
}

?>
<html>
<style>
    .quantity-adjust.btn {
        background-color: #fff;
        color: #000;
        transition: background-color 0.3s, color 0.3s;
    }

    .quantity-adjust.btn:hover i {
        color: #82ae46;
    }
</style>

<head>
    <title>Đấu giá sản phẩm</title>
</head>

<body>
    <section class="contact-section bg-light">

        <div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="winnerModalLabel">Thông Báo Đến Người Chiến Thắng</h5>
                    </div>
                    <div class="modal-body">
                        <p>Chúc mừng bạn đã giành chiến thắng trong phiên đấu giá!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../../public/bid/bid.php" class="btn btn-primary">Quay về trang đấu giá</a>
                        <a href="../../public/bid/bid_totals2.php" class="btn btn-secondary">Xem các phiên đấu giá đã thắng</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loserModal" tabindex="-1" role="dialog" aria-labelledby="loserModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loserModalLabel">Tiếc quá</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Rất tiếc, một doanh nghiệp khác đã dành chiến thắng</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../../public/bid/bid.php" class="btn btn-primary">Quay về trang đấu giá</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center  pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Cửa Hàng Nông Sản Sạch</span>
                    <h2 class="mb-4">Phiên Đấu Giá: <?php echo $product_bid['product_bid_name'] ?></h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form method="POST" class="bg-white p-5 contact-form">
                        <div class="form-group text-center">
                            <h2><?php echo $product_bid['product_bid_name'] ?></h2>
                        </div>
                        <div class="form-group text-center">
                            <h4 class="time"><span>Thời gian còn lại: <span id="countdown"></span></h4>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 170px;">Giá Khởi Điểm:</span>
                                </div>
                                <div class="form-control" style="font-size: 25px; white-space: nowrap; overflow: hidden; text-overflow: clip;">
                                    <?php echo number_format($product_bid['start_price'], 0, '.', '.') ?>.000vnđ
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px; ">Giá Hiện Tại:</span>
                                </div>
                                <div class="form-control" id="current_price" style="font-size: 25px; ">
                                    <?php echo number_format($product_bid['current_price'], 0, '.', '.') ?>.000vnđ
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px; ">Người ra giá gần đây:</span>
                                </div>
                                <div class="form-control" id="recent_bidder_fullname" style="font-size: 25px; ">
                                    <?php echo $product_bid['recent_bidder_fullname'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bid_price">Giá đặt mới:</label>
                            <div id="bidButton" class="input-group" style="width: 450px;">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-adjust btn btn-lg " data-type="minus" data-field="bid_price">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                </span>
                                <input type="text" name="bid_price" id="bid_price" class="form-control" style="font-size: 20px;" required value="<?php echo ($product_bid['current_price']) ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:80px;">.000vnđ</span>
                                </div>
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-adjust btn btn-lg" data-type="plus" data-field="bid_price">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <input type="submit" id="bidButton" value="Đặt giá" class="btn btn-primary py-3 btn-block">
                    </form>
                </div>

                <!-- Ảnh SP -->
                <div class="col-md-6 mb-6 d-flex">
                    <img src="<?php echo $product_bid['product_image_path'] ?>" class="img-fluid" alt="Colorlib Template" style="width: auto; height: auto;">
                </div>

            </div>

        </div>

        <section class="ftco-section contact-section bg-light">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Thông Tin Phiên Đấu Giá</h2>
                </div>
            </div>
            <div class="container">
                <div class="row d-flex mb-5 contact-info">
                    <div class="w-100"></div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <h5><span style="font-weight: bold;">Nhà Cung Cấp:</span><br> <?php echo $product_bid['supplier_name'] ?></h5>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <h5><span style="font-weight: bold;">Thời Gian Kết Thúc:</span><br> <?php echo $product_bid['real_end_time'] ?></h5>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <h5><span style="font-weight: bold;">Đã Có <?php echo "$totalPaidUsers"; ?> Doanh Nghiệp Tham Gia:</span><br></h5>

                            <?php if ($totalPaidUsers > 0) : ?>
                                <ul>
                                    <?php foreach ($userFullNames as $fullName) : ?>
                                        <li>
                                            <h5><?php echo $fullName; ?></h5>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p>Chưa Có Doanh Nghiệp Nào Tham Gia</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="info bg-white p-4">
                            <h5><span style="font-weight: bold;">Thông Tin Phiên Đấu Giá:</span><br> <?php echo $product_bid['product_bid_description'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </section>
</body>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateProductDetails() {
            $.ajax({
                url: '../../partials/bid_partials/update_product_details.php',
                type: 'POST',
                data: {
                    product_bid_id: <?php echo $product_bid_id; ?>
                },
                success: function(data) {
                    console.log(data);
                    var details = JSON.parse(data);
                    $("#current_price").text(details.current_price);
                    $("#recent_bidder_fullname").text(details.recent_bidder_fullname);
                }
            });
        }

        updateProductDetails();
        setInterval(updateProductDetails, 1000);
    });
</script>



<!-- Khi thời gian kết thúc sẽ so sánh ID của người thắng với ID của người đang đăng nhập -->
<script>
    let winnerId = <?php echo $product_bid['winner_id']; ?>;
    let userId = <?php echo $_SESSION['user_id']; ?>;

    // console.log('Initial winnerId:', winnerId);
    // console.log('Initial userId:', userId);

    function getWinnerId(productBidId) {
        $.ajax({
            type: 'GET',
            url: '../../partials/bid_partials/get_winner.php',
            data: {
                product_bid_id: productBidId
            },
            dataType: 'json',
            success: function(response) {
                winnerId1 = response.winner_id;
                userId = <?php echo $_SESSION['user_id']; ?>;
                console.log('Updated winnerId:', winnerId1);
                console.log('Updated userId:', userId);
            },
            error: function() {
                console.log('Failed to retrieve winnerId.');
            }
        });
    }

    getWinnerId(<?php echo $product_bid_id; ?>);

    setInterval(function() {
        getWinnerId(<?php echo $product_bid_id; ?>);
    }, 1000);

    function redirectOnTimeout(endTime, winnerId, userId) {
        const currentTime = new Date().getTime();
        const remainingTime = endTime - currentTime;
        const bidButton = document.getElementById("bidButton");
        if (remainingTime <= 0) {

            if (bidButton) {
                bidButton.style.display = "none";
            }
            if (winnerId1 === userId) {
                $('#winnerModal').modal('show');
            } else {
                $('#loserModal').modal('show');
            }
        } else {
            setTimeout(function() {
                redirectOnTimeout(endTime, winnerId, userId);
            }, 1000);
        }
    }

    const endTime = new Date("<?php echo $product_bid['real_end_time']; ?>").getTime();
    redirectOnTimeout(endTime, winnerId, userId);
</script>


<!-- Hiển thị thời gian dạng đếm ngược -->
<script>
    function startCountdown() {
        const endTime = new Date("<?php echo $product_bid['real_end_time']; ?>").getTime();

        function updateCountdown() {
            const currentTime = new Date().getTime();
            const remainingTime = endTime - currentTime;

            if (remainingTime <= 0) {
                document.getElementById("countdown").innerHTML = "Đã kết thúc";
            } else {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    startCountdown();
</script>


<!-- Nút Tăng Giảm -->
<script>
    $(document).ready(function() {
        $('.quantity-adjust').click(function() {
            var fieldType = $(this).data('field');
            var quantityField = $('#' + fieldType);
            var currentValue = parseFloat(quantityField.val());

            if (!isNaN(currentValue)) {
                if ($(this).data('type') === 'plus') {
                    quantityField.val(currentValue + 100);
                } else if ($(this).data('type') === 'minus') {
                    quantityField.val(Math.max(currentValue - 100, 0));
                }
            }
        });
    });
</script>


<!-- Giới hạn giá đặt -->
<script>
    $(document).ready(function() {

        $("form").submit(function(event) {
            event.preventDefault();
            var bidPrice = parseFloat($("#bid_price").val());
            var currentPrice = parseFloat(<?php echo $product_bid['current_price']; ?>);
            if (bidPrice <= currentPrice + 99) {
                alert("Giá đặt phải lớn hơn giá hiện tại ít nhất 100.000vnđ");
            } else if (bidPrice >= currentPrice + 1100) {
                alert("Giá đặt không được lớn hơn 1.000.000vnđ");
            } else {
                this.submit();
            }
        });
    });
</script>



</html>