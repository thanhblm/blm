<?php 

use core\utils\AppUtil;
use core\template\html\base\BaseTextArea;

?>
<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label"><?php echo $label; 
		if ($required):?>
		<span class="required" aria-required="true"> * </span> 
		<?php endif;?>
	</label>
<?php
$appendAttribute = ! empty ( $class ) ? "class='$class'" : "class = 'form-control form-filter input-sm'";
$appendAttribute .= " ".(! empty ( $placeholder ) ? "placeholder='$placeholder'" : "");
$textarea = new BaseTextArea();
AppUtil::copyProperties($sourceElement, $textarea);
$textarea->attributes .= " " . $appendAttribute;
$textarea->render();
?>
		<span class="help-block"><?=$errorMessage?></span>
</div>