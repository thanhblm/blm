<?php
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;
?>
<div class="form-group <?php $hasError?'has-error':''?>">
	<label class="control-label col-md-4">
<?php
echo $label;
if ($required) {
	?>
	<span class="required" aria-required="true"> * </span> 
	<?php } ?>
	</label>
	<div class="col-md-8">
		<?php
		$str = ! empty ( $class ) ? "class='$class'" : "class = 'form-control input-sm'";
		$str .= $required == true ? "required='true'" : "";
		$select = new BaseSelect();
		AppUtil::copyProperties ( $sourceElement, $select );
		$select->attributes = $select->attributes . " " . $str;
		$select->render ();
		?>
		<span class="help-block"><?=$errorMessage?></span>
	</div>
</div>