<?php
use common\template\extend\LabelContainer;
use common\template\extend\Link;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
?>
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get('Products')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form action="" id="product_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get ( 'Show' );
									$labelContainer->textAfter = Lang::get ( 'entries' );
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get ( "pageSize" );
									$select->attributes = "onchange=\"doProductSearch()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$link = new Link ();
										$link->class = "btn btn-sm blue margin-bottom-5";
										$link->title = "<i class=\"fa fa-plus\"></i> " . Lang::get ( 'Add New' );
										$link->link = ActionUtil::getFullPathAlias ( 'admin/product/add/view' );
										$link->checkActionPath="admin/product/add/view";
										$link->render ();
										?>
									</div>
								</div>
							</div>
							<div id="product_result">
								<?php include_once 'product_list_data.php'; ?>
							</div>
						</form>
					</div>

				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<div class="modal fade in" id="product_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
	$(document).ready(function(){
		showProductTableView("id","asc");
	});

	function showDeleteProductDialog(id){
		simpleCUDModal(
			"#product_dialog",
			"#del_product_form",
			guid(),
			"#btnDelProduct",
			"<?=ActionUtil::getFullPathAlias("admin/product/del/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/product/del?rtype=json")?>",
		);
	}
	
	function showProductTableView(field,direction){
		$("#product_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","itemCode","name","featured","status",""],
			callback : doProductSorting
		});
	}
	function doProductSorting(field, direction, is_reset = false){
		App.blockUI({
	        target: '#product_table'
	    });
		var data = "";
		if (!is_reset) {
			data = $("#product_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/product/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#product_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#product_result").html(res.content);
				// Update view for sorting.
				showProductTableView(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			alert("System error.");
		});
	}
	
	function doProductSearch(is_reset = false){
		$("#product_form #page").val(1);
		doProductSorting("name","asc",is_reset);
	}
	
	function onProductPageChange(page){
		var field = $("#product_table").attr("field");
		var direction = $("#product_table").attr("direction");
		$("#product_form #page").val(page);
		doProductSorting(field,direction);
	}
	function doRefreshProduct(dialogId,btnId,res){
		var field = $("#product_table").attr("field");
		var direction = $("#product_table").attr("direction");
		doProductSorting(field,direction);
		$(dialogId).modal("toggle");
	}
</script>