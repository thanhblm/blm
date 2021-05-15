<?php

use common\helper\DatoImageHelper;
use common\template\extend\ButtonAction;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$attrExtGroupVos = RequestUtil::get("groupAttributeExtVos");
?>
<div id="product_attr">
<?php
if (count($attrExtGroupVos) > 0) {
	foreach ($attrExtGroupVos as $key=>$attrGroup) {
		if (isset($attrGroup->listAttr) && count($attrGroup->listAttr->getArray()) > 0) {
			?>
			<div class="attr-item">
				<div class=" col-md-2"><?= Lang::get($attrGroup->name . ":") ?>
				<input type="hidden" name="attrGroupListId[]" value="<?=$attrGroup->id ?>" />
				</div>
				<div class="list-attr col-md-10">
					<ul style="padding: 0;">
						<?php
						foreach ($attrGroup->listAttr->getArray() as $object) {
							if ($object->type === "image") {
								$imageMo = DatoImageHelper::getImageInfoById($object->image);
								?>
								<li class="attr-image" onclick="javascript:selectAttr($(this))">
									<?php
									$actionBtn = new ButtonAction ();
									$actionBtn->iconClass = "fa fa-minus";
									$actionBtn->color = ButtonAction::COLOR_RED;
									$actionBtn->js = "removeAttributeForProduct($productId,$object->id)";
									$actionBtn->title = Lang::get ( "Add To Product" );
									$actionBtn->attributes = " style='position: absolute; margin-top: -14px;' ";
									$actionBtn->render ();
									?>
                                    <span>
                                        <input type='checkbox' style="display: inline-block;" name="attributeSelect[]" value='<?=$object->id?>' id="<?=$object->id?>"/>
                                        <img alt="image" title="<?=$object->description?>" for="thing"
                                             src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>"
                                             width="40px">
                                    </span>
								</li>
								<?php
							} else {
								?>
								<li onclick="javascript:selectAttr($(this))">
									<?php
									$actionBtn = new ButtonAction ();
									$actionBtn->iconClass = "fa fa-minus";
									$actionBtn->color = ButtonAction::COLOR_RED;
									$actionBtn->js = "removeAttributeForProduct($productId,$object->id)";
									$actionBtn->title = Lang::get ( "Add To Product" );
									$actionBtn->attributes = " style='position: absolute; margin-top: -10px;' ";
									$actionBtn->render ();
									?>
									<span title="<?=$object->description?>" >
										<input style="display: inline-block;" type='checkbox' name="attributeSelect[]" value='<?=$object->id?>' id="<?=$object->id?>"/>
										<?php echo $object->name ?>
									</span>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php
		}
	}
}
?>
<input type="hidden" name="productAttribute[productId]" value="<?=$productId ?>" />
<div id="div_footer_form_update_price">
<?php
include "product_attribute_update_data.php";
?>
</div>
</div>
<script type="text/javascript">
	function selectAttr(element){
		element.parent("ul").find(".active").find("input:checkbox").removeAttr("checked", "");
		element.parent("ul").find(".active").removeClass("active");
		element.addClass("active");
		element.find("input:checkbox").attr("checked", "checked");
		element.find("input:checkbox").prop('checked', true);
		simpleAjaxPostUpload(
			guid(),
			'<?=ActionUtil::getFullPathAlias("admin/product/attribute/select")?>?rtype=json',
			"#product_attr",
			selectAttributeSuccess,
			selectAttributeFieldError,
			selectAttributeActionError
		);
	}

	function selectAttributeSuccess(res) {
		$("#div_footer_form_update_price").html(res.content);
	}
	function selectAttributeFieldError(res) {
		$("#div_footer_form_update_price").html(res.content);
	}
	function selectAttributeActionError(res) {
		$("#div_footer_form_update_price").html(res.content);
	}
</script>