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

<head>
    <title>Đấu giá sản phẩm</title>
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <img src="<?php echo $product_bid['product_image_path'] ?>" class="img-fluid" alt="Colorlib Template">
                </div>
                <div class="col-lg-8 product-details pl-md-5">
                    <h3>Tên sản phẩm: <?php echo $product_bid['product_bid_name'] ?></h3>
                    <p class="price"><span>Người tạo phiên: <?php echo $product_bid['creator_fullname'] ?></span></p>
                    <p class="price"><span>Thời gian kết thúc: <span id="countdown"></span></p>
                    <p class="price"><span>Giá khởi điểm: <?php echo number_format($product_bid['start_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                    <p class="price"><span>Giá hiện tại: <span id="current_price"><?php echo number_format($product_bid['current_price'], 0, '.', '.') ?>.000 vnđ</span></p>
                    <p class="price"><span>Người ra giá gần đây: <span id="recent_bidder_fullname"><?php echo $product_bid['recent_bidder_fullname'] ?></span></p>

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
</html>