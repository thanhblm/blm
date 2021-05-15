<?php
use common\template\extend\ModalTemplate;
use core\Lang;
use core\utils\ActionUtil;
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Backend menu")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="backend_menu_search_form">
							<div id="backend_menu_data">
								<?php include "backend_menu_list_data.php"?>
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
$modalTemplate->id = "backend_menu_dialog";
$modalTemplate->size = 800;
$modalTemplate->render ();
?>

<script type="text/javascript">
	function addBackendMenu(){
		simpleCUDModal(
			"#backend_menu_dialog",
			"#add_backend_menu_form",
			guid(),
			"#btnAddBackendMenu",
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/add/view?rtype=json")?>",
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/add?rtype=json")?>",
			refreshBackendMenu
		);
	}

	function editBackendMenu(id){
		simpleCUDModal(
			"#backend_menu_dialog",
			"#edit_backend_menu_form",
			guid(),
			"#btnEditBackendMenu",
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/edit/view?rtype=json")?>&id=${id}" ,
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/edit?rtype=json")?>",
			refreshBackendMenu
		);
	}

	function deleteBackendMenu(id){
		simpleCUDModal(
			"#backend_menu_dialog",
			"#del_backend_menu_form",
			guid(),
			"#btnDelBackendMenu",
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/del/view?rtype=json")?>&id=${id}",
			"<?=ActionUtil::getFullPathAlias("admin/backend/menu/del?rtype=json")?>",
			refreshBackendMenu
		);
	}
</script>

<script type="text/javascript">
	function refreshBackendMenu(dialogId,btnId,res){
        var showInfoStatus = $('input[name="showInfoStatus"]').val();
		var data = {'showInfoStatus': showInfoStatus};
		$.post("<?=ActionUtil::getFullPathAlias("admin/backend/menu/refresh?rtype=json")?>", data, function(res) {
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$('#backend_menu_data').html(res.content);
				$(dialogId).modal("toggle");

				//message
				var message = '<?=Lang::get('Menu update success')?>';
				showMessage(message, 'success', true);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			alert("System error.");
		});
	}
</script>