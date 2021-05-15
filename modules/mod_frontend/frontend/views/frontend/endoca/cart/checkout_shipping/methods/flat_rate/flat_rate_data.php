<?php
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$order = SessionUtil::get("order");
?>
<div>
    <h2><?= $shippingMethod->name ?></h2>

	<?php
	if (!is_null($shippingMethod->description) && !is_null($shippingMethod->description->shippingMethods) && count($shippingMethod->description->shippingMethods->getArray()) > 0) {
		?>
        <ul style="list-style-type: none;">
			<?php
			foreach ($shippingMethod->description->shippingMethods->getArray() as $shippingInfo) {
				$checked = " ";
				$shippingMethodInfo = "";
				if (!is_null($order) && !is_null($order->shippingMethodItem)) {
					$shippingMethodInfo = $order->shippingMethodItem;
				}
				if (JsonUtil::base64Encode($shippingInfo) === $shippingMethodInfo) {
					$checked = " checked ";
				}
				?>
                <li>
                    <input type="radio" data-value-cost='<?= $shippingInfo->cost ?>' data-value-object='<?= JsonUtil::base64Encode($shippingInfo) ?>' onclick="selectShippingMethod($(this),<?= $shippingInfo->cost ?>)" style="float: left;
																	    display: inline-block;
																	    margin-right: 10px;
																	    vertical-align: top;
																	    width: 15px;
																	    height: 15px;" class="input-radio" <?= $checked ?> name="order[shippingMethod]" value="<?= $shippingMethod->id ?>">
                    <div class="price"><?=ControllerHelper::showProductPrice($shippingInfo->cost) ?></div>
                    <label><?= $shippingInfo->name ?></label>
                </li>
				<?php
			}
			?>
        </ul>
		<?php
	}
	?>
</div>

