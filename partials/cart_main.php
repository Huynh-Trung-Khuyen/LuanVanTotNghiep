
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
							<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<tr class="text-center">
									<td class="product-remove">
										<form method="POST" action="../public/delete_product.php">
											<input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
											<button type="submit" name="xoa_san_pham" class="btn btn-outline-danger" style="width: 60px;">Xóa</button>
										</form>
									</td>

									<td class="image-prod">
										<div class="img">
											<img src="../public/uploads/<?php echo $row['image'] ?>" alt="" style="max-width: 100px; height: auto;">
										</div>
									</td>
									<td class="product_name">
										<h4><?php echo $row['product_name'] ?></h4>
									</td>
									<td class="price"><?php echo $row['price'] ?>.000 vnđ/Kg</td>
									<td class="quantity_of_products"><?php echo $row['quantity_of_products'] ?>Kg</td>
									<td class="total">
										<?php
										$price = $row['price'];
										$quantity_of_products = $row['quantity_of_products'];
										$total = $price * $quantity_of_products;
										echo number_format($total, 0, ',', '.') ?>.000 vnđ
									</td>
								</tr>
							<?php endwhile; ?>
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