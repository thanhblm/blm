<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\RequestUtil;
$blog = RequestUtil::get ( "blog" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete Blog")?></h4>
</div>
<div class="modal-body">
	<form id="del_blog_form" class="form-horizontal" novalidate="novalidate">
		<input name="id" type="hidden" value="<?=$blog->id?>" />
		<div class="form-body">
			<p><?=Lang::getWithFormat("Are you sure you want to delete the blog [{0}]?",$blog->name)?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnDelBlog";
	$button->title = " " . Lang::get ( "Yes" );
	$button->class = "btn btn-sm blue margin-bottom-5";
	$button->attributes = "";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "No" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>