<?php
use core\Lang;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Contact detail")?></h4>
</div>
<div class="modal-body">
	<?php include_once 'contact_detail_res_data.php'; ?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-sm grey margin-bottom-5" data-dismiss="modal" id="close-contact"><?=Lang::get("Close")?></button>
</div>