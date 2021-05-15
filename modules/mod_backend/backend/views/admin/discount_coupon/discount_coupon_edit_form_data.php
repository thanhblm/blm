<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\Link;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;

$discountCoupon = RequestUtil::get ( "discountCoupon" );
$form = new FormContainer ();
$form->id = "discount_coupon_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
$applicableList = RequestUtil::get ( "applicableList" )->getArray ();
$applicableProducts = RequestUtil::get ( "applicableProducts" )->getArray ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-dark">
			<span class="caption-subject bold uppercase"><?=Lang::get('Edit Discount Coupon')?></span>
		</div>
		<div class="actions btn-set">
			<?php
			$link = new Link ();
			$link->title = Lang::get ( 'Back' );
			$link->link = ActionUtil::getFullPathAlias ( 'admin/discount/coupon/list' );
			$link->class = "btn btn-sm grey margin-bottom-5";
			$link->render ();

			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get ( "Save" );
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='editDiscountCoupon()'";
			$button->render ();

			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get ( "Save & Close" );
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='editAndCloseDiscountCoupon()'";
			$button->render ();
			?>
		</div>
	</div>
	<div class="portlet-body">
		<?php
		if (RequestUtil::hasActionErrors ()) {
			?>
		<div class="alert alert-danger" role="alert">
			<?=RequestUtil::getErrorMessage ();?>
		</div>
		<?php
		}
		if (RequestUtil::hasFieldErrors ()) {
			?>
		<div class="alert alert-danger" role="alert"><?=Lang::get("There are some field errors, please check!")?></div>
		<?php
		}
		if (RequestUtil::hasActionMessages ()) {
			?>
		<div id="alert_info" class="alert alert-info" role="alert">
			<?=RequestUtil::getActionMessage()?>
		</div>
		<?php
		}
		?>
		<div class="tabbable-line">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_general" data-toggle="tab"><?=Lang::get('General')?> </a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_general">
					<div class="form-body">
						<?php
						$text = new TextInput ();
						$text->name = "discountCoupon[id]";
						$text->value = $discountCoupon->id;
						$text->type = "hidden";
						$text->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[code]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[code]" );
						$text->label = Lang::get ( "Code" );
						$text->name = "discountCoupon[code]";
						$text->value = $discountCoupon->code;
						$text->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[name]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[name]" );
						$text->label = Lang::get ( "Name" );
						$text->name = "discountCoupon[name]";
						$text->value = $discountCoupon->name;
						$text->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[discount]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[discount]" );
						$text->label = Lang::get ( "Discount value (in %)" );
						$text->name = "discountCoupon[discount]";
						$text->value = $discountCoupon->discount;
						$text->attributes .= " min='1' max='99' ";
						$text->type = "number";
						$text->render ();

						$select = new SelectInput ();
						$select->value = $discountCoupon->status;
						$select->name = "discountCoupon[status]";
						$select->headerKey = "";
						$select->headerValue = Lang::get ( "Select one" );
						$select->collections = ApplicationConfig::get ( "common.status.list" );
						$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
						$select->label = Lang::get ( "Status" );
						$select->errorMessage = RequestUtil::getFieldError ( "discountCoupon[status]" );
						$select->hasError = RequestUtil::isFieldError ( "discountCoupon[status]" );
						$select->required = true;
						$select->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[minOrderTotal]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[minOrderTotal]" );
						$text->label = Lang::get ( "Min order total" );
						$text->name = "discountCoupon[minOrderTotal]";
						$text->type = "number";
						$text->value = $discountCoupon->minOrderTotal;
                        $text->append = Lang::get('Coupon can be used only if cart total is higher than this value');
						$text->render ();

						$text = new TextInput ( "text_date_form" );
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[validFrom]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[validFrom]" );
						$text->label = Lang::get ( "Valid from" );
						// $text->placeholder = Lang::get ( "From" );
						$text->name = "discountCoupon[validFrom]";
						$text->value = $discountCoupon->validFrom;
						$text->render ();

						$text = new TextInput ( "text_date_form" );
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[validTo]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[validTo]" );
						$text->label = Lang::get ( "Valid to" );
						$text->name = "discountCoupon[validTo]";
						$text->value = $discountCoupon->validTo;
						$text->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[maxUse]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[maxUse]" );
						$text->label = Lang::get ( "Max uses" );
						$text->name = "discountCoupon[maxUse]";
						$text->attributes .= " min='0' ";
						$text->value = $discountCoupon->maxUse;
						$text->type = "number";
						$text->append = Lang::get('0: infinte; Coupon can be used this many times before it becomes expired');
						$text->render ();

						$text = new TextInput ();
						$text->errorMessage = RequestUtil::getFieldError ( "discountCoupon[usePerCustomer]" );
						$text->hasError = RequestUtil::isFieldError ( "discountCoupon[usePerCustomer]" );
						$text->label = Lang::get ( "Uses per customer" );
						$text->name = "discountCoupon[usePerCustomer]";
						$text->attributes .= " min='0' ";
						$text->value = $discountCoupon->usePerCustomer;
						$text->type = "number";
                        $text->append = Lang::get('0: infinte; Coupon can be used this many times by each Customer');
						$text->render ();
						?>
						<div class="form-group <?=RequestUtil::isFieldError( "discountCoupon[userPerProduct]")?"has-error":""?>">
							<label class="control-label col-md-4"><?=Lang::get("Uses Per Product")?></label>
							<div class="col-md-8">
								<?php
                                $description = ApplicationConfig::get ( "discount.coupon.userperproduct.description.list" );
								foreach ( ApplicationConfig::get ( "discount.coupon.userperproduct.list" ) as $key => $value ) {
									?>
								    <input type="radio" name="discountCoupon[userPerProduct]" value="<?=$key?>" <?php if($discountCoupon->userPerProduct==$key) echo 'checked="checked"';?> />
                                    <label><?=$value?></label>
                                    <br />
                                    <i><?=$description[$key]?></i>
                                    <br />
								<?php
								}
								?>
								<span class="help-block"><?=RequestUtil::getFieldError ( "discountCoupon[userPerProduct]")?></span>
							</div>
						</div>
					</div>
					<?php include_once 'product/discount_coupon_product_data.php';?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $form->renderEnd ();?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
 			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
		});
	});
</script>
