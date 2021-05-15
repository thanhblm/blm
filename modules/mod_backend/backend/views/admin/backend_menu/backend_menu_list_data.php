<?php
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;
use common\utils\RenderUtil;
use core\utils\ActionUtil;

$backendMenuList = RequestUtil::get ( "backendMenuList" );
$viewPath = RequestUtil::get("viewPath");
$showInfoStatus = RequestUtil::get('showInfoStatus');
// var_dump($backendMenuList);
?>

<link href="<?=AppUtil::resource_url("global/scripts/jquery.nestable/jquery.nestable.css") ?>" rel="stylesheet" type="text/css" />
<script src="<?=AppUtil::resource_url("global/scripts/jquery.nestable/jquery.nestable.js") ?>" type="text/javascript"></script>

<div class="portlet-body ">
	<div class="col-md-6">
		<div id="nestable-menu">
			<div data-action="expand-all" class="btn btn-primary">
				<i class="fa fa-plus margin-right-5"></i><?=Lang::get('Expand All')?>
			</div>
			<div data-action="collapse-all" class="btn btn-primary">
				<i class="fa fa-minus margin-right-5"></i><?=Lang::get('Collapse All')?>
			</div>
			<div class="btn btn-default show_info_button">
				<i class="fa fa-info margin-right-5"></i>
                <span><?= ($showInfoStatus) ? Lang::get('Hide info') : Lang::get('Show info')?></span>
			</div>
            <input type="hidden" value="<?=$showInfoStatus?>" name="showInfoStatus">
			<a class="btn btn-primary btn_save right" href="javascript:addBackendMenu()">
				<i class="fa fa-plus margin-right-5"></i>
				<?=Lang::get('Add')?>
			</a>
		</div>
		
		<div class="dd nestable" id="nestable">
			<ul class="dd-list">
				<?php 
					if(!empty($backendMenuList)){
						$template = $viewPath .'/admin/backend_menu/backend_menu_item_data.php';
						$params = array(
						);
						RenderUtil::recursive($backendMenuList, 0, 0, 0, true, $template, $params);
					}
				?>
			</ul>
		</div>
	</div>
</div>

<!-- nestable menu-->
<script type="text/javascript">
	function nestableSortable(){
		var order = 0;
		var backendMenuList = [];
		$('.nestable li').each(function(){
			order++;
			var id = $(this).data('id');
			var level = $(this).data('level');
			var parentId = $(this).parents('li').data('id');
			if(typeof(parentId) == 'undefined') parentId = 0;
//			console.log(`id = ${id} ... parentId = ${parentId} ... order = ${order}`);
			var backendMenuData = {'id': id, 'parentId': parentId, 'order': order};
			backendMenuList.push(backendMenuData);
		});
		return backendMenuList;		
	}

	$(document).ready(function(){
	    $('#nestable-menu').on('click', function(e){
	        var target = $(e.target),
	            action = target.data('action');
	        if (action === 'expand-all') {
	            $('.dd').nestable('expandAll');
	        }
	        if (action === 'collapse-all') {
	            $('.dd').nestable('collapseAll');
	        }
	    });
	    $('#nestable').nestable({
		    'listNodeName': 'ul'
		}).on('change', function(e) {
			var backendMenuList = nestableSortable();
            var showInfoStatus = $('input[name="showInfoStatus"]').val();
			var data = {'backendMenuList': backendMenuList, 'showInfoStatus': showInfoStatus};
			simpleAjaxPost(
				guid(), 
			    "<?=ActionUtil::getFullPathAlias("admin/backend/menu/sortable?rtype=json")?>",
			    data,
			    function (res){
					var message = '<?php echo Lang::get('The menu updated successfully')?>';
					showMessage(message, 'success', true);
   				 	$("#backend_menu_data").html(res.content);
				}
			);
		});
	});
</script>

<script type="text/javascript">
	$(".show_info_button").click(function() {
        $(".show_info").toggle();
        var showInfoStatus = $('input[name="showInfoStatus"]').val();
        if(showInfoStatus == 1){
            $('input[name="showInfoStatus"]').val(0);
            $(this).find('span').html('<?=Lang::get('Show Info')?>');
        }
        else{
            $('input[name="showInfoStatus"]').val(1);
            $(this).find('span').html('<?=Lang::get('Hide Info')?>');
        }
	});
</script>