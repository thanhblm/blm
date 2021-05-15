<?php
use core\Lang;
use core\utils\RequestUtil;

// get data
$gridVo = RequestUtil::get ( "gridVo" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">
		<?=Lang::get("Add widget to grid")?>
		<span class='modal-title-widget'>
			#<?php echo $gridVo->id?>
		</span>
	</h4>
</div>
<div class="modal-body">
	<?php include_once 'widget_content_add_res_data.php'; ?>
</div>