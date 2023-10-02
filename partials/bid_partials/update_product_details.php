<?php
session_start();
require_once '../../config.php'; // Thay thế bằng đúng đường dẫn đến tệp cấu hình của bạn

if (isset($_POST['product_bid_id'])) {
    include '../../partials/bid_partials/your_getProductBid_function.php'; // Thay thế bằng đúng đường dẫn đến tệp chứa hàm getProductBid()
    $product_bid_id = $_POST['product_bid_id'];
    $product_bid = getProductBid($product_bid_id, $conn);

    if ($product_bid) {
        // Tạo một mảng chứa thông tin mới
        $response = array(
            'current_price' => number_format($product_bid['current_price'], 0, '.', '.') . '.000vnđ',
            'recent_bidder_fullname' => $product_bid['recent_bidder_fullname']
        );

        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($response);
    }
}
?>
