
<tbody>
	<tr class="text-center">
		<td class="order_name">
			<h5><?php echo $order['order_name']; ?></h5>
		</td>
		<td class="address">
			<h5><?php echo $order['address']; ?></h5>
		</td>
		<td class="city_address">
			<h5><?php echo $order['city_address']; ?></h5>
		</td>
		<td class="district_address">
			<h5><?php echo $order['district_address']; ?></h5>
		</td>
		<td class="phone">
			<h5><?php echo $order['phone']; ?></h5>
		</td>
		<td class="cart_total">
			<h5><?php echo $order['cart_total']; ?>.000vnđ</h5>
		</td>
		<td>
			<?php
			$query = "SELECT p.product_name, op.quantity_of_products
    		FROM ordered_products AS op
    		INNER JOIN product AS p ON op.product_id = p.product_id
    		WHERE op.order_id = :order_id";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':order_id', $order['order_id']);
			$stmt->execute();
			$products_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($products_info as $product_info) {
				$product_name = $product_info['product_name'];
				$quantity = $product_info['quantity_of_products'];
				echo "<h5>$quantity kg $product_name</h5>";
			}
			?>
		</td>

		<td class="">
			<h5>Đã Hủy Đơn Hàng</h5>
		</td>
	</tr>
</tbody>