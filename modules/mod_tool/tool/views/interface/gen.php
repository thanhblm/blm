<?php
use core\utils\RequestUtil;
use core\Lang;
?>
<h3><?=Lang::get('Interface Generator');?></h3>
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
	<input type="text" name="srcFolder" class="form-control"
		value="<?=RequestUtil::get('srcFolder') ?>"
		placeholder="<?=Lang::get('Source folder');?>" />
	<?php
	if (RequestUtil::hasFieldErrors ()) {
		?>
	<span class="help-block alert-danger"><?=RequestUtil::getFieldError('srcFolder') ?></span>
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