<?php
use common\template\extend\LabelContainer;
use common\template\extend\Link;
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Regions")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="region_search_form">
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
									$select->attributes = "onchange=\"refreshRegions()\"";
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
										$link->link = ActionUtil::getFullPathAlias ( 'admin/region/add/view' );
										$link->checkActionPath = "admin/region/add/view";
										$link->render ();
										?>
									</div>
								</div>
							</div>
							<div id="region_search_result">
								<?php include "region_list_data.php"?>
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
$modalTemplate->id = "region_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showRegions("id","asc");
		$("#btnAddRegionDialog").click(function(){
			simpleCUDModal(
				"#region_dialog",
				"#add_region_form",
				guid(),
				"#btnAddRegion",
				"<?=ActionUtil::getFullPathAlias("admin/region/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/region/add?rtype=json")?>",
				refreshRegions
			);
		});
	});
	function onExportCsv(){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/region/export/csv")?>";
	}
	function deleteRegionDialog(id){
		simpleCUDModal(
				"#region_dialog",
				"#del_region_form",
				guid(),
				"#btnDelRegion",
				"<?=ActionUtil::getFullPathAlias("admin/region/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/region/del?rtype=json")?>",
				refreshRegions
			);
	}
	function showRegions(field,direction){
		$("#region_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","currencyCode","fallbackRegion","status",""],
			callback : sortRegions
		});
	}
	function sortRegions(field, direction, is_reset = false){
		App.blockUI({
            target: '#region_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#region_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/region/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#region_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#region_search_result").html(res.content);
				// Update view for sorting.
				showRegions(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#region_table');
			alert("System error.");
		});
	}
	function searchRegions(is_reset = false){
		$("#region_search_form #page").val(1);
		sortRegions("id","asc",is_reset);
	}
	function changePageRegions(page){
		var field = $("#region_table").attr("field");
		var direction = $("#region_table").attr("direction");
		$("#region_search_form #page").val(page);
		sortRegions(field,direction);
	}
	function refreshRegions(dialogId,btnId,res){
		var field = $("#region_table").attr("field");
		var direction = $("#region_table").attr("direction");
		sortRegions(field,direction);
		$(dialogId).modal("toggle");
	}
</script>