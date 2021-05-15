<?php
use common\template\extend\Checkbox;
use core\utils\AppUtil;
use core\template\html\base\BaseCheckBox;
?>
<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label col-md-4"><?=$label?><?=$required?"<span class='required' aria-required='true'> * </span>":""?>  </label>
<div class="col-md-8">
	<?php
	$checkbox = new Checkbox();
	AppUtil::copyProperties ( $sourceElement, $checkbox );
	echo $prepend;
	$checkbox->render ();
	echo $append;
	?>
	<span class="help-block"><?=$errorMessage?></span>
</div>
</div>
