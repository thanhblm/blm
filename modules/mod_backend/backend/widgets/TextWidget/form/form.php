<?php
namespace layout\widgets;
use core\Lang;
use core\utils\AppUtil;

?>
<div class="tabbable-line">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#default" data-toggle="tab"> <?= Lang::get("Default") ?> </a>
        </li>
        <li>
            <a href="#localization" data-toggle="tab"> <?= Lang::get("Localization") ?> </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="default">
			<?php include 'form_default.php'; ?>
        </div>
        <div class="tab-pane" id="localization">
			<?php include 'form_localization.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		mutilLanguagesPercen();
		$('textarea.ckeditor').ckeditor();
	})
</script>