<?php
use common\template\extend\Text;
use common\template\extend\Button;
use core\Lang;
use core\utils\ActionUtil;

?>
<a name="quickOrder"/>
<div id="account_container">
    <h2><?= Lang::get("Quick Order") ?></h2>
    <div class="row">
        <form>
            <div class="col-xs-10">
				<?php
				$text = new Text();
				$text->id = "product_name";
				$text->class = " ";
				$text->render();
				?>
            </div>
            <div class="col-xs-2">
				<?php
				$button = new Button();
				$button->title = "Search";
				$button->attributes = "type='button' onclick='searchProduct()'";
				$button->render();
				?>
            </div>
        </form>
    </div>
    <div id="product-results"></div>
    <h2><?= Lang::get("Cart Contents") ?></h2>
    <div>
		<?php include_once 'customer_order_cart_content_data.php'; ?>
    </div>
    <div class="cb"></div>
</div>
<script type="text/javascript">
	function searchProduct(){
		var data = "productName=" + $("#product_name").val();
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("customer/salesrep/quick/order/product/search?rtype=json")?>",
			data,
			onSearchProductSuccess,
			onSearchProductErrors,
			onSearchProductErrors
		);
	}
	function onSearchProductSuccess(res){
		$("#product-results").html(res.content);
	}
	function onSearchProductErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>