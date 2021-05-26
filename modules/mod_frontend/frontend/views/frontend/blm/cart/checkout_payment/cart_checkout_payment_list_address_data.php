<?php
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use core\config\ModuleConfig;
use common\template\extend\Button;
use core\utils\RouteUtil;

$address = RequestUtil::get("paymentAddress");
$addressId= "";
if(isset($address->id)){
	$addressId = $address->id;
}
$listAddress = RequestUtil::get ( "listAddress" );
$customerInfo = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
?>
<div class="row">
<div class="col-xs-2">
	<?php 
	if (strlen ( RequestUtil::getFieldError ( "paymentAddress[id]" ) ) > 0) {
	?>
	<label style="color: red;"><?=Lang::get("Bill to") ?></label>
	<?php
	} else {
		?>
	<label><?=Lang::get("Bill to") ?></label>
	<?php
	}
	?>
 </div>
<div class="col-xs-10 address_selection" style="padding-top: 0px;">
		<?php
		if (count($listAddress) > 0) {
			$select = new SelectInput();
			$select->hasError = RequestUtil::isFieldError("paymentAddress[id]");
			$select->errorMessage = RequestUtil::getFieldError("paymentAddress[id]");
			$select->required = true;
			$select->name = "paymentAddress[id]";
			$select->value = $addressId;
			$select->collections = $listAddress;
			$select->propertyName = "id";
			$select->id = "selAddressId";
			$select->class = " ";
			$select->propertyValue = "address";
			$select->attributes = 'onchange="changeAddress($(this).val())"';
			$select->render();
			?>
			<?php 
				if($customerInfo->userId != 0){
			?>
			 <a href="#" onclick="addPaymentAddress()" class="payment_new"><?= Lang::get("Ship To Different Address") ?></a>
             <a class="payment_edit" href="#" onclick="editPaymentAddress()"><?= Lang::get("Edit Selected Address") ?></a>
			<?php 		
				}else{
			?>
           <a href="#" onclick="addPaymentAddress()" class="payment_edit"><?= Lang::get("Edit Selected Address") ?></a>
           <?php 
				}
           ?>
			<?php
		} else if($customerInfo->userId != 0) {
			?>
            <a href="#" onclick="addPaymentAddress()" class="payment_new"><?= Lang::get("Create Address") ?></a>
			<?php
		}else if($customerInfo->userId == 0){
			$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule())['VIEW_PATH'].DS.ApplicationConfig::get("template.name").DS;
			
			include $viewPath."address".DS."address_add_form_data.php";
			
			$button = new Button();
			$button->type = "button";
			$button->id = "btnSubmitAddress";
			$button->title = " " . Lang::get ( "Update address" );
			$button->attributes = " onclick='addAddressForGuest()'";
			$button->class = "button green";
			$button->render ();
		}
		?>
    </div>
</div>