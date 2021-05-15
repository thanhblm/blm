<?php
use common\template\extend\Select;
use core\utils\AppUtil;
?>
<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label"><?=$label?><?=$required?"<span class='required' aria-required='true'> * </span>":""?>  </label>
		<?php
		$select = new Select ();
		AppUtil::copyProperties ( $sourceElement, $select );
		$select->class .= 'form-control input-sm';	//rermove class input-inline
        echo $prepend;
        $select->render ();
        echo $append;
		?>
		<span class="help-block"><?=$errorMessage?></span>
</div>