
<?php 
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\Button;
$saleRep = RequestUtil::get ( 'saleRep' );
$priceLevels = RequestUtil::get ( 'priceLevels' );

?>
<div id="account_container">
	<h2>Customer</h2>

	<?php 
	$form = new FormContainer();
	$form->id = "sale_rep_edit_form";
	$form->attributes = 'class="_resCustomer  purlForm"';
	$form->renderStart();

	$text = new Text();
	$text->name = "saleRep[id]";
	$text->value = $saleRep->id;
	$text->type = "hidden";
	$text->render ();
	?>
<!-- 	<form name="resCustomer" action="/en/reseller?id=455259&amp;action=purlResellerCenter%3AcustomerSave" method="post" enctype="multipart/form-data" class="_resCustomer  purlForm">
 -->		
 	<?php
		if (RequestUtil::hasActionErrors()) {
			?>
            <div class="alert alert-danger" role="alert">
				<?= RequestUtil::getErrorMessage(); ?>
            </div>
			<?php
		}
		if (RequestUtil::hasFieldErrors()) {
			?>
            <div class="alert alert-danger" role="alert"><?= Lang::get("There are some field errors, please check!") ?></div>
			<?php
		}
		if (RequestUtil::hasActionMessages()) {
			?>
            <div id="alert_info" class="alert alert-info" role="alert">
				<?= RequestUtil::getActionMessage() ?>
            </div>
			<?php
		}
		?>
 			<div class="_form">
			<div class="required _field _user_firstname _string">
				<div class="_label"><?=Lang::get('Firstname');?>:</div>
				<div class="_input">
					<span class="frm_field frm_text"><input type="text" name="saleRep[firstName]" value="<?=$saleRep->firstName?>" required="required"></span>
				</div>
			</div>
			<div class="required _field _user_lastname _string">
				<div class="_label"><?=Lang::get('Lastname');?>:</div>
				<div class="_input">
					<span class="frm_field frm_text"><input type="text" name="saleRep[lastName]" value="<?=$saleRep->lastName?>" required="required"></span>
				</div>
			</div>
			<div class="required _field _user_email _email">
				<div class="_label"><?=Lang::get('Email Address');?>:</div>
				<div class="_input">
					<span class="frm_field frm_email"><input type="email" name="saleRep[email]" value="<?=$saleRep->email?>" required="required"></span>
				</div>
			</div>
			<div class="_field _ _spacer"></div>
			<div class="required _field _user_phone _string">
				<div class="_label"><?=Lang::get('Phone');?>:</div>
				<div class="_input">
					<span class="frm_field frm_text"><input type="text" name="saleRep[phone]" value="<?=$saleRep->phone?>"></span>
				</div>
			</div>
			<div class="_field _user_fax _string">
				<div class="_label"><?=Lang::get('Fax');?>:</div>
				<div class="_input">
					<span class="frm_field frm_text"><input type="text" name="saleRep[fax]" value="<?=$saleRep->fax?>"></span>
				</div>
			</div>
			<div class="_field _ _spacer"></div>
			<div class="required _field _user_pricelevel _menu">
				<div class="_label"><?=Lang::get('Price Level');?>:</div>
				<div class="_input">
					<span class="frm_field frm_select" title="US Distributor (63%)">
						<select name="saleRep[priceLevelId]" required="required"><option value=""><?=Lang::get('Select One')?></option>
							<?php
							foreach ($priceLevels as $key => $priceLevel) {
							?>
							<option value="<?=$priceLevel->id?>" <?php if($saleRep->priceLevelId==$priceLevel->id){echo 'selected';}?>><?=$priceLevel->name?></option>
							<?php 
							}
							?>
						</select></span>
				</div>
			</div>
			<div class="_field _ _spacer"></div>
			<div class="_field _user_password _password">
				<div class="_label"><?=Lang::get('New Password');?>:</div>
				<div class="_input">
					<span class="frm_field frm_password"><input type="password" name="saleRep[password]" value=""></span>
				</div>
			</div>
			<div class="required _field _user_password_rpt _password_rpt">
				<div class="_label"><?=Lang::get('Confirm Password');?>:</div>
				<div class="_input">
					<span class="frm_field frm_password"><input type="password" name="cPassword" value=""></span>
				</div>
			</div>
			<input type="hidden" name="id" value="455259">
		</div>
		<div class="_buttons">
			<?php 
			$button = new Button();
			$button->title = Lang::get("Update");
			$button->attributes = "type='button' onclick='editSaleRep()'";
			$button->render();
			?>
		</div>
		<!-- <div class="_buttons">
			<button type="submit">
				<span>Update</span>
			</button>
		</div> -->
<!-- 	</form>
 -->
 	<?php $form->renderEnd(); ?>
	<div class="cb"></div>
</div>