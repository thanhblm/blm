<?php
use common\template\extend\LabelContainer;
use common\template\extend\Link;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\helper\SettingHelper;

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
						<span class="caption-subject bold uppercase"><?=Lang::get("Page")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="page_search_form">
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
									$select->attributes = "onchange=\"refreshPages()\"";
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
										$link->link = ActionUtil::getFullPathAlias ( 'admin/page/add/view' );
										$link->checkActionPath = "admin/page/add/view";
										$link->render ();

                                        $link = new Link ();
                                        $link->class = "btn btn-sm blue margin-bottom-5";
                                        $link->title = "<i class=\"fa fa-refresh\"></i> " . Lang::get ( 'Recache All' );
                                        $link->link = "javascript:recachePageAllView()";
                                        $link->checkActionPath = "admin/page/recache/page/all/view";
                                        $link->render ();
										?>
									</div>
								</div>
							</div>
							<div>
								<div class="table-group-actions pull-right">
									<span style="font-size:.8em">
									* Global page cache <b><?php echo  SettingHelper::getSettingValue("Page Cache Enable") === "yes"?"Enable":"Disable"?></b></span>
								</div>
							</div>
							<div id="page_search_result">
								<?php include "page_list_data.php"?>
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
$modalTemplate->id = "page_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "delete_page_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showPages("id","asc");
	});
	function showPages(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","", ""],
			callback : sortPages
		});
	}
	function sortPages(field, direction, is_reset = false){
		App.blockUI({
            target: '#page_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#page_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/page/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#page_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#page_search_result").html(res.content);
				// Update view for sorting.
				showPages(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#page_table');
			alert("System error.");
		});
	}
	function searchPages(is_reset = false){
		$("#page_search_form #page").val(1);
		sortPages("id","asc", is_reset);
	}

	function changePagePages(page){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		$("#page_search_form #page").val(page);
		sortPages(field,direction);
	}
	function refreshPages(dialogId,btnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortPages(field,direction);
		$(dialogId).modal("toggle");
	}
</script>

<script type="text/javascript">
	function deletePageDialog(pageId){
		simpleCUDModal(
			"#delete_page_dialog",
			"#del_page_form",
			guid(),
			"#btnDelPage",
			"<?=ActionUtil::getFullPathAlias("admin/page/del/view?rtype=json&pageId=")?>" + pageId,
			"<?=ActionUtil::getFullPathAlias("admin/page/del?rtype=json")?>",
			function(dialogId,btnId,res){
				refreshPages(dialogId,btnId,res);
				var message = '<?=Lang::get('Delete page is success')?>';
				showMessage(message, 'success');
			},
            function (dialogId,btnId,res){	//field error callback
                showMessage(res.errorMessage, "error", true);
            }
		);
	}
</script>

<!-- cache page-->
<script type="text/javascript">
    function recachePageView(pageId){
        simpleCUDModal(
            "#page_dialog",
            "#page_dialog_form",
            guid(),
            "#btnAction",
            "<?=ActionUtil::getFullPathAlias("admin/page/recache/page/view?rtype=json")?>" + `&pageId=${pageId}`,
            "<?=ActionUtil::getFullPathAlias("admin/page/recache/page?rtype=json")?>",
            function (dialogId,btnId,res){
                refreshPages(dialogId,btnId,res);
                //message
                showMessage('<?=Lang::get('Recache page is success')?>', 'success', true);
            }
        );
    }

    function recachePageAllView(){
        simpleCUDModal(
            "#page_dialog",
            "#page_dialog_form",
            guid(),
            "#btnAction",
            "<?=ActionUtil::getFullPathAlias("admin/page/recache/page/all/view?rtype=json")?>",
            "<?=ActionUtil::getFullPathAlias("admin/page/recache/page/all?rtype=json")?>",
            function (dialogId,btnId,res){
                refreshPages(dialogId,btnId,res);
                //message
                showMessage('<?=Lang::get('Recache all page is success')?>', 'success', true);
            }
        );
    }

    function pageCacheEnableView(pageId){
        simpleCUDModal(
            "#page_dialog",
            "#page_dialog_form",
            guid(),
            "#btnAction",
            "<?=ActionUtil::getFullPathAlias("admin/page/page/cache/enable/view?rtype=json")?>" + `&pageId=${pageId}`,
            "<?=ActionUtil::getFullPathAlias("admin/page/page/cache/enable?rtype=json")?>",
            function (dialogId,btnId,res){
                refreshPages(dialogId,btnId,res);
                //message
                showMessage('<?=Lang::get('Page cache enable is success')?>', 'success', true);
            }
        );
    }
</script>