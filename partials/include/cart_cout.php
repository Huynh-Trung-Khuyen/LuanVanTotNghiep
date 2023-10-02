<li class="nav-item cta cta-colored">
    <a href="../../public/cart/cart.php" class="nav-link">
        <span class="icon-shopping_cart"></span><span id="cart-count"></span>
    </a>
</li>

<script>
function updateCartCount() {
    $.ajax({
        url: '../../partials/include/get_cart_count.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#cart-count').text('[' + data.cart_count + ']');
        },
        error: function() {
            console.error('Đã có lỗi xảy ra trong quá trình gửi yêu cầu AJAX.');
        }
    });
}

updateCartCount();

setInterval(updateCartCount, 1000); 
</script>
