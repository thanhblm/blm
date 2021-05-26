<?php
use common\helper\DatoImageHelper;
use common\helper\SettingHelper;
use common\template\extend\TextArea;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use common\config\RegionEnum;

$order = SessionUtil::get("order");
$listAddressSuggest = RequestUtil::get("listAddressSuggest");
$listOrderProduct = null;
if (!is_null(SessionUtil::get("listOrderProduct"))) {
	$listOrderProduct = SessionUtil::get("listOrderProduct")->getArray();
}
$checkedSubcribe = "";
if("checked" == RequestUtil::get("subscribe")){
	$checkedSubcribe = "checked";
}
$termAndCondition = "";
if("checked" == RequestUtil::get("termAndCondition")){
	$termAndCondition = "checked";
}
?>
<div class="container no-padding">
    <div class="row">
        <div class="col-xs-9 no-padding" id="section_payment" style="margin-top: 21px;">
            <div class="headline_steps checkout-step tabs box _1of1 checkout_step_new"
                 style="background: #f8faff; font-size: 16px; border-bottom: 1px solid #dae5e5; -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); padding: 0;">
                <div class="col-sm-3 active">
                    <a
                            href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>"><?= Lang::get("1. Cart") ?></a>
                </div>
                <div class="col-sm-3 active">
                    <a
                            href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/shipping/view") ?>"><?= Lang::get("2. Shipping") ?></a>
                </div>
                <div class="col-sm-3 active">
                    <span><?= Lang::get("3. Payment") ?></span>
                </div>
                <div class="col-sm-3">
                    <span><?= Lang::get("4. Complete") ?></span>
                </div>
                <div class="clear" style="padding: 0px !important;"></div>
            </div>
            <div class="box col-xs-12  checkout-address checkout">
                <h2><?= Lang::get("Billing Address") ?></h2>
                <div class="address_selection">
                    <div id="divPaymentAddress">
						<?php include 'cart_checkout_payment_list_address_data.php'; ?>
                    </div>
                    <div class="box col-xs-12 address_form " id="addressReplace">
                        <!-- Load Address -->
                    </div>
                </div>
            </div>
            <div class="box col-xs-12 checkout " id="div_payment_method">
				<?php include 'cart_checkout_payment_method_list_data.php'; ?>
            </div>

            <div class="box col-xs-12 checkout " id="div_customer_comment">
				<?php
				$text = new TextArea ();
				$text->label = Lang::get("Comment");
				$text->name = "order[customerComment]";
				$text->value = $order->customerComment;
				$text->class = " ";
				$text->render();
				?>
            </div>
            
            <div class="box col-xs-12 checkout">
                <label>
                    <input type="checkbox" <?=$checkedSubcribe ?> name="subscribe" value="checked" style="float: left; display: inline-block; margin-right: 10px; vertical-align: top; width: 15px; height: 15px;">
                    <span>
                        <?= Lang::get("I would like to receive regular updates, news and and educational material about the benefits of CBD oil.<br/>(Your email address is safe, you can unsubscribe any time)")?></span>
                </label>
                <label><input type="checkbox" <?=$termAndCondition ?> name="termAndCondition" value="checked" style="float: left; display: inline-block; margin-right: 10px; vertical-align: top; width: 15px; height: 15px;">
                    <span></span>
                    <?= Lang::get("I have read and I agree with Endoca")?> <a href="<?=ActionUtil::getFullPathAlias("home/terms/and/conditions")?>" target="_blank"><?= Lang::get("Terms & conditions")?></a></label>
                <?php
                if (ControllerHelper::getRegionId() == RegionEnum::USA) {
                    ?>
                    <div class="g-recaptcha" data-sitekey="<?= SettingHelper::getSettingValue("Site key") ?>"
                         style="margin-top:20px"></div>
                    <?php
                }
                ?>
            </div>
            <div class="box col-xs-12 margin-top-10" style="padding-right: 0px">
                <div class="col-xs-4 col-xs-offset-8">
                    <a href="#login" onclick="javascript:checkoutPayment()" style="float: right;" class="button green pull-right">
                        <span><?= Lang::get("Proceed to Payment") ?></span></a>
                </div>
            </div>
        </div>
        <div class="col-xs-3 no-padding" style="float: right;">
            <div>
                <aside style="float: right;">
                    <div>
                        <article class="box _1of1 order-summary" id="div_total_price">
							<?php include 'cart_checkout_total_price_data.php'; ?>
                        </article>
                        <article class="box _1of1 cart-overview">
                            <table>
                                <tbody>
                                <tr class="title">
                                    <td colspan="3"><span><?= Lang::get("Cart") ?></span>
                                        <a
                                                href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>"
                                                class="button continue"><span><?= Lang::get("Edit") ?></span></a>
                                    </td>
                                </tr>
								<?php
								if (isset ($listOrderProduct) && count($listOrderProduct) > 0) {
									foreach ($listOrderProduct as $orderProduct) {
										$imageMo = DatoImageHelper::getImageInfoById(json_decode($orderProduct->productImage) [0]);
										?>
                                        <tr>
                                            <td><span class="photo" style="padding-left: 10px"><img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>" alt="" width="48" height="48"></span>
                                            </td>
                                            <td>
                                                <span class="name"><?= $orderProduct->name ?></span>
                                            </td>
                                            <td width="50px">
                                                <span class="price" style="padding-right: 10px"><?= ControllerHelper::showProductPrice($orderProduct->price / $orderProduct->quantity) ?></span>
                                            </td>
                                        </tr>
										<?php
									}
								}
								?>
                                </tbody>
                            </table>
                        </article>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("div.navbar-header div.load-tpc").hide();
		$("div.payment-method_BankTransfer").slideUp();
		if ($("#payment-method_BankTransfer").prop("checked")) {
			$("div.payment-method_BankTransfer").slideDown();
		}

		if ($('input:radio').length == 1) {
			$('input:radio').each(function(){
				if ($(this).is(":checked") == false) {
					$(this).trigger("click");
				}
			});
		}
	});
	<?php
	if(!is_null($listAddressSuggest) || RequestUtil::isFieldError("address[email]")){
	?>
	$(document).ready(function(){
		editPaymentAddress();
	});
	<?php
	}
	?>
	var divStateList = "#state_result";
	var divContentAddressId = "#addressReplace";
	var formAddress = $("#addressEditFormId");
	var urlSelCountry = "<?=ActionUtil::getFullPathAlias("home/address/state/list") ?>" + "?rtype=json";
	var gUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/cart/payment/address/add/view") ?>" + "?rtype=json";
	var pUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/cart/payment/address/add") ?>" + "?rtype=json";
	var gUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/cart/payment/address/edit/view") ?>" + "?rtype=json";
	var pUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/cart/payment/address/edit") ?>" + "?rtype=json";
	var pUrlLoadAddress = "<?=ActionUtil::getFullPathAlias("home/cart/payment/address/list") ?>" + "?rtype=json";
	var pUrlLoadTotalPrice = "<?=ActionUtil::getFullPathAlias("home/cart/total/price/list") ?>" + "?rtype=json";
	var gUrlPaymentValid = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/payment/valid") ?>" + "?rtype=json";
	var pUrlUpdatePaymentMethod = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/payment/method/update") ?>" + "?rtype=json";

	function selCountrySuccess(res){
		$(divStateList).html(res.content);
	}
	function changeCountry(countryId){
		var dataAddress = $(formAddress).serialize();
		simpleAjaxPost(
			guid(),
			urlSelCountry + "&address[country]=" + countryId,
			dataAddress,
			selCountrySuccess
		)
	}

	function editActionErrorAddress(dialogId, actionBtnId, res){
		showMessage(res.errorMessage, "error");
		$("#addressEditFormId").replaceWith(res.content);
	}

	function editSuccessAddress(dialogId, actionBtnId, res){
		$("div#addressReplace").html(res.content);
		var addressId = $("select#selAddressId").val();
		var dataAddress = $(formAddress).serialize();
		simpleAjaxPost(
			guid(),
			pUrlLoadAddress + "&address[id]=" + addressId,
			dataAddress,
			loadAddressSuccess
		)
	}

	function addSuccessAddress(dialogId, actionBtnId, res){
		window.location.reload();
		$("div#addressReplace").html(res.content);
		var addressId = $("input#hidAddressId").val();
		var dataAddress = $("#addressAddFormId").serialize();
		simpleAjaxPost(
			guid(),
			pUrlLoadAddress + "&address[id]=" + addressId,
			dataAddress,
			loadAddressSuccess
		)
	}
	function loadAddressSuccess(res){
		App.blockUI();
		window.location.reload();
	}

	function loadTotalPriceSuccess(res){
		$("#div_total_price").html(res.content);
	}

	function editPaymentAddress(){
		var addressId = $("select#selAddressId").val();
		var checkAddressEmailBlock = "";
		<?php 
			if(RequestUtil::isFieldError("address[email]")){
		?>
		var checkAddressEmailBlock = "&fieldErrorAddress=address[email]";
		<?php 	
			}
		?>
		simpleCUDNormal(
			divContentAddressId,
			"#addressEditFormId",
			guid(),
			"#btnSubmitAddress",
			gUrlEditAddress + "&address[id]=" + addressId + checkAddressEmailBlock,
			pUrlEditAddress + "&addressType=billing",
			editSuccessAddress,
			null,
			editActionErrorAddress
		);
	}

	function addPaymentAddress(){
		simpleCUDNormal(
			divContentAddressId,
			"#addressAddFormId",
			guid(),
			"#btnSubmitAddress",
			gUrlAddAddress + "&addressType=payment&address[groupId]=<?=SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId ?>",
			pUrlAddAddress + "&addressType=payment",
			addSuccessAddress,
			null,
			editActionErrorAddress
		);
	}


	function paymentMethodValidSuccess(res){
		showMessage("Checkout successfully!", 'success');
		window.location.replace("<?=ActionUtil::getFullPathAlias("home/cart/checkout/success") ?>");
	}
	function paymentMethodValidFieldError(res){
		$("#main").html(res.content)
	}
	function paymentMethodValidActionError(res){
		showMessage(res.errorMessage, 'warning', true);
		$("#main").html(res.content);
	}
	<?php
	$sessionCustomer = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
	?>
	function checkoutPayment(){
		<?php
		if (isset ($sessionCustomer)) {
		?>
		simpleAjaxPostUpload(
			guid(),
			gUrlPaymentValid,
			"#section_payment",
			paymentMethodValidSuccess,
			paymentMethodValidFieldError,
			paymentMethodValidActionError
		);
		<?php
		} else {
		?>
		$(document).ready(function(){
			showLoginDialog();
		});
		<?php
		}
		?>
	}

	function selectPaymentMethod(element){
		var id_banktransfer_info = element.attr("id");
		$("div." + id_banktransfer_info).slideDown();
		var data = {
			"order[paymentMethod]": element.val()
		};
		simpleAjaxPost(
			guid(),
			pUrlUpdatePaymentMethod,
			data,
			selectPaymentMethodSuccess
		)
	}

	function selectPaymentMethodSuccess(res){
	}
	function showPaymentMethodDetails(paymentMethodId){
		$(".payment_desc").hide();
		$("#payment_" + paymentMethodId + "_desc").show();
	}
	<?php
	if (!empty ($order) && $order->paymentMethod) {
		echo 'showPaymentMethodDetails("' . $order->paymentMethod . '");';
	}
	?>
	function changeAddress(addressId){
		simpleAjaxPost(
			guid(),
			pUrlLoadAddress + "&address[id]=" + addressId + "&addressType=billing",
			"",
			loadAddressSuccess
		);
	}
	function addGuestSuccessAddress(res){
		$("div#addressReplace").html(res.content);
		var addressId = $("input#hidAddressId").val();
		var dataAddress = $("#addressAddFormId").serialize();
		simpleAjaxPost(
			guid(),
			pUrlLoadAddress + "&address[id]=" + addressId,
			dataAddress,
			loadAddressSuccess
		)
	}
	function editGuestActionErrorAddress(res){
		showMessage(res.errorMessage, "error");
		$("#addressEditFormId").replaceWith(res.content);
	}
	function addAddressForGuest(){
		simpleAjaxPostUpload(
			guid(),
			pUrlAddAddress + "&addressType=payment",
			"#addressAddFormId",
			addGuestSuccessAddress,
			null,
			editGuestActionErrorAddress
		)
	}
</script>