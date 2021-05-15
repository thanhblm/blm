<?php
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\helper\DatoImageHelper;
$blogImages = RequestUtil::get('blogImages');
?>

<div class="form-horizontal form-row-seperated" >
	<div class="portlet light">
		<div class="portlet-title">
			<div class="actions btn-set">
				<?php 
				$link = new Link();
				$link->link = ActionUtil::getFullPathAlias("file/manager?")."field_id=image_add&pid=blog";
				$link->title = "<i class='fa fa-plus'></i>".Lang::get("Add Image");
				$link->class = "btn btn-primary popup left";
				$link->attributes = "title='Image preview'";
				$link->render();
				?>
			</div>
		</div>
		<div>
			<input type="hidden" class="" value="" id="image_add">
			<ul id="sortable" class="input_multi_file" style="list-style-type:none">
				<?php 
				if(count($blogImages)>0){
					$index = 1;
				foreach ($blogImages as $imageUrl){
					$imageMo = DatoImageHelper::getImageInfoById($imageUrl);
					?>
				<li class='input_file input_file'>
					<div class="input_file">
						<div class="input_file_preview">
							<input type="hidden" class="image_source form-control" value="<?=$imageUrl?>" name=blogImages[] id="id_image<?=$index?>">
							<div class="image_preview_wrap image_center">
								<a class="fancybox image_preview_link image_preview_link" id="id_image_image_preview_link" href="<?php echo DatoImageHelper::getUrl($imageMo)?>" title="Image preview">
									<img id="id_image_image_preview" class="image_preview image_preview" src="<?php echo DatoImageHelper::getSmallImageUrl($imageMo)?>" alt="Image preview" title="Image preview">
								</a>
							</div>
						</div>
						<div class="clear"></div>
						
							<div class="image-action">
								<a class="btn btn-primary popup left" title="Image preview" href="<?=ActionUtil::getFullPathAlias("file/manager?")."field_id=id_image".$index."&pid=blog"?>">
									Select image					</a>
								<div class="margin-left-10 button_delete delete_image" title="Delete item">
									<i class="fa fa-trash" title="Delete image"></i>
								</div>
							</div>
						</div>
				</li>
					<?php
					$index++;
				}
				}
				?>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#sortable").sortable();
	});
	$(document).on('click', '.delete_image', function(){
		$(this).parents('li').fadeOut(500, function(){
			$(this).remove();
		});
	});
	
</script>
