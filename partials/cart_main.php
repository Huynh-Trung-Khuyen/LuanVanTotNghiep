<section class="ftco-section ftco-cart">
	<div class="container">
		<div class="row">
			<div class="col-md-12 ftco-animate">
				<div class="cart-list">
					<table class="table">
						<thead class="thead-primary">
							<tr class="text-center">
								<th>&nbsp;</th>
								<th>Hình Ảnh</th>
								<th>Tên Sản Phẩm</th>
								<th>Giá</th>
								<th>Số Lượng</th>
								<th>Tổng giá tiền</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "
        SELECT c.cart_id, p.product_name, p.price, p.image, c.quantity_of_products
        FROM cart AS c
        INNER JOIN product AS p ON c.product_id = p.product_id
        WHERE c.user_id = :user_id
    ";
							$user_id = $_SESSION['user_id'];

							$stmt = $conn->prepare($query);
							$stmt->bindParam(':user_id', $user_id);
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$cart_id = $row['cart_id'];
								$product_name = $row['product_name'];
								$price = $row['price'];
								$image = $row['image'];
								$quantity_of_products = $row['quantity_of_products'];
								$total = $price * $quantity_of_products;
							?>
								<tr class="text-center">
									<td class="product-remove">
										<form method="POST" action="../public/delete_product.php">
											<input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
											<button type="submit" name="xoa_san_pham" class="btn btn-outline-danger" style="width: 60px;">Xóa</button>
										</form>
									</td>
									<td class="image-prod">
										<div class="img">
											<img src="../public/uploads/<?php echo $image; ?>" alt="" style="max-width: 100px; height: auto;">
										</div>
									</td>
									<td class="product_name">
										<h4><?php echo $product_name; ?></h4>
									</td>
									<td class="price"><?php echo $price; ?>.000 vnđ/Kg</td>
									<td class="quantity_of_products"><?php echo $quantity_of_products; ?>Kg</td>
									<td class="total">
										<?php echo number_format($total, 0, ',', '.'); ?>.000 vnđ
									</td>
								</tr>
							<?php } ?>
						</tbody>


					</table>
				</div>
			</div>
		</div>
		<?php
		include("../public/checkout.php");
		?>
	</div>
</section>