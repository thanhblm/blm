<?php

use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$attrExtGroupVos = RequestUtil::get("attrExtGroupVos");
$productId = RequestUtil::get("productId");
if (is_null($productId)) {
	$productId = RequestUtil::get("product")->id;
}
?>
<?php
if (count($attrExtGroupVos) > 0) {
	foreach ($attrExtGroupVos as $key => $attrGroup) {
		if (isset($attrGroup->listAttr) && count($attrGroup->listAttr->getArray()) > 0) {
			?>
			<div class="margin_bottom_30">
				<select class="menu-font">
					<option class="uppercase"><?= Lang::getWithFormat("Please select a {0}", $attrGroup->name) ?></option>
					<?php
					foreach ($attrGroup->listAttr->getArray() as $object) {
						?>
						<option class="capital" value="<?= $object->id ?>"><?= $object->name ?></option>
						<?php
					}
					?>
				</select>
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