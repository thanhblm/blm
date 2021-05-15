<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\config\ApplicationConfig;

$activeTab = RequestUtil::get("activeTab");
?>

<div class="modal-dialog modal-lg">
    <div class="t-alr">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
    </div>
    <div class="modal-content">
        <div class="tabs-container dialog-tabs">
            <ul class="nav nav-tabs">
                <li class="<?= $activeTab == "login-tab" || AppUtil::isEmptyString($activeTab) ? "active" : "" ?>">
                    <a href="#login-tab " data-toggle="tab"><?= Lang::get("Login") ?></a>
                </li>
                <li class="<?= $activeTab == "registration-tab" ? "active" : "" ?>">
                    <a href="#registration-tab" data-toggle="tab"><?= Lang::get("Registration") ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?= $activeTab == "login-tab" || AppUtil::isEmptyString($activeTab) ? "active" : "" ?>" id="login-tab">
                    <div id="login">
						<?php include_once 'home_login_form_data.php'; ?>
                    </div>
                    <div class="_buttons dt-buttons">
						<?php
						$button = new Button();
						$button->class = "wide";
						$button->id = "btnLoginSubmit";
						$button->title = Lang::get("Login");
						$button->type = "button";
						$button->render();
						?>
                    </div>
                    <?php 
                    	$enableGuestCheckout = false;
                    	if(is_null(ApplicationConfig::get("guest.checkout.enable")) || AppUtil::isEmptyString(ApplicationConfig::get("guest.checkout.enable"))){
                    		$enableGuestCheckout = false;
                    	}else{
                    		$enableGuestCheckout = ApplicationConfig::get("guest.checkout.enable");
                    	}
                    	if($activeTab == "login-tab" && $enableGuestCheckout){
                    ?>
                    	<br/>
                     <div class="_buttons dt-buttons">
							<?php
							$button = new Button();
							$button->class = "wide";
							$button->id = "btnCheckoutSubmit";
							$button->title = Lang::get("Checkout as guest");
							$button->type = "button";
							$button->attributes = 'onclick="guestLogin()"';
							$button->render();
							?>
	                    </div>
                    <?php 
                    	}
                    ?>
                   
                </div>
                <div class="tab-pane <?= $activeTab == "registration-tab" ? "active" : "" ?>" id="registration-tab">
                    <div id="registration">
						<?php include_once 'home_register_form_data.php'; ?>
                    </div>
                    <div class="_buttons dt-buttons">
						<?php
						$button = new Button();
						$button->class = "wide";
						$button->id = "btnRegisterSubmit";
						$button->title = Lang::get("Register");
						$button->type = "button";
						$button->attributes = 'onclick="registerCustomer()"';
						$button->render();
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	formRegisterId = "#formRegisterId";
	guestFormId = "#guestFormId";
	divRegisterId = "#registration";
	btnRegisterSubmit = "#btnRegisterSubmit";
	pUrlGuestLogin = "<?=ActionUtil::getFullPathAlias("home/guest/login") ?>" + "?rtype=json";
	
	pUrlRegister = "<?=ActionUtil::getFullPathAlias("home/customer/register") ?>" + "?rtype=json";

	function registerSuccess(res){
		showMessage("<?=Lang::get("Registered successfully") ?>");
		$(modalLoginDiaglogId).modal("toggle");
		location.reload();
	}
	function registerError(res){
		$(divRegisterId).html(res.content);
		$('#modalLoginDialog').animate({scrollTop: $("#formRegisterId").offset().top},1000);
	}
	function registerCustomer(){
		dataRegister = $(formRegisterId).serialize();
		simpleAjaxPost(
			guid(),
			pUrlRegister,
			dataRegister,
			registerSuccess,
			registerError,
			registerError
		)
	}

	function guestLoginSuccess(res){
		showMessage("<?=Lang::get("Checkout as guest successfully") ?>");
		$(modalLoginDiaglogId).modal("toggle");
		location.reload();
	}
	function guestLoginError(res){
		$(divRegisterId).html(res.content);
	}
	function guestLogin(){
		simpleAjaxPostUpload(
			guid(),
			pUrlGuestLogin,
			"",
			guestLoginSuccess,
			guestLoginError,
			guestLoginError
		)
	}
	
</script>