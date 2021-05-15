<?php
use common\template\extend\FormContainer;
use core\Lang;

$form = new FormContainer ();
$form->id = "customerCopyFormId";
$form->attributes = 'class="form-horizontal" ';
$form->renderStart ();
?>
<div class="tabbable-line">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_account_info" data-toggle="tab"> <?=Lang::get("Account Info") ?> </a></li>
        <li class=""><a href="#tab_persional_info" data-toggle="tab"> <?=Lang::get("Personal Info") ?> </a></li>
        <li class=""><a href="#tab_company_info" data-toggle="tab"> <?=Lang::get("Company Info") ?> </a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_account_info">
			<?php include_once 'form_data/customer_account_info_form_data.php'; ?>
        </div>
        <div class="tab-pane fade" id="tab_persional_info">
			<?php include_once 'form_data/customer_personal_info_form_data.php'; ?>
        </div>
        <div class="tab-pane fade" id="tab_company_info">
			<?php include_once 'form_data/customer_company_info_form_data.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var accountError = 0;
		var persionalError = 0;
		var companyError = 0;
	
		$("div#tab_account_info").find('div.has-error').each(function () {
		    accountError += 1;
		});
	
		$("div#tab_persional_info").find('div.has-error').each(function () {
		    persionalError += 1;
		});
	
		$("div#tab_company_info").find('div.has-error').each(function () {
		    companyError += 1;
		});
	
		if(accountError > 0){
			$('a[href="#tab_account_info"]').css("color", "#e73d4a");
		}else{
			$('a[href="#tab_account_info"]').css("color", "#23527c");
		}
	
		if(persionalError > 0){
			$('a[href="#tab_persional_info"]').css("color", "#e73d4a");
		}else{
			$('a[href="#tab_persional_info"]').css("color", "#23527c");
		}
	
		if(companyError > 0){
			$('a[href="#tab_company_info"]').css("color", "#e73d4a");
		}else{
			$('a[href="#tab_company_info"]').css("color", "#23527c");
		}
	});
</script>
<?php $form->renderEnd(); ?>
