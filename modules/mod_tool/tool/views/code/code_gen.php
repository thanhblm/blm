<?php
use core\utils\RequestUtil;
use core\Lang;
?>
<h3><?=Lang::get('Code Generator');?></h3>
<?php
if (RequestUtil::hasActionErrors ()) {
	?>
<div class="alert alert-danger" role="alert">
	<?=RequestUtil::getErrorMessage ();?>
</div>
<?php
}
if (! RequestUtil::hasErrors () && ! is_null ( RequestUtil::getActionMessage () )) {
	?>
<div class="alert alert-info" role="alert">
	<?=RequestUtil::getActionMessage ();?>
</div>
<?php
}
?>
<form action="" method="post" style="max-width: 300px">
	<input type="text" name="dbName" class="form-control"
		value="<?=RequestUtil::get('dbName') ?>"
		placeholder="<?=Lang::get('Database name');?>" />
	<?php
	if (RequestUtil::hasFieldErrors ()) {
		?>
	<span class="help-block alert-danger"><?=RequestUtil::getFieldError('dbName') ?></span>
	<?php
	}
	?>
	<br /> <input type="text" name="moduleName" class="form-control"
		value="<?=RequestUtil::get('moduleName') ?>"
		placeholder="<?=Lang::get('Module Name');?>" /> <br /> <input
		type="text" name="tableName" class="form-control"
		value="<?=RequestUtil::get('tableName') ?>"
		placeholder="<?=Lang::get('Table name');?>" />
	<?php
	if (RequestUtil::hasFieldErrors ()) {
		?>
	<span class="help-block alert-danger"><?=RequestUtil::getFieldError('tableName') ?></span>
	<?php
	}
	?>
	<br /> <input type="text" name="destFolder" class="form-control"
		value="<?=RequestUtil::get('destFolder') ?>"
		placeholder="<?=Lang::get('Destination folder');?>" />
		<?php
		if (RequestUtil::hasFieldErrors ()) {
			?>
	<span class="help-block alert-danger"><?=RequestUtil::getFieldError('destFolder') ?></span>
	<?php
		}
		?><br />
	<button class="btn btn-lg btn-primary btn-block" type="submit"><?=Lang::get('Generate');?></button>
</form>