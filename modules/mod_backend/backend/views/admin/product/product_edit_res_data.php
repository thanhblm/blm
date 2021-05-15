<?php
use common\template\extend\Button;
use common\template\extend\Link;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\config\ApplicationConfig;
use common\template\extend\TextArea;
use core\utils\AppUtil;

$pages = RequestUtil::get('pages');
$categories = RequestUtil::get ( 'categories' );
$product = RequestUtil::get ( 'product' );
?>
<form class="form-horizontal form-row-seperated" id="edit_product_form" method="post">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption font-dark">
				<span class="caption-subject bold uppercase"><?=Lang::get('Edit Product')?></span>
			</div>
			<div class="actions btn-set">
				<?php
				$link = new Link ();
				$link->title = Lang::get ( 'Back' );
				$link->link = ActionUtil::getFullPathAlias ( 'admin/product/list' );
				$link->class = "btn btn-sm grey margin-bottom-5";
				$link->render ();
				
				$button = new Button ();
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->title = Lang::get("Save & Close");
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "type='button' onclick='editCloseProduct()'";
				$button->render();
				
				$button = new Button ();
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->type = 'button';
				$button->title = Lang::get ( "Save" );
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "onclick='editProduct()'";
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
			?>
			<?php
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
					<li class="active"><a href="#tab_general" data-toggle="tab">
									<?=Lang::get('General')?> </a></li>
					<li><a href="#tab_language" data-toggle="tab"> <?=Lang::get('Localization')?> </a></li>
					<li><a href="#tab_price" data-toggle="tab"> <?=Lang::get('Price')?> </a></li>
					<li><a href="#tab_region" data-toggle="tab"> <?=Lang::get('Region')?> </a></li>
					<li><a href="#tab_relate" data-toggle="tab"> <?=Lang::get('Related Products')?> </a></li>
					<li><a href="#tab_image" data-toggle="tab"> <?=Lang::get('Images')?> </a></li>
					<li><a href="#tab_seo" data-toggle="tab"> <?=Lang::get('Seo')?> </a></li>
					<li onclick="javascript:loadProductAttribute()"><a href="#tab_attribute" data-toggle="tab" > <?= Lang::get('Attribute') ?> </a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_general">
						<!-- Begin Tab General -->
						<input type="hidden" id="id" name="product[id]" value="<?=$product->id?>" />
						<div class="form-body">
							<?php
							$text = new TextInput ();
							$text->errorMessage = RequestUtil::getFieldError ( "product[name]" );
							$text->hasError = RequestUtil::isFieldError ( "product[name]" );
							$text->label = Lang::get ( "Name" );
							$text->required = true;
							$text->name = "product[name]";
							$text->value = $product->name;
							$text->render ();
							
							$select = new SelectInput ();
							$select->id = "product_category";
							$select->name = "product[categoryId]";
							$select->headerKey = "";
							$select->headerValue = Lang::get ( "Select One" );
							$select->collections = $categories;
							$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
							$select->propertyName = "id";
							$select->propertyValue = "name";
							$select->value = $product->categoryId;
							$select->label = Lang::get ( "Category" );
							$select->errorMessage = RequestUtil::getFieldError ( "product[categoryId]");
							$select->hasError = RequestUtil::isFieldError ( "product[categoryId]" );
							$select->required = true;
							$select->class = "form-control input-sm";
							$select->render ();
							
							$select = new SelectInput ();
							$select->name = "product[status]";
							$select->value = $product->status;
							$select->headerKey = "";
							$select->headerValue = Lang::get ( "Select One" );
							$select->collections = ApplicationConfig::get ( "common.status.list" );
							$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
							$select->label = Lang::get ( "Status" );
							$select->errorMessage = RequestUtil::getFieldError("product[status]");
							$select->hasError = RequestUtil::isFieldError("product[status]");
							$select->required = true;
							$select->render ();
							
							$text = new TextInput ();
							$text->id = "product_item_code";
							$text->errorMessage = RequestUtil::getFieldError ( "product[itemCode]" );
							$text->hasError = RequestUtil::isFieldError ( "product[itemCode]" );
							$text->label = Lang::get ( "Item Code" );
							$text->required = false;
							$text->name = "product[itemCode]";
							$text->value = $product->itemCode;
							$text->render ();
							
							$text = new TextInput ();
							$text->id = "product_bar_code";
							$text->errorMessage = RequestUtil::getFieldError ( "product[barCode]" );
							$text->hasError = RequestUtil::isFieldError ( "product[barCode]" );
							$text->label = Lang::get ( "Bar Code" );
							$text->required = false;
							$text->name = "product[barCode]";
							$text->value = $product->barCode;
							$text->render ();
							
							$text = new TextInput ();
							$text->id = "product_amount";
							$text->errorMessage = RequestUtil::getFieldError ( "product[cbdAmount]" );
							$text->hasError = RequestUtil::isFieldError ( "product[cbdAmount]" );
							$text->label = Lang::get ( "Tags" );
							$text->required = false;
							$text->name = "product[cbdAmount]";
							$text->value = $product->cbdAmount;
							$text->render ();
							
							$text = new TextInput ();
							$text->id = "product_weight";
							$text->type = "number";
							$text->errorMessage = RequestUtil::getFieldError ( "product[weight]" );
							$text->hasError = RequestUtil::isFieldError ( "product[weight]" );
							$text->label = Lang::get ( "Weight (in gram)" );
							$text->required = false;
							$text->name = "product[weight]";
							$text->value = $product->weight;
							$text->render ();

							?>
							<div class="form-group ">
								<label class="control-label col-md-4">Featured  </label>
								<div class="col-md-8">
									<input type="radio" name="product[featured]" value="yes" <?php if($product->featured=='yes') echo "checked='checked'";?>><?=Lang::get('Yes')?>&nbsp;
	                                <input type="radio" name="product[featured]" value="no" <?php if($product->featured=='no') echo "checked='checked'";?>><?=Lang::get('No')?>
                                </div>
							</div>
							
							<div class="form-group ">
								<label class="control-label col-md-4"><?=Lang::get("Is Seo") ?>  </label>
								<div class="col-md-8">
									<input type="radio" name="product[isSeo]" value="yes" <?php if($product->isSeo=='yes') echo "checked='checked'";?>><?=Lang::get('Yes')?>&nbsp;
	                                <input type="radio" name="product[isSeo]" value="no" <?php if($product->isSeo=='no' || AppUtil::isEmptyString($product->isSeo)) echo "checked='checked'";?>><?=Lang::get('No')?>
                                </div>
							</div>
							
							<?php
							$select = new SelectInput ();
							$select->name = "product[type]";
							$select->value = $product->type;
							$select->collections = ApplicationConfig::get("product.type.list");
							$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
							$select->label = Lang::get("Type");
							$select->errorMessage = RequestUtil::getFieldError("product[type]");
							$select->hasError = RequestUtil::isFieldError("product[type]");
							$select->required = false;
							$select->class = "form-control input-sm";
							$select->render();
							
							$text = new TextArea();
							$text->label = Lang::get ( "Composition" );
							$text->required = false;
							$text->name = "product[composition]";
							$text->value = $product->composition;
							$text->class = "ckeditor";
							$text->render ();
							
							$text = new TextArea();
							$text->label = Lang::get ( "Description" );
							$text->required = false;
							$text->value = $product->description;
							$text->name = "product[description]";
							$text->class = "ckeditor";
							$text->render ();
							
							
							?>
							<input type="hidden" name="product[price]" value="0" /> <input type="hidden" name="product[salePrice]" value="0" />
						</div>
						<!-- End Tab General -->
					</div>
					<div class="tab-pane" id="tab_language">
						<?php include_once 'lang/product_lang_form_edit_data.php';?>
					</div>
					<div class="tab-pane" id="tab_price">
						<?php include_once 'price/product_price_form_edit_data.php';?>
					</div>
					<div class="tab-pane" id="tab_region">
						<?php include_once 'region/product_region_edit_view_data.php';?>
					</div>
					<div class="tab-pane" id="tab_relate">
						<?php include_once 'relation/product_relation_edit_view_data.php';?>
					</div>
					<div class="tab-pane" id="tab_image">
						<?php include_once 'image/product_image_edit_view_data.php';?>
					</div>
					<div class="tab-pane" id="tab_seo">
						<?php include_once 'seo/product_seo_form_edit_data.php';?>
					</div>
					<div class="tab-pane" id="tab_attribute">
						<?php include_once 'attribute/product_attribute_form_edit_data.php'; ?>
					</div>
					<div class="tab-pane" id="tab_design">
						<?php include_once 'design/product_design_form_edit_data.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$(".check-featured").click(function(){
		if($(this).is(":checked")){
			$(this).val("yes");
		}else{
			$(this).val("no");
		}
	});
	$("textarea.ckeditor").ckeditor();
});
function loadProductAttribute(){
	var categoryId = $("#product_category").val();
	simpleAjaxPostUpload(
		guid(),
		'<?=ActionUtil::getFullPathAlias("admin/product/attribute")?>?rtype=json&categoryId='+categoryId + "&productId=<?= AppUtil::defaultIfEmpty($product->id) ?>",
		"",
		selectCategorySuccess,
		selectCategoryFielError,
		selectCategoryActionError
	);
}

function selectCategorySuccess(res) {
	$("#tab_attribute").html(res.content);
}
function selectCategoryFielError(res) {

}
function selectCategoryActionError(res) {
	showMessage(res.errorMessage, "error");
	window.location.reload();
}
</script>