<?php
use core\utils\RequestUtil;
?>
<h3>This is product page</h3>
<?php
// Lay danh sach san pham tu bien cua Product Controller.
$products = RequestUtil::get ( "products" )->getArray ();
if (isset ( $products ) && count ( $products ) > 0) {
	foreach ( $products as $product ) {
		?>
		Id: <?=$product->productId?>,
		Name: <?=$product->productName?><br />
<?php
	}
} else {
	?>
<h3>No data available...</h3>
<?php
}
?>