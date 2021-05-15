<?php

use core\Lang;
use core\utils\RequestUtil;
$category = RequestUtil::get("categoryBlog");
?>
<form id="del_category_blog_form" class="form-horizontal" novalidate="novalidate">
	<input name="id" type="hidden" value="<?=$category->id; ?>" />
	<div class="form-body">
		<p><?=Lang::getWithFormat("Are you sure you want to delete <b>{0}</b>?",$category->name)?></p>
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>