<?php
use common\template\extend\Text;
use core\utils\AppUtil;
?>

<div class="form-group <?php echo !empty($errorMessage)?'has-error':''?>">
	<label class="control-label"><?php
	
echo $label;
	if ($required) :
		?>
			<span class="required" aria-required="true"> * </span> 
			<?php endif;?>
	</label>
		<?php
		
		$text = new Text ();
		AppUtil::copyProperties ( $sourceElement, $text );
		$text->class = empty ( $class ) ? "form-control input-sm" : $class;
		$text->attributes = ' aria-required="true" aria-describedby="name-error" aria-invalid="false" data-required="1"';
		if ($readonly) {
			$text->attributes = $text->attributes . " readonly";
		}
		$text->render ();
		?>
		<span class="help-block"><?=$errorMessage?></span>
</div>