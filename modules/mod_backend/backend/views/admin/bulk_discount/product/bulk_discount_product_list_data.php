<?php
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use common\template\extend\ButtonAction;
use core\utils\ActionUtil;

$bulkDiscountProducts = RequestUtil::get('bulkDiscountProducts');
$products = RequestUtil::get("products");
?>

<div class="table-scrollable">
	<table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable "  id="page_table_tax">
		<thead class="flip-content">
			<tr role="row">
				<th><?=Lang::get('Product');?></th>
				<th><?=Lang::get('Quantity');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody id="tbody_list_tax_rate_info">
			<?php
			if (count ( $bulkDiscountProducts->getArray()) == 0) {
				?>
			<tr role="row" id="tr_no_data">
				<td colspan="3"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				$index = 0;
				foreach ( $bulkDiscountProducts->getArray() as $discountProduct) {
					?>
			<tr class="gradeX odd productDiscountIndex" role="row">
				<td>
					<?php
					$select = new SelectInput('select_input_single');
					$select->headerKey = "";
					$select->class = "form-control input-sm";
					$select->headerValue = "Select One";
					$select->required = true;
					$select->name = "bulkDiscountProducts[".$index."][productId]";
					$select->value = $discountProduct->productId;
					$select->collections = $products;
					$select->propertyName = "id";
					$select->propertyValue = "name";
					$select->render();
					?>
				</td>
				<td>
					<?php 
					$text = new TextInput('text_input_single');
					$text->type = "number";
					$text->name = "bulkDiscountProducts[".$index."][quantity]";
					$text->value = $discountProduct->quantity;
					$text->placeholder = Lang::get("Quantity");
					$text->render ();
					?>
				</td>
				<td>
					<?php 
					$actionBtn = new ButtonAction();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->attributes = "onclick='deleteTaxRateInfoDialog($(this), ".$index.")'";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render (); 
					?>
				</td>
			</tr>
			<?php
			$index += 1;
				}
			}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".number").autoNumeric('init');
	});
	gUrlAddProduct = "<?=ActionUtil::getFullPathAlias("admin/discount/bulk/add/product") ?>" + "?rtype=json";

	function addBulkDiscountProduct(index){
	    simpleAjaxPost(
		    guid, 
		    gUrlAddProduct+"&index="+index, 
		    "", 
		    addSuccessTax, 
		    null,
		    addActionErrorTax
		    );
	}
	
	function addSuccessTax(res){
	    $("#tr_no_data").remove();
	    $("#tbody_list_tax_rate_info").append(res.content);
	    var countBulkDiscountProduct = $("tr.productDiscountIndex").length;
	    $("i#iAddBulkDiscountProduct").attr("onclick", "addBulkDiscountProduct('"+countBulkDiscountProduct+"')");
	}

	function addActionErrorTax(res){
	    showMessage(res.errorMessage, "error");
	  	$("#taxRateInfoAddFormId").replaceWith(res.content);
	}

	function deleteTaxRateInfoDialog(element,indexTr){
	    var countBulkDiscountProduct = $("tr.taxClassIndex").length;
	    $("i#iAddBulkDiscountProduct").attr("onclick", "addBulkDiscountProduct('"+(countBulkDiscountProduct-1)+"')");
		var trParent = element.parent().parent();
		trParent.nextAll().each(function(index) {
		    var inputs =  $(this).find(' input,select');
		    $(this).find("a").attr("id", "aButtonDel"+(indexTr+index));
		    $(this).find("a").attr("onclick", 'deleteTaxRateInfoDialog($(this), '+(indexTr+index)+')');
		    $.each(inputs, function(obj, v) {
				var id = $(v).attr("id");
				$(v).attr("id", id.replace("bulkDiscountProducts_"+(indexTr+index+1), "bulkDiscountProducts_"+(indexTr+index)));
				var name = $(v).attr("name");
				$(v).attr("name", name.replace("bulkDiscountProducts["+(indexTr+index+1)+"]", "bulkDiscountProducts["+(indexTr+index)+"]"));
			});
		});
		trParent.remove();
	}
</script>
