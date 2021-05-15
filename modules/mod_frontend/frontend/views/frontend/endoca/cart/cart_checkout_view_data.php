<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\ProductUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\service\CartHelper;

$symbol = "";
$orderChargeInfo = SessionUtil::get("orderChargeInfo");
$orderSurcharges = SessionUtil::get("orderSurcharge");
$order = SessionUtil::get("order");
$discountCode = RequestUtil::get("discountCode");
$listOrderProduct = null;
if (!is_null(SessionUtil::get("listOrderProduct"))) {
	$listOrderProduct = SessionUtil::get("listOrderProduct")->getArray();
}
$orderProductVos = SessionUtil::get("listOrderProduct");
$orderTotalVos = CartHelper::generateOrderTotalList($orderSurcharges, $orderProductVos, $order);
?>
<div class="light">
    <div class="container">
        <div class="row">
            <div class="box col-xs-12" style="padding-right: 0px; padding-left: 0px">
                <h1><?= Lang::get("Cart") ?></h1>
                <div class="headline_steps checkout-step tabs">
                    <div class="col-sm-3 active">
                        <a
                                href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>"><?= Lang::get("1. Cart") ?></a>
                    </div>
                    <div class="col-sm-3 ">
                        <a
                                href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/shipping/view") ?>"><?= Lang::get("2. Shipping") ?></a>
                    </div>
                    <div class="col-sm-3">
                        <span><?= Lang::get("3. Payment") ?></span>
                    </div>
                    <div class="col-sm-3">
                        <span><?= Lang::get("4. Complete") ?></span>
                    </div>
                    <div class="clear" style="padding: 0px !important;"></div>
                </div>
                <div class="shopping-cart cart_block">
                    <form name="cart">
                        <div class="cart-products-reload">
                            <table>
                                <tbody>
                                <tr>
                                    <th></th>
                                    <th><?= Lang::get("Product") ?></th>
                                    <th class="center"><?= Lang::get("Price") ?></th>
                                    <th style="width: 75px;" class="center"><?= Lang::get("Amount") ?></th>
                                    <th class="center"><?= Lang::get("Sum") ?></th>
                                    <th class="center"><?= Lang::get("Subscription") ?></th>
                                    <th class="center"><?= Lang::get("Remove") ?></th>
                                </tr>
								<?php
								if (isset ($listOrderProduct) && count($listOrderProduct) > 0) {
									$symbol = $listOrderProduct [0]->symbol;
									foreach ($listOrderProduct as $orderProduct) {
										$basePrice = $orderProduct->basePrice;
										$price = ($orderProduct->price / $orderProduct->quantity);
										$imageMo = DatoImageHelper::getImageInfoById(json_decode($orderProduct->productImage) [0]);
										?>
                                        <tr>
                                            <td class="image">
                                                <a
                                                        href="<?= ActionUtil::getFullPathAlias("product/detail?id=$orderProduct->productId", new ProductUrlFriendly($orderProduct->languageCode, $orderProduct->productId, $orderProduct->seoUrl, $orderProduct->name)) ?>">
                                                    <img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>"
                                                         alt="" width="117" height="140">
                                                </a>
                                            </td>
                                            <td class="name">
                                                <a
                                                        href="<?= ActionUtil::getFullPathAlias("product/detail?id=$orderProduct->productId", new ProductUrlFriendly($orderProduct->languageCode, $orderProduct->productId, $orderProduct->seoUrl, $orderProduct->name)) ?>"><?= $orderProduct->name ?></a>
                                            </td>
                                            <td class="price">
												<?php
												if ($price < $basePrice) {
													?>
                                                    <div><?= ControllerHelper::showProductPrice($price) ?></div>
                                                    <span><?= ControllerHelper::showProductPrice($basePrice) ?></span>
													<?php
												} else {
													?>
                                                    <div><?= ControllerHelper::showProductPrice($basePrice) ?></div>
													<?php
												}
												?>
                                            </td>
                                            <td class="quantity">
                                                <div class="amount">
										<span class="frm_field frm_number"><input type="text"
                                                                                  class="form-control"
                                                                                  onchange="javascript:checkoutUpdateCart(<?= $orderProduct->productId ?>,($(this).val()-<?= $orderProduct->quantity ?>))"
                                                                                  value="<?= $orderProduct->quantity ?>"/></span>
                                                    <div class="plus_new arrow"
                                                         onclick="javascript:checkoutUpdateCart(<?= $orderProduct->productId ?>,1)">
                                                        +
                                                    </div>
                                                    <div class="minus_new arrow"
                                                         onclick="javascript:checkoutUpdateCart(<?= $orderProduct->productId ?>,-1)">
                                                        -
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price">
												<?php
												if ($price < $basePrice) {
													?>
                                                    <div><?= ControllerHelper::showProductPrice($orderProduct->price) ?></div>
                                                    <span><?= ControllerHelper::showProductPrice($orderProduct->basePrice * $orderProduct->quantity) ?></span>
													<?php
												} else {
													?>
                                                    <div><?= ControllerHelper::showProductPrice($orderProduct->basePrice * $orderProduct->quantity) ?></div>
													<?php
												}
												?>
                                            </td>
                                            <td class="as_shipping_column">
                                                <div class="as_no_shipping">No</div>
                                            </td>
                                            <td>
                                                <a
                                                        href="javascript:checkoutUpdateCart(<?= $orderProduct->productId ?>, -<?= $orderProduct->quantity ?>)"
                                                        class="cart-remove"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="break"></td>
                                        </tr>
										<?php
									}
								} else {
									?>
                                    <tr>
                                        <td colspan="7"><?= Lang::get("Your shopping cart is empty.") ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="break"></td>
                                    </tr>
									<?php
								}
								?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <form name="coupon" class="form-inline">
                        <div class="discount col-sm-4">
                            <h4><?= Lang::get("Do you have a discount code? Enter it here.") ?></h4>
							<?php
							if (RequestUtil::isFieldError("discountCode")) {
								?>
                                <ul class="message-stack">
                                    <li class="error"><?= RequestUtil::getFieldError("discountCode") ?>.</li>
                                </ul>
								<?php
							}
							?>
                            <span class="frm_field frm_text left"> <input type="text"
                                                                          name="discountCode" id="discountCodeId" value="<?= $discountCode ?>"
                                                                          placeholder="<?= Lang::get("Discount code...") ?>"
                                                                          required="required"/>
					</span>
                            <a class="button green margin-bottom-10" id="button-coupon"
                               onclick="javascript:applyDiscountCoupont()">
								<?= Lang::get("Submit") ?>
                            </a>
                        </div>


                    </form>
                    <div class="suma col-sm-6">
                        <div id="order_price_summary">
							<?php
							$arraySort = array(
								"subtotal" => "Subtotal",
								"coupon" => "Discount",
								"taxtotal" => "",
								"shipping" => "Shipping",
								"total" => "Grand Total"
							);
							foreach ($arraySort as $key => $value) {
								if (!isset ($orderTotalVos [$key])) {
									continue;
								}
								$orderTotalVo = $orderTotalVos [$key];
								$displayText = Lang::get($value);
								if (AppUtil::isEmptyString($value)) {
									$displayText = $orderTotalVo->title;
									$displayText = Lang::get(str_replace("@@", " + ", $displayText)) . " *";
								}
								?>
                                <span><?= $displayText ?></span>
								<?php if ("taxtotal" === $key) { ?>
                                    <br/>
                                    <span style="font-size: .6em"><?= Lang::get("* Based on the most recent billing / shipping address") ?></span>
                                    <br/>
								<?php } ?>
                                <div class="<?= ("total" === $key) ? "price sum" : "price" ?>"><?= ControllerHelper::showProductPrice($orderTotalVo->value) ?></div>

							<?php } ?>
                            <a href="#login" onclick="javascript:checkoutShipping()"
                               class="button continue" style="width: 40%; float: right;">
                                <span><?= Lang::get("Proceed to Checkout") ?></span></a>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		<?php
		$errMessage = RequestUtil::get('errMessage');
		if (!empty ($errMessage)) {

			echo 'showMessage("' . base64_decode($errMessage) . '", "error");';
		}

		?>
		$("div.navbar-header div.load-tpc").hide();

	});
	<?php
	$sessionCustomer = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
	?>
	function checkoutShipping(){
		<?php
		if (isset ($sessionCustomer)) {
		?>
		window.location.replace("<?=ActionUtil::getFullPathAlias("home/cart/checkout/shipping/view") ?>");
		<?php
		} else {
		?>
		$(document).ready(function(){
			showLoginDialog("login-tab");
		});
		<?php
		}
		?>
	}
	var urlApplyDiscountCoupon = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/discount/coupon/add") ?>?rtype=json";

	function applyDiscountError(res){
		$("#main").html(res.content);
	}

	function applySuccess(res){
		$("#main").html(res.content);
		showMessage("<?php Lang::get('Discount coupon is applied successfully!')?>");
	}

	function applyDiscountCoupont(){
		var data = {
			"discountCode": $("#discountCodeId").val()
		};
		simpleAjaxPost(
			guid(),
			urlApplyDiscountCoupon,
			data,
			applySuccess,
			applyDiscountError,
			applyDiscountError
		);
	}
</script>