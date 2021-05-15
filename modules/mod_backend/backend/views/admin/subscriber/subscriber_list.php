<?php
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\Select;
use common\template\extend\ModalTemplate;
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Subscribers")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="subscriber_search_form">
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
									$select->attributes = "onchange=\"refreshSubscribers()\"";
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
										$button->id = "btnAddSubscriberDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->checkActionPath = "admin/subscriber/add/view";
										$button->render ();
										
										$button = new Button ();
										$button->type = "button";
										$button->id = "btnExportCsv";
										$button->title = " " . Lang::get ( 'Export to CSV' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" onExportCsv() \"";
										$button->checkActionPath = "admin/subscriber/export/csv";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="subscriber_search_result">
								<?php include "subscriber_list_data.php"?>
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
$modalTemplate->id = "subscriber_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showSubscribers("crDate","desc");
		$("#btnAddSubscriberDialog").click(function(){
			simpleCUDModal(
				"#subscriber_dialog",
				"#add_subscriber_form",
				guid(),
				"#btnAddSubscriber",
				"<?=ActionUtil::getFullPathAlias("admin/subscriber/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/subscriber/add?rtype=json")?>",
				refreshSubscribers
			);
		});
	});
	function onExportCsv(){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/subscriber/export/csv")?>";
	}
	function editSubscriberDialog(id){
		simpleCUDModal(
			"#subscriber_dialog",
			"#edit_subscriber_form",
			guid(),
			"#btnEditSubscriber",
			"<?=ActionUtil::getFullPathAlias("admin/subscriber/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/subscriber/edit?rtype=json")?>",
			refreshSubscribers
		);
	}
	function copySubscriberDialog(id){
		simpleCUDModal(
			"#subscriber_dialog",
			"#copy_subscriber_form",
			guid(),
			"#btnCopySubscriber",
			"<?=ActionUtil::getFullPathAlias("admin/subscriber/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/subscriber/copy?rtype=json")?>",
			refreshSubscribers
		);
	}
	function deleteSubscriberDialog(id){
		simpleCUDModal(
				"#subscriber_dialog",
				"#del_subscriber_form",
				guid(),
				"#btnDelSubscriber",
				"<?=ActionUtil::getFullPathAlias("admin/subscriber/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/subscriber/del?rtype=json")?>",
				refreshSubscribers
			);
	}
	function showSubscribers(field,direction){
		$("#subscriber_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","email","firstName","lastName","status"],
			callback : sortSubscribers
		});
	}
	function sortSubscribers(field, direction, is_reset = false){
		App.blockUI({
            target: '#subscriber_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#subscriber_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/subscriber/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#subscriber_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#subscriber_search_result").html(res.content);
				// Update view for sorting.
				showSubscribers(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#subscriber_table');
			alert("System error.");
		});
	}
	function searchSubscribers(is_reset = false){
		$("#subscriber_search_form #page").val(1);
		sortSubscribers("crDate","desc",is_reset);
	}
	function changePageSubscribers(page){
		var field = $("#subscriber_table").attr("field");
		var direction = $("#subscriber_table").attr("direction");
		$("#subscriber_search_form #page").val(page);
		sortSubscribers(field,direction);
	}
	function refreshSubscribers(dialogId,btnId,res){
		var field = $("#subscriber_table").attr("field");
		var direction = $("#subscriber_table").attr("direction");
		sortSubscribers(field,direction);
		$(dialogId).modal("toggle");
	}
</script>