<?php
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Categories")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="category_search_form">
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
									$select->attributes = "onchange=\"refreshCategories()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button ();
										$button->type = "button";
										$button->id = "btnAddCategoryDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\"onAddCategory()\"";
										$button->checkActionPath = "admin/category/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="category_search_result">
								<?php include "category_list_data.php"?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<?php
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "category_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "delete_category_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showCategories("id","asc");
	});
	function onAddCategory(){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/category/add/view")?>";
	}
	function onEditCategory(id){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/category/edit/view?id=")?>"+id;
	}
	function onCopyCategory(id){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/category/copy/view?id=")?>"+id;
	}
	function deleteCategoryDialog(id){
		simpleCUDModal(
				"#delete_category_dialog",
				"#del_category_form",
				guid(),
				"#btnDelCategory",
				"<?=ActionUtil::getFullPathAlias("admin/category/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/category/del?rtype=json")?>",
				refreshCategories
			);
	}
	function showCategories(field,direction){
		$("#category_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : sortCategories
		});
	}
	function sortCategories(field, direction, is_reset = false){
		App.blockUI({
            target: '#category_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#category_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/category/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#category_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#category_search_result").html(res.content);
				// Update view for sorting.
				showCategories(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#category_table');
			alert("System error.");
		});
	}
	function searchCategories(is_reset = false){
		$("#category_search_form #page").val(1);
		sortCategories("id","asc", is_reset);
	}

	function changePageCategories(page){
		var field = $("#category_table").attr("field");
		var direction = $("#category_table").attr("direction");
		$("#category_search_form #page").val(page);
		sortCategories(field,direction);
	}
	function refreshCategories(dialogId,btnId,res){
		var field = $("#category_table").attr("field");
		var direction = $("#category_table").attr("direction");
		sortCategories(field,direction);
		$(dialogId).modal("toggle");
	}
</script>