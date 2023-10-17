<?php
function getProductBid($product_bid_id, $conn)
{
    $sql = "SELECT pb.*, 
           CONCAT('../../public/uploads/', pb.product_bid_image) AS product_image_path, 
           u.fullname AS creator_fullname, 
           pb.real_end_time,
           b.user_id AS recent_bidder_id,
           u2.fullname AS recent_bidder_fullname
    FROM product_bid pb
    LEFT JOIN user u ON pb.user_id = u.user_id
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
    <section class="ftco-section contact-section bg-light">
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
                        <div class="form-group ">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:130px; ">Giá Khởi Điểm:</span>
                                </div>
                                <div class="form-control" style="font-size: 25px; ">
                                    <?php echo number_format($product_bid['start_price'], 0, '.', '.') ?>.000vnđ
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:130px; ">Giá Hiện Tại:</span>
                                </div>
                                <div class="form-control" id="current_price" style="font-size: 25px; ">
                                    <?php echo number_format($product_bid['current_price'], 0, '.', '.') ?>.000vnđ
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bid_price">Giá đặt mới:</label>
                            <div class="input-group" style="width: 450px;">
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

                        <input type="submit" value="Đặt giá" class="btn btn-primary py-3 btn-block">
                    </form>
                </div>
                <div class="col-md-6  mb-5 d-flex">
                    <img src="<?php echo $product_bid['product_image_path'] ?>" class="img-fluid" alt="Colorlib Template">
                </div>
            </div>
        </div>
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

<!-- Hết thời gian tự động chuyển về trang chủ -->
<script>
    function redirectOnTimeout(endTime) {
        const currentTime = new Date().getTime();
        const remainingTime = endTime - currentTime;

        if (remainingTime <= 0) {
            window.location.href = '../../public/bid/bid.php';
        } else {
            setTimeout(function() {
                redirectOnTimeout(endTime);
            }, 1000);
        }
    }
    const endTime = new Date("<?php echo $product_bid['real_end_time']; ?>").getTime();
    redirectOnTimeout(endTime);
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