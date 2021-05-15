<?php
use common\template\extend\FormContainer;
use common\template\extend\Link;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;

$bulkDiscount = RequestUtil::get ( 'bulkDiscount' );

$form = new FormContainer ();
$form->id = "bulk_discount_add_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-dark">
			<span class="caption-subject bold uppercase"><?=Lang::get('Add bulk discount')?></span>
		</div>
		<div class="actions btn-set"></div>
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
		if (RequestUtil::hasActionMessages ()) {
			?>
		<div id="alert_info" class="alert alert-info" role="alert">
			<?=RequestUtil::getActionMessage()?>
		</div>
		<?php
		}
		?>
		<div class="tabbable-bordered">
			<div class="form-body">
				<input type="hidden" id="bulk_discount_id" name="bulkDiscount[id]" value="<?=$bulkDiscount->id?>" />
				<?php
				$text = new TextInput ();
				$text->errorMessage = RequestUtil::getFieldError ( "bulkDiscount[name]" );
				$text->hasError = RequestUtil::isFieldError ( "bulkDiscount[name]" );
				$text->label = Lang::get ( "Name" );
				$text->required = true;
				$text->name = "bulkDiscount[name]";
				$text->value = $bulkDiscount->name;
				$text->render ();
				
				$text = new TextInput ();
				$text->errorMessage = RequestUtil::getFieldError ( "bulkDiscount[discount]" );
				$text->hasError = RequestUtil::isFieldError ( "bulkDiscount[discount]" );
				$text->label = Lang::get ( "Discount value (%)" );
				$text->required = true;
				$text->id = "discount";
				$text->name = "bulkDiscount[discount]";
				$text->value = $bulkDiscount->discount;
				$text->type = "number";
				$text->attributes="min='1' max='99'";
				$text->render ();
				
				$text = new TextInput ("text_date_form");
				$text->errorMessage = RequestUtil::getFieldError ( "bulkDiscount[validFrom]" );
				$text->hasError = RequestUtil::isFieldError ( "bulkDiscount[validFrom]" );
				$text->label = Lang::get ( "Valid from" );
				$text->required = false;
				$text->id = "validFrom";
				$text->name = "bulkDiscount[validFrom]";
				$text->value = $bulkDiscount->validFrom;
				$text->render ();
				
				$text = new TextInput ("text_date_form");
				$text->errorMessage = RequestUtil::getFieldError ( "bulkDiscount[validTo]" );
				$text->hasError = RequestUtil::isFieldError ( "bulkDiscount[validTo]" );
				$text->label = Lang::get ( "Valid to" );
				$text->required = false;
				$text->id = "validTo";
				$text->name = "bulkDiscount[validTo]";
				$text->value = $bulkDiscount->validTo;
				$text->render ();
				
				$select = new SelectInput ();
				$select->headerKey = "";
				$select->headerValue = Lang::get ( "Select One" );
				$select->errorMessage = RequestUtil::getFieldError ( "bulkDiscount[status]" );
				$select->hasError = RequestUtil::isFieldError ( "bulkDiscount[status]" );
				$select->value = $bulkDiscount->status;
				$select->name = "bulkDiscount[status]";
				$select->collections = ApplicationConfig::get ( "common.status.list" );
				$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
				$select->label = Lang::get ( "Status" );
				$select->required = true;
				$select->render ();
				?>
			</div>
		</div>
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-green-sharp">
					<i class="fa fa-cogs"></i><?=Lang::get("List Product")?>
				</div>
                <div class="actions">
					<?php
					$link = new Link();
					$link->class = "btn btn-circle blue";
					$link->attributes = "onclick=\"addBulkDiscountProduct('0')\"";
					$link->title = "<i class=\"fa fa-plus white\"></i> ".Lang::get("Add new");
					$link->id = "iAddBulkDiscountProduct";
					$link->render();

					$link = new Link();
					$link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
					$link->render();
					?>
                </div>
			</div>
			<div class="portlet-body" style="display: block; padding: 0; width: 100%; overflow-x: auto; overflow-y: hidden; border: 1px solid #e7ecf1;" id="page_result_tax">
				<?php include 'product/bulk_discount_product_list_data.php';?>
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
		$("#productDiscount").select2({
			 placeholder: '<?=Lang::get("Select a product")?>'
		});
	});
</script>