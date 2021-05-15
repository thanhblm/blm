<?php
use common\template\extend\Select;
use core\utils\AppUtil;

?>

<div class="<?= $required ? "required" : "" ?> _field <?php echo $hasError ? 'has-error' : '' ?>">
	<?php
	if (!empty ($label)) {
		?>
        <div class="_label"><?= $label ?></div>
		<?php
	}
	?>
    <div class="_input">
        <span class="frm _field frm_select">
            <?php
            $select = new Select ();
            AppUtil::copyProperties($sourceElement, $select);
            $select->render();
            ?>
        </span>
        <span class="help-block"><?= $errorMessage ?></span>
    </div>
</div>