$(document).ready(function () {
    // Lặp lại việc gửi yêu cầu AJAX mỗi 5 giây
    setInterval(function () {
        // Sử dụng AJAX để gửi yêu cầu đến một tệp PHP để lấy thông tin cập nhật
        $.ajax({
            url: 'update_product.php',
            type: 'GET',
            data: { product_bid_id: productBidId }, // Sử dụng biến JavaScript
            success: function (data) {
                // Cập nhật thông tin sản phẩm từ dữ liệu trả về từ yêu cầu AJAX
                var productInfo = JSON.parse(data);

                // Cập nhật giá hiện tại
                $('#current_price').text('Giá hiện tại: ' + productInfo.current_price + '.000 vnđ');

                // Cập nhật thông tin người ra giá gần đây (nếu có)
                if (productInfo.recent_bidder_fullname) {
                    $('#recent_bidder').text('Người ra giá gần đây: ' + productInfo.recent_bidder_fullname);
                } else {
                    $('#recent_bidder').text('Chưa có người ra giá gần đây.');
                }
            },
            error: function () {
                console.error('Đã có lỗi xảy ra trong quá trình gửi yêu cầu AJAX.');
            }
        });
    }, 5000); // Cập nhật mỗi 5 giây
});
