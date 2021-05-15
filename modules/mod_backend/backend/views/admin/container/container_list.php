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
<div class="container-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Container")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="container_search_form">
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
									$select->attributes = "onchange=\"refreshContainers()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$link = new Link ();
										$link->class = "btn btn-sm btn-success margin-bottom-5";
										$link->title = "<i class=\"fa fa-plus\"></i> " . Lang::get ( 'Add New' );
										$link->link = ActionUtil::getFullPathAlias ( 'admin/container/add/view' );
										$link->render ();
										?>
									</div>
								</div>
							</div>
							<div id="container_search_result">
								<?php include "container_list_data.php"?>
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
$modalTemplate->id = "container_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();
?>

<script type="text/javascript">
	$(document).ready(function(){
		showContainers("id","asc");
	});
	function showContainers(field,direction){
		$("#container_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","position", ""],
			callback : sortContainers
		});
	};
	function sortContainers(field, direction, is_reset = false){
		App.blockUI({
            target: '#container_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#container_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/container/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#container_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#container_search_result").html(res.content);
				// Update view for sorting.
				showContainers(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#container_table');
			alert("System error.");
		});
	};
	function searchContainers(is_reset = false){
		$("#container_search_form #page").val(1);
		sortContainers("id","asc", is_reset);
	}

	function changeContainerPages(page){
		var field = $("#container_table").attr("field");
		var direction = $("#container_table").attr("direction");
		$("#container_search_form #page").val(page);
		sortContainers(field,direction);
	}
	function refreshContainers(dialogId,btnId,res){
		var field = $("#container_table").attr("field");
		var direction = $("#container_table").attr("direction");
		sortContainers(field,direction);
		$(dialogId).modal("toggle");
	}
</script>

<script type="text/javascript">
	function deleteContainerDialog(containerId){
		simpleCUDModal(
			"#container_dialog",
			"#del_container_form",
			guid(),
			"#btnDel",
			"<?=ActionUtil::getFullPathAlias("admin/container/del/view?rtype=json&containerId=")?>" + containerId,
			"<?=ActionUtil::getFullPathAlias("admin/container/del?rtype=json")?>",
			function(dialogId,btnId,res){
				refreshContainers(dialogId,btnId,res);
				var message = '<?=Lang::get('Delete container is success')?>';
				showMessage(message, 'success');
			},
            function (dialogId,btnId,res){	//field error callback
                showMessage(res.errorMessage, "error", true);
            }
		);
	}
</script>