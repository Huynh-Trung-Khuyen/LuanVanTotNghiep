<?php
session_start();
require_once '../../config.php'; 

if (isset($_POST['product_bid_id'])) {
    include '../../partials/bid_partials/your_getProductBid_function.php';
    $product_bid_id = $_POST['product_bid_id'];
    $product_bid = getProductBid($product_bid_id, $conn);

    if ($product_bid) {
 
        $response = array(
            'current_price' => number_format($product_bid['current_price'], 0, '.', '.') . '.000vnđ',
            'recent_bidder_fullname' => $product_bid['recent_bidder_fullname']
        );

        echo json_encode($response);
    }
}
?>
