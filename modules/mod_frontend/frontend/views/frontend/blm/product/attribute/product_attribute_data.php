<?php

use common\helper\DatoImageHelper;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$attrExtGroupVos = RequestUtil::get("attrExtGroupVos");
$productId = RequestUtil::get("productId");
if (is_null($productId)) {
	$productId = RequestUtil::get("product")->id;
}
?>
<div id="product_attr">
	<?php
	if (count($attrExtGroupVos) > 0) {
		foreach ($attrExtGroupVos as $key => $attrGroup) {
			if (isset($attrGroup->listAttr) && count($attrGroup->listAttr->getArray()) > 0) {
				?>
				<div class="attr-item">
					<div class=" col-md-3"><?= Lang::get($attrGroup->name . ":") ?>
						<input type="hidden" name="attrGroupListId[]" value="<?= $attrGroup->id ?>"/>
					</div>
					<div class="list-attr col-md-9">
						<ul style="padding: 0;">
							<?php
							foreach ($attrGroup->listAttr->getArray() as $object) {
								if ($object->type === "image") {
									$imageMo = DatoImageHelper::getImageInfoById($object->image);
									?>
									<li class="attr-image" onclick="javascript:selectAttr($(this))">
                                    <span>
                                        <input type='checkbox' style="display: none;" name="attributeSelect[]" value='<?= $object->id ?>' id="<?= $object->id ?>"/>
                                        <img alt="image" title="<?= $object->description ?>" for="thing"
                                             src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>"
                                             width="40px">
                                    </span>
									</li>
									<?php
								} elseif ($object->type === "code") {
									?>
									<li onclick="javascript:selectAttr($(this))">
									<span title="<?= $object->name ?>" style="background-color: <?= $object->description?>">
										<input style="display: none;" type='checkbox' name="attributeSelect[]" value='<?= $object->id ?>' id="<?= $object->id ?>"/>
										&nbsp;&nbsp;&nbsp;&nbsp;
									</span>
									</li>
									<?php
								} else {
									?>
									<li onclick="javascript:selectAttr($(this))">
									<span title="<?= $object->description ?>">
										<input style="display: none;" type='checkbox' name="attributeSelect[]" value='<?= $object->id ?>' id="<?= $object->id ?>"/>
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
	<input type="hidden" name="productAttribute[productId]" value="<?= $productId ?>"/>
	<div id="div_footer_form_update_price">
		<?php
		include "product_attribute_update_data.php";
		?>
	</div>
</div>
<script type="text/javascript">
    function selectAttr(element) {
        element.parent("ul").find(".active").find("input:checkbox").removeAttr("checked", "");
        element.parent("ul").find(".active").removeClass("active");
        element.addClass("active");
        element.find("input:checkbox").attr("checked", "checked");
        element.find("input:checkbox").prop('checked', true);
        simpleAjaxPostUpload(
            guid(),
            '<?=ActionUtil::getFullPathAlias("home/product/attribute/select")?>?rtype=json',
            "#product_attr",
            selectAttributeSuccess,
            selectAttributeFieldError,
            selectAttributeActionError
        );

        if (element.hasClass("attr-image")) {
            var url = element.find("img").attr("src");
            url = url.replace("/small/", "/");
            var string = "<div class='item active' <a class='item_image' rel='group' href='" + url + "'><img src='" + url + "' alt='' width='314' height='375'></a></div>"
            $(".carousel-inner").find(".active").removeClass("active");
            $(".carousel-inner").append(string);

            var li_last = $(".carousel-indicators li").last();
            var data_slide_to = parseInt(li_last.attr("data-slide-to"));

            if (li_last.attr('data-is-attr') == 'true') {
                data_slide_to = data_slide_to - 1;
                li_last.remove();
            }
            data_slide_to++;
            var sub_string = "<li data-is-attr='true' data-target='#product'data-slide-to='" + data_slide_to + "' class='active'><span class='icon slider-bullet'></span></li>"
            $(".carousel-indicators").find(".active").removeClass("active");
            $(".carousel-indicators").append(sub_string);
        }
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