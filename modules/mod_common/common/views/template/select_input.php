<?php
use common\template\extend\Select;
use core\utils\AppUtil;
?>
<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label col-md-4"><?=$label?><?=$required?"<span class='required' aria-required='true'> * </span>":""?>  </label>
	<div class="col-md-8">
		<?php
		$select = new Select ();
		AppUtil::copyProperties ( $sourceElement, $select );
		echo $prepend;
		$select->render ();
        echo $append;
		?>
		<span class="help-block"><?=$errorMessage?></span>
	</div>
</div>