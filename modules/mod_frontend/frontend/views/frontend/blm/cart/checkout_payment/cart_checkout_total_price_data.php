<?php
use core\Lang;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;
use frontend\service\CartHelper;
use core\utils\AppUtil;
$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
$orderProductVos = SessionUtil::get ( "listOrderProduct" );
$order = SessionUtil::get ( "order" );
$orderTotalVos = CartHelper::generateOrderTotalList ( $orderSurcharges, $orderProductVos, $order )?>

<table>
	<tbody>
		<tr class="title">
			<td colspan="2"><?=Lang::get("Order Summary") ?></td>
		</tr>
		<?php
		$arraySort = array (
				"subtotal" => "Subtotal",
				"coupon" => "Discount",
				"taxtotal" => "",
				"shipping" => "Shipping",
				"total" => "Grand Total" 
		);
		foreach ( $arraySort as $key => $value ) {
			if (! isset ( $orderTotalVos [$key] )) {
				continue;
			}
			$orderTotalVo = $orderTotalVos [$key];
			$displayText = Lang::get($value);
			if (AppUtil::isEmptyString($value)){
				$displayText = $orderTotalVo->title;
				$displayText = Lang::get(str_replace("@@", "+<br/>", $displayText));
			}
			
			if ($orderTotalVo->type == "shipping" && $orderTotalVo->title == "Free Shipping"){
				$displayText = Lang::get($orderTotalVo->title)." (".Lang::get($orderTotalVo->subtitle).")";
			}
			?>
		<tr class="<?=$key?>">
			<td class="title"><?=$displayText?></td>
			<td class="price"><?=ControllerHelper::showProductPrice($orderTotalVo->value)?></td>
		</tr>
		<?php
		}
		
		?>
	</tbody>
</table>