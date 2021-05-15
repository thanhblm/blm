<?php
use core\utils\AppUtil;
use core\template\html\base\BaseTextArea;

?>
<div class="form-group <?=$hasError?"has-error":""?>">
	<label class="control-label col-md-4"><?=$label;?>
	<?=$required?"<span class='required' aria-required='true'> * </span>":""?></label>
	<div class="col-md-8">
		<?php
		$appendAttribute = ! empty ( $class ) ? "class='$class'" : "class = 'form-control form-filter input-sm'";
		$appendAttribute .= " " . (! empty ( $placeholder ) ? "placeholder='$placeholder'" : "");
		$textarea = new BaseTextArea ();
		AppUtil::copyProperties ( $sourceElement, $textarea );
		$textarea->attributes .= " " . $appendAttribute;
		if ($readonly) {
			$textarea->attributes = $textarea->attributes . " readonly ";
		}
		$textarea->render ();
		?>
	<span class="help-block"><?=$errorMessage?></span>
	</div>
</div>