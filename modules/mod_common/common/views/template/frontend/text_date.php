<?php 

use core\utils\AppUtil;
use common\template\extend\Text;

$appendAttribute = " readonly='readonly'";
$text = new Text();
AppUtil::copyProperties($sourceElement, $text);
$text->attributes .= " " . $appendAttribute;

?>

<div class="input-group date date-picker margin-bottom-5"
	data-date-format="dd/mm/yyyy">
	<?php $text->render(); ?>
	<span class="input-group-btn">
		<button class="btn btn-sm default" type="button">
			<i class="fa fa-calendar"></i>
		</button>
	</span>
</div>