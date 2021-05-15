<?php
use core\Lang;
use core\utils\RequestUtil;

$regions = RequestUtil::get ( "showRegionList" );
$orderStatuses = RequestUtil::get ( "orderStatusList" );
$overview = RequestUtil::get ( "overview" );
$orders = RequestUtil::get ( "orders" );
$products = RequestUtil::get ( "topProducts" );
$countries = RequestUtil::get ( "topCountries" );
$filter = RequestUtil::get ( "filter" );
?>
<h3><?=Lang::get("Overview")?></h3>
<table border="1">
	<tr>
		<td>&nbsp;</td>
		<?php
		foreach ( $regions as $region ) {
			echo "<td align='center' colspan='2'>" . $region->name . "</td>";
		}
		?>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<?php
		foreach ( $regions as $region ) {
			echo "<td align='center'>Sales(" . $region->currencyCode . ")</td>";
			echo "<td align='center'>#orders</td>";
		}
		?>
	</tr>
	<?php
	foreach ( $orderStatuses as $orderStatus ) {
		echo "<tr>";
		echo "<td>" . $orderStatus->name . "</td>";
		foreach ( $regions as $region ) {
			$key = $orderStatus->id . "_" . $region->id;
			echo "<td align='right'>" . $overview [$key]->orderTotal . "</td>";
			echo "<td align='right'>" . $overview [$key]->orderCount . "</td>";
		}
		echo "</tr>";
	}
	?>
</table>
<br />
<br />
<h3><?=Lang::get("Orders")?></h3>
<table border="1">
	<tr>
		<td><?=Lang::get("Order ID")?></td>
		<td><?=Lang::get("MEGA ID")?></td>
		<td><?=Lang::get("Order Status")?></td>
		<td><?=Lang::get("Shipping Status")?></td>
		<td><?=Lang::get("Currency")?></td>
		<td><?=Lang::get("Region")?></td>
		<td><?=Lang::get("First Name")?></td>
		<td><?=Lang::get("Last Name")?></td>
		<td><?=Lang::get("User Email")?></td>
		<td><?=Lang::get("Cust Type")?></td>
		<td><?=Lang::get("User Type")?></td>
		<td><?=Lang::get("Shipping Method")?></td>
		<td><?=Lang::get("Shipping Country")?></td>
		<td><?=Lang::get("Payment Method")?></td>
		<td><?=Lang::get("Bill Country")?></td>
		<td><?=Lang::get("Coupon Code")?></td>
		<td><?=Lang::get("Shipping Title")?></td>
		<td><?=Lang::get("Tax Title")?></td>
		<td><?=Lang::get("Product Amt")?></td>
		<td><?=Lang::get("Discount Amt")?></td>
		<td><?=Lang::get("Coupon Amt")?></td>
		<td><?=Lang::get("Tax Amt")?></td>
		<td><?=Lang::get("Shipping Amt")?></td>
		<td><?=Lang::get("Total Amt")?></td>
		<td><?=Lang::get("Paid Amt")?></td>
		<td><?=Lang::get("Created Date")?></td>
		<td><?=Lang::get("Updated Date")?></td>
	</tr>
	<?php
	if (empty ( $orders )) {
		?>
	<tr>
		<td colspan="27"><?=Lang::get("No data available...")?></td>
	</tr>
		<?php
	} else {
		foreach ( $orders as $order ) {
			?>
	<tr>
		<td><?=$order->id?></td>
		<td><?=$order->megaId?></td>
		<td><?=$order->orderStatusName?></td>
		<td><?=$order->shippingStatusName?></td>
		<td><?=$order->currencyCode?></td>
		<td><?=$order->regionName?></td>
		<td><?=$order->firstName?></td>
		<td><?=$order->lastName?></td>
		<td><?=$order->email?></td>
		<td><?=$order->customerType?></td>
		<td><?=$order->accountType?></td>
		<td><?=$order->shippingMethod?></td>
		<td><?=$order->shippingCountry?></td>
		<td><?=$order->paymentMethod?></td>
		<td><?=$order->billingCountry?></td>
		<td><?=$order->couponCode?></td>
		<td><?=$order->shippingTitle?></td>
		<td><?=$order->taxTitle?></td>
		<td align="right"><?=number_format($order->productAmount,2)?></td>
		<td align="right"><?=number_format($order->discountAmount,2)?></td>
		<td align="right"><?=number_format($order->couponAmount,2)?></td>
		<td align="right"><?=number_format($order->taxAmount,2)?></td>
		<td align="right"><?=number_format($order->shippingAmount,2)?></td>
		<td align="right"><?=number_format($order->totalAmount,2)?></td>
		<td align="right"><?=number_format($order->paidAmount,2)?></td>
		<td><?=$order->crDate?></td>
		<td><?=$order->mdDate?></td>
	</tr>
		<?php
		}
	}
	?>
</table>
<br />
<br />
<h3><?=Lang::get("Top Products")?></h3>
<table border="1">
	<tr>
		<td><?=Lang::get("Product")?></td>
		<td><?=Lang::get("Quantity")?></td>
	</tr>
	<?php
	if (empty ( $products )) {
		?>
	<tr>
		<td colspan="2"><?=Lang::get("No data available...")?></td>
	</tr>
		<?php
	} else {
		foreach ( $products as $product ) {
			?>
	<tr>
		<td><?=$product->name?></td>
		<td align="right"><?=$product->quantity?></td>
	</tr>
		<?php
		}
	}
	?>
</table>
<br />
<br />
<h3><?=Lang::get("Top Countries")?></h3>
<table border="1">
	<tr>
		<td><?=Lang::get("Country")?></td>
		<td><?=Lang::get("Total Order")?></td>
		<td><?=Lang::get("Paid Amt")?></td>
	</tr>
	<?php
	if (empty ( $countries )) {
		?>
	<tr>
		<td colspan="2"><?=Lang::get("No data available...")?></td>
	</tr>
		<?php
	} else {
		foreach ( $countries as $country ) {
			?>
	<tr>
		<td><?=$country->name?></td>
		<td align="right"><?=$country->orderCount?></td>
		<td align="right"><?=number_format($country->paidAmount,2)?></td>
	</tr>
		<?php
		}
	}
	?>
</table>