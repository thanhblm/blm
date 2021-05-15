<?php
use core\utils\RequestUtil;
if (RequestUtil::hasFieldErrors ()) {
	?>
<div class="alert alert-danger" role="alert"><?=RequestUtil::getFieldError("upload.error")?></div>
<?php
}
?>