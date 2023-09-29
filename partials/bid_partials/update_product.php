<?php
session_start();

require_once '../../config.php';

// Kết nối đến cơ sở dữ liệu và lấy thông tin sản phẩm theo product_bid_id
// ...

// Xử lý dữ liệu và trả về dưới dạng JSON
$productInfo = array(
    'current_price' => $currentPrice,
    'recent_bidder_fullname' => $recentBidderFullname
);

echo json_encode($productInfo);
?>
