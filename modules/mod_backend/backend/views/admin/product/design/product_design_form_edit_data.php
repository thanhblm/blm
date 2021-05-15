<?php

use core\Lang;
?>
<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-3">
		<div class="tabbable-line">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_edit_text" data-toggle="tab"><?= Lang::get('Text') ?> </a>
				</li>
				<li>
					<a href="#tab_edit_art" data-toggle="tab"> <?= Lang::get('Art') ?> </a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_edit_text">
					<?php include_once 'design/area_edit_text_data.php'; ?>
				</div>
				<div class="tab-pane" id="tab_edit_art">
					<?php include_once 'design/area_edit_art_data.php'; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="tabbable-line">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_edit_front" data-toggle="tab"><?= Lang::get('Front') ?> </a>
				</li>
				<li>
					<a href="#tab_edit_back" data-toggle="tab"> <?= Lang::get('Back') ?> </a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_edit_front">
					<?php include_once 'design/area_edit_front_data.php'; ?>
				</div>
				<div class="tab-pane" id="tab_edit_back">
					<?php include_once 'design/area_edit_back_data.php'; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-3">
		Style & design
	</div>
</div>
