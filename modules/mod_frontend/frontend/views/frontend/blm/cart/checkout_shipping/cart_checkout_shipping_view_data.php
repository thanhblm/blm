<?php
use common\helper\DatoImageHelper;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use core\utils\AppUtil;
use common\template\extend\Text;

$listAddressSuggest = RequestUtil::get("listAddressSuggest");
$listOrderProduct = null;
if (!is_null(SessionUtil::get("listOrderProduct"))) {
	$listOrderProduct = SessionUtil::get("listOrderProduct")->getArray();
}
?>
<div class="container no-padding">
    <div class="row" id="section_shipping">
        <div class="col-xs-9 no-padding" style="margin-top: 21px;">
            <div class="headline_steps checkout-step tabs box _1of1 checkout_step_new"
                 style="background: #f8faff;
			    font-size: 16px;
			    border-bottom: 1px solid #dae5e5;
			    -webkit-box-shadow: 0 1px 4px rgba(0,0,0,0.15);
			    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
			    padding: 0;">
                <div class="col-sm-3 active">
                    <a href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>"><?= Lang::get("1. Cart") ?></a>
                </div>
                <div class="col-sm-3 active">
                    <a href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/shipping/view") ?>"><?= Lang::get("2. Shipping") ?></a>
                </div>
                <div class="col-sm-3">
                    <span><?= Lang::get("3. Payment") ?></span>
                </div>
                <div class="col-sm-3">
                    <span><?= Lang::get("4. Complete") ?></span>
                </div>
                <div class="clear" style="padding:0px!important;"></div>
            </div>
            <div class="box col-xs-12  checkout-address checkout">
                <h2><?= Lang::get("Shipping Address") ?></h2>
                <div class="address_selection">
                    <div id="divShippingAddress">
						<?php include 'cart_checkout_shipping_list_address_data.php'; ?>
                    </div>
                    <div class="box col-xs-12 address_form " id="addressReplace">
                        <!-- Load Address -->
                    </div>
                </div>
            </div>
            <div class="box col-xs-12 checkout shipping-method" id="div_shipping_method">
				<?php include 'cart_checkout_shipping_method_list_data.php'; ?>
            </div>
            <div class="box col-xs-12 margin-top-10" style="padding-right: 0px">
                <div class="col-xs-4 col-xs-offset-8">
                    <a href="#" onclick="javascript:checkoutShipping()" style="" class="button green pull-right">
                        <span><?= Lang::get("Proceed to Payment") ?></span></a>
                </div>
            </div>
        </div>
        <div class="col-xs-3 no-padding" style="float: right;">
            <div>
                <div class="box col-xs-12 order-summary" id="div_total_price">
					<?php include 'cart_checkout_total_price_data.php'; ?>
                </div>
                <div class="box col-xs-12 cart-overview">
                    <table>
                        <tbody>
                        <tr class="title">
                            <td colspan="3"><span><?= Lang::get("Cart") ?> </span>
                                <a href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>" class="btn btn-endoca-green">
                                    <span><?= Lang::get("Edit") ?></span></a>
                            </td>
                        </tr>
						<?php
						if (isset ($listOrderProduct) && count($listOrderProduct) > 0) {
							foreach ($listOrderProduct as $orderProduct) {
								$imageMo = DatoImageHelper::getImageInfoById(json_decode($orderProduct->productImage) [0]);
								?>
                                <tr>
                                    <td>
                                        <span class="photo" style="padding-left: 10px"><img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>" alt="" width="48" height="48"></span>
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
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var checkAddressEmailBlock = "";
	$(document).ready(function(){
		$("div.navbar-header div.load-tpc").hide();
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
		<?php 
		if(RequestUtil::isFieldError("address[email]")){
		?>
			checkAddressEmailBlock = "&fieldErrorAddress=address[email]";
		<?php 	
			}
		?>
		editShippingAddress();
	});
	<?php
	}
	?>

	var divStateList = "#state_result";
	var divContentAddressId = "#addressReplace";
	var formAddress = $("#addressEditFormId");
	var urlSelCountry = "<?=ActionUtil::getFullPathAlias("home/address/state/list") ?>" + "?rtype=json";
	var gUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/cart/shipping/address/add/view") ?>" + "?rtype=json";
	var pUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/cart/shipping/address/add") ?>" + "?rtype=json";
	var gUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/cart/shipping/address/edit/view") ?>" + "?rtype=json";
	var pUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/cart/shipping/address/edit") ?>" + "?rtype=json";
	var pUrlLoadAddress = "<?=ActionUtil::getFullPathAlias("home/cart/shipping/address/list") ?>" + "?rtype=json";
	var pUrlLoadTotalPrice = "<?=ActionUtil::getFullPathAlias("home/cart/total/price/list") ?>" + "?rtype=json";
	var gUrlShippingValid = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/shipping/valid") ?>" + "?rtype=json";
	var pUrlUpdateShippingCost = "<?=ActionUtil::getFullPathAlias("home/cart/checkout/shipping/cost") ?>" + "?rtype=json";
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
	function editGuestActionErrorAddress(res){
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
	
	function loadAddressSuccess(res){
		App.blockUI();
		window.location.reload();
	}

	function loadTotalPriceSuccess(res){
		$("#div_total_price").html(res.content);
	}

	function editShippingAddress(){
		var addressId = $("select#selAddressId").val();
		simpleCUDNormal(
			divContentAddressId,
			"#addressEditFormId",
			guid(),
			"#btnSubmitAddress",
			gUrlEditAddress + "&isCheckAddress=true&address[id]=" + addressId + checkAddressEmailBlock,
			pUrlEditAddress + "&addressType=shipping",
			editSuccessAddress,
			null,
			editActionErrorAddress
		);
	}

	function addShippingAddress(){
		simpleCUDNormal(
			divContentAddressId,
			"#addressAddFormId",
			guid(),
			"#btnSubmitAddress",
			gUrlAddAddress + "&addressType=shipping&address[groupId]=<?=SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId ?>",
			pUrlAddAddress ,
			addSuccessAddress,
			null,
			editActionErrorAddress
		);
	}

	function shippingMethodValidSuccess(res){
		window.location.replace("<?=ActionUtil::getFullPathAlias("home/cart/checkout/payment/view") ?>");
	}
	function shippingMethodValidFieldError(res){
		$("#main").html(res.content)
	}
	function shippingMethodValidActionError(res){
		showMessage(res.errorMessage, 'warning');
		$("#main").html(res.content)
	}
	<?php
	$sessionCustomer = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
	?>
	function checkoutShipping(){
		<?php
		if(isset($sessionCustomer)){
		?>
		simpleAjaxPostUpload(
			guid(),
			gUrlShippingValid,
			"#section_shipping",
			shippingMethodValidSuccess,
			shippingMethodValidFieldError,
			shippingMethodValidActionError
		)
		<?php
		}else{
		?>
		$(document).ready(function(){
			showLoginDialog();
		});
		<?php
		}
		?>
	}
	function selectShippingMethodSuccess(res){
		$("#main").html(res.content);
	}
	function selectShippingMethod(element, cost){
		var valueObject = element.data("value-object");
		$("#hid_value_object").val(valueObject);
		var data = {
			"shippingCost": cost,
			"order[shippingMethod]": element.val(),
			"order[shippingMethodItem]": valueObject
		};
		simpleAjaxPost(
			guid(),
			pUrlUpdateShippingCost,
			data,
			selectShippingMethodSuccess
		)
	}
	function changeAddress(addressId){
		simpleAjaxPost(
			guid(),
			pUrlLoadAddress + "&address[id]=" + addressId + "&addressType=shipping",
			"",
			loadAddressSuccess
		)
	}
	function addAddressForGuest(){
		simpleAjaxPostUpload(
			guid(),
			pUrlAddAddress + "&addressType=shipping",
			"#addressAddFormId",
			addGuestSuccessAddress,
			null,
			editGuestActionErrorAddress
		)
	}
</script>