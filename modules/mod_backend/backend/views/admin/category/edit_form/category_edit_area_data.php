<?php

use common\template\extend\ImageInput;
use core\utils\RequestUtil;
use common\template\extend\TextInput;
use core\Lang;
use common\template\extend\Text;

$areaCats = RequestUtil::get("areaCats")->getArray();
?>
<div class="form-horizontal form-row-seperated" >
	<div class="portlet light">
		<?php
		foreach ($areaCats as $indexA=>$area){
			$image = new ImageInput();
			$image->label = $area->name;
			$image->name = "areaCats[$indexA][image]";
			$image->value = $area->image;
			$image->hasImgAction = true;
			$image->id = "area_".$area->categoryId."_".$area->id;
			$image->profileId = "area";
			$image->row = 1;
			$image->render ();

			$text = new Text();
			$text->type = "hidden";
			$text->name = "areaCats[$indexA][areaId]";
			$text->value = $area->areaId;
			$text->render();

			$text = new TextInput();
			$text->errorMessage = RequestUtil::getFieldError ( "areaCats[$indexA][description]" );
			$text->hasError = RequestUtil::isFieldError ( "areaCats[$indexA][description]" );
			$text->label = Lang::get ( "Description" );
			$text->name = "areaCats[$indexA][description]";
			$text->required = true;
			$text->placeholder = Lang::get("Description...");
			$text->value = $area->description;
			$text->class = "form-control";
			$text->render ();

		}
		?>
	</div>
</div>
<script type="text/javascript">
    $(document).on('click', '.delete_image', function(){
        $(this).parents('li').fadeOut(500, function(){
            $(this).remove();
        });
    });

    $(document).ready(function(){
        $("#sortable").sortable();
    });

</script>
