<?php
use core\utils\AppUtil;
use common\template\extend\Text;

$appendAttribute = " readonly='readonly'";
$text = new Text ();
AppUtil::copyProperties($sourceElement, $text);
$text->attributes .= " " . $appendAttribute;

?>
<div class="form-group <?php echo $hasError ? 'has-error' : '' ?>">
    <label class="control-label col-md-4"><?php

		echo $label;
		if ($required) :
			?>
            <span class="required" aria-required="true"> * </span>
		<?php endif; ?>
    </label>
    <div class="col-md-8">
        <div class="input-group" data-date-format="yyyy/mm/dd">
			<?php $text->render(); ?>
            <span class="input-group-btn">
				<button class="btn btn-sm default" type="button">
					<i class="fa fa-calendar"></i>
				</button>
			</span>
            <span class="help-block"><?= $errorMessage ?></span>
        </div>
    </div>
</div>