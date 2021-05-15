<?php
use common\template\extend\Button;
use common\template\extend\ImageInput;
use common\template\extend\Link;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$currencyList = RequestUtil::get ( "currencyList" );
$region = RequestUtil::get ( 'region' );
?>
<form class="form-horizontal form-row-seperated" id="copy_region_form" method="post">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption font-dark">
				<span class="caption-subject bold uppercase"><?=Lang::get('Clone Region')?></span>
			</div>
			<div class="actions btn-set">
				<?php
				$link = new Link ();
				$link->title = Lang::get ( 'Back' );
				$link->link = ActionUtil::getFullPathAlias ( 'admin/region/list' );
				$link->class = "btn btn-sm grey margin-bottom-5";
				$link->render ();
				
				$button = new Button ();
				$button->id = "btnAddRegion";
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->title = Lang::get ( "Save & Close" );
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "type='button' onclick='copyRegion()'";
				$button->render ();
				
				$button = new Button ();
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->type = 'button';
				$button->title = Lang::get ( "Save" );
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "onclick='copyToEditRegion()'";
				$button->render ();
				?>
			</div>
		</div>
		<div class="portlet-body">
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
			<div class="tabbable-line">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_general" data-toggle="tab">
									<?=Lang::get('General')?> </a></li>
					<li><a href="#tab_location" data-toggle="tab"> <?=Lang::get('Location')?> </a></li>
					<li><a href="#tab_shipping" data-toggle="tab"> <?=Lang::get('Shipping Method')?> </a></li>
					<li><a href="#tab_payment" data-toggle="tab"> <?=Lang::get('Payment Method')?> </a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_general">
						<!-- Begin Tab General -->
						<div class="form-body">
							<?php
							$text = new TextInput ();
							$text->errorMessage = RequestUtil::getFieldError ( "region[name]" );
							$text->hasError = RequestUtil::isFieldError ( "region[name]" );
							$text->label = Lang::get ( "Name" );
							$text->required = true;
							$text->name = "region[name]";
							$text->value = $region->name;
							$text->render ();
							
							$select = new SelectInput ();
							$select->value = $region->currencyCode;
							$select->name = "region[currencyCode]";
							$select->headerKey = "";
							$select->headerValue = "Select One";
							$select->collections = $currencyList;
							$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
							$select->label = Lang::get ( "Currency Code" );
							$select->propertyName = "code";
							$select->propertyValue = "name";
							$select->errorMessage = RequestUtil::getFieldError ( "region[currencyCode]" );
							$select->hasError = RequestUtil::isFieldError ( "region[currencyCode]" );
							$select->required = true;
							$select->render ();
							
							$text = new TextInput ();
							$text->type = "number";
							$text->errorMessage = RequestUtil::getFieldError ( "region[freeShippingAmount]" );
							$text->hasError = RequestUtil::isFieldError ( "region[freeShippingAmount]" );
							$text->label = Lang::get ( "Free Shipping Amount" );
							$text->required = true;
							$text->name = "region[freeShippingAmount]";
							$text->value = $region->freeShippingAmount;
							$text->render ();
							
							$select = new SelectInput ();
							$select->value = $region->fallbackRegion;
							$select->name = "region[fallbackRegion]";
							$select->headerKey = "";
							$select->headerValue = "Select One";
							$select->collections = ApplicationConfig::get ( "region.fallback.list" );
							$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
							$select->label = Lang::get ( "Fallback Region" );
							$select->errorMessage = RequestUtil::getFieldError ( "region[fallbackRegion]" );
							$select->hasError = RequestUtil::isFieldError ( "region[fallbackRegion]" );
							$select->required = true;
							$select->render ();
							
							$select = new SelectInput ();
							$select->value = $region->status;
							$select->name = "region[status]";
							$select->headerKey = "";
							$select->headerValue = "Select One";
							$select->collections = ApplicationConfig::get ( "common.status.list" );
							$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
							$select->label = Lang::get ( "Status" );
							$select->errorMessage = RequestUtil::getFieldError ( "region[status]" );
							$select->hasError = RequestUtil::isFieldError ( "region[status]" );
							$select->required = true;
							$select->render ();
							
							$image = new ImageInput ();
							$image->label = Lang::get ( "Invoice Logo" );
							$image->name = "region[invoiceLogo]";
							$image->value = $region->invoiceLogo;
							$image->hasImgAction = true;
							$image->render ();
							
							$text = new TextInput ();
							$text->errorMessage = RequestUtil::getFieldError ( "region[contactEmail]" );
							$text->hasError = RequestUtil::isFieldError ( "region[contactEmail]" );
							$text->label = Lang::get ( "Contact Email" );
							$text->required = false;
							$text->name = "region[contactEmail]";
							$text->value = $region->contactEmail;
							$text->render ();
							
							$text = new TextArea ();
							$text->value = $region->invoiceHeader;
							$text->name = "region[invoiceHeader]";
							$text->class = "ckeditor";
							$text->label = Lang::get ( "Invoice Header" );
							$text->errorMessage = RequestUtil::getFieldError ( "region[invoiceHeader]" );
							$text->hasError = RequestUtil::isFieldError ( "region[invoiceHeader]" );
							$text->required = false;
							$text->render ();
							
							$text = new TextArea ();
							$text->value = $region->invoiceComment;
							$text->name = "region[invoiceComment]";
							$text->class = "ckeditor";
							$text->label = Lang::get ( "Invoice Comment" );
							$text->errorMessage = RequestUtil::getFieldError ( "region[invoiceComment]" );
							$text->hasError = RequestUtil::isFieldError ( "region[invoiceComment]" );
							$text->required = false;
							$text->render ();
							?>
						</div>
						<!-- End Tab General -->
					</div>
					<div class="tab-pane" id="tab_location">
						<?php include_once 'location/region_location_data.php';?>
					</div>
					<div class="tab-pane" id="tab_shipping">
						<?php include_once 'shipping_method/region_shipping_method_data.php';?>
					</div>
					<div class="tab-pane" id="tab_payment">
						<?php include_once 'payment_method/region_payment_method_data.php';?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>