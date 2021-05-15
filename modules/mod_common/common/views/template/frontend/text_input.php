<?php
use common\template\extend\Text;
use core\utils\AppUtil;

?>
<div class="col-md-12 form-group <?= $required ? "required" : "" ?> _field <?php echo $hasError ? 'has-error' : '' ?>">
	<?php

	if (!empty ($label)) {
		?>
        <div class="_label"><?= $label ?></div>
		<?php
	}
	?>
	<?php if (!AppUtil::isEmptyString($helperText)){?>
		<span class="form-helper-text"><?=$helperText?></span>
	<?php }?>
		<?php
		$text = new Text ();
		AppUtil::copyProperties($sourceElement, $text);
		$text->class = empty ($class) ? " " : $class;
		$text->attributes = ' aria-required="true" aria-describedby="name-error" aria-invalid="false" data-required="1"';
		if ($readonly) {
			$text->attributes = $text->attributes . " readonly";
		}
		$text->render();
		?>
        <span class="help-block"><?= $errorMessage ?></span>
</div>