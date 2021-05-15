<?php

use common\helper\DatoImageHelper;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$slides = RequestUtil::get("slides");
?>
<!-- BEGIN SLIDER -->
<div class="top-line" id="top_line" data-slides="null">
	<?php
	foreach ($slides as $slide) {
		$imageMo = DatoImageHelper::getImageInfoById($slide->image);
		?>
		<div class="slide" style="background-image: url(<?= DatoImageHelper::getUrl($imageMo) ?>)" data-delay="5">
			<div class="textblock">
				<!--<div class="heading">
					<?/*= $slide->title */?>
				</div>
				<div class="body">
					<p><?/*= $slide->description */?></p>
				</div>-->
			</div>
		</div>
		<?php
	}
	?>
	<div class="bubbles">
		<span class="bubble"></span><span class="bubble"></span><span class="bubble sel"></span>
	</div>
	<a href="#find-out" class="scroll-down"><span class="icon scroll"></span><br><?= Lang::get("Scroll Down") ?></a>
	<svg viewbox="0 0 1920 110">
		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<g fill="#f5f6f9">
				<path d="M0,110 L1920,110 L1920,1 L963.969078,109.549344 C961.777017,109.798235 958.226571,109.796795 956.030922,109.54521 L0,0 L0,110 Z"/>
			</g>
		</g>
	</svg>
</div>

<!-- END SLIDER -->