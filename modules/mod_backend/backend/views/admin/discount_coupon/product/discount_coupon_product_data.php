<?php
use common\template\extend\ButtonAction;
use common\template\extend\Link;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

// $applicableList = RequestUtil::get ( "applicableList" )->getArray ();
$productList = RequestUtil::get ( "productList" );
$categoryList = RequestUtil::get ( "categoryList" );
$applicableProducts = RequestUtil::get ( "applicableProducts" )->getArray ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-green-sharp bold uppercase">
			<i class="fa fa-list font-green-sharp"></i><?= Lang::get("Applicable Products/Categories")?>
        </div>
		<div class="actions">
			<?php
			$link = new Link ();
			$link->class = "btn btn-circle blue";
			$link->link = "javascript:addDiscountCouponProduct(\"0\",\"product\");";
			$link->title = "<i class=\"fa fa-plus white\"></i> " . Lang::get ( "Add Product" );
			$link->id = "iAddDiscountCouponProduct";
			$link->render ();
			
			$link = new Link ();
			$link->class = "btn btn-circle blue";
			$link->link = "javascript:addDiscountCouponProduct(\"0\",\"category\");";
			$link->title = "<i class=\"fa fa-plus white\"></i> " . Lang::get ( "Add Category" );
			$link->id = "iAddDiscountCouponCategory";
			$link->render ();
			$link = new Link ();
			$link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
			$link->render ();
			?>
        </div>
	</div>
	<div class="portlet-body" id="page_result_tax">
		<div class="table-scrollable">
			<table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable " id="page_table_tax">
				<thead class="flip-content">
					<tr role="row">
						<th><?= Lang::get('Products/Categories'); ?></th>
						<th><?= Lang::get('Type'); ?></th>
						<th><?= Lang::get('Actions'); ?></th>
					</tr>
				</thead>
				<tbody id="tbody_list_discount_coupon_product">
				<?php
				if (count ( $applicableProducts ) == 0) {
					// include 'region_shipping_method_success_data.php';
				} else {
					$index = 0;
					foreach ( $applicableProducts as $proItem ) {
						?>
					<tr class="gradeX odd indexDiscountCouponProduct">
						<td>
							<?php
							$select = new SelectInput ( 'select_input_single' );
							$select->errorMessage = RequestUtil::getFieldError ( "applicableProducts[" . $index . "][itemId]" );
							$select->hasError = RequestUtil::isFieldError ( "applicableProducts[" . $index . "][itemId]" );
							$select->class = "form-control input-sm";
							$select->required = true;
							$select->name = "applicableProducts[" . $index . "][itemId]";
							$select->value = $proItem->itemId;
							if ($proItem->itemType == 'category') {
								$select->collections = $categoryList;
								$select->propertyName = "id";
								$select->propertyValue = "name";
							} else {
								$select->collections = $productList;
								$select->propertyName = "id";
								$select->propertyValue = "name";
							}
							$select->render ();
							?>
						</td>
						<td>
							<?php
							$text = new TextInput ();
							$text->name = "applicableProducts[" . $index . "][itemType]";
							$text->type = "hidden";
							$text->value = $proItem->itemType;
							$text->render ();
							echo $proItem->itemType;
							?>
						</td>
						<td>
							<?php
							$actionBtn = new ButtonAction ();
							$actionBtn->iconClass = "fa fa-trash-o";
							$actionBtn->color = ButtonAction::COLOR_RED;
							$actionBtn->attributes = "onclick='deleteDiscountCouponProduct($(this), " . $index . ")'";
							$actionBtn->title = Lang::get ( "Delete" );
							$actionBtn->render ();
							?>
						</td>
					</tr>
					<?php
						$index ++;
					}
				}
				?>
                </tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
    uuid = guid();
    gUrlDiscountCouponProduct = "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/product/add") ?>" + "?rtype=json";
    $(document).ready(function () {
        var countDiscountCouponProduct = $("tr.indexDiscountCouponProduct").length;
        $("a#iAddDiscountCouponProduct").attr("href", "javascript:addDiscountCouponProduct('" + countDiscountCouponProduct + "','product')");
        $("a#iAddDiscountCouponCategory").attr("href", "javascript:addDiscountCouponProduct('" + countDiscountCouponProduct + "','category')");

    });

    function addDiscountCouponProduct(index,type) {
    	gUrl= gUrlDiscountCouponProduct + "&indexDiscountCouponProduct=" + index+"&type=" + type,
        simpleAjaxPost(
            uuid,
            gUrl,
            "",
            addSuccessDiscountCouponProduct,
            null
        );
    }
    function addSuccessDiscountCouponProduct(res) {
        //$("#tr_no_data").remove();
        $("#tbody_list_discount_coupon_product").append(res.content);
        var countDiscountCouponProduct = $("tr.indexDiscountCouponProduct").length;
        $("a#iAddDiscountCouponProduct").attr("href", "javascript:addDiscountCouponProduct('" + countDiscountCouponProduct + "','product')");
         $("a#iAddDiscountCouponCategory").attr("href", "javascript:addDiscountCouponProduct('" + countDiscountCouponProduct + "','category')");
    }
    function deleteDiscountCouponProduct(element, indexTr) {
        var countDiscountCouponProduct = $("tr.indexDiscountCouponProduct").length;
        $("a#iAddDiscountCouponProduct").attr("href", "javascript:addDiscountCouponProduct('" + (countDiscountCouponProduct - 1) + "','product')");
         $("a#iAddDiscountCouponCategory").attr("href", "javascript:addDiscountCouponProduct('" + (countDiscountCouponProduct - 1) + "','category')");
        var trParent = element.parent().parent();
        trParent.nextAll().each(function (index) {
            var inputs = $(this).find(' input,select');
            $(this).find("a").attr("onclick", 'deleteDiscountCouponProduct($(this), ' + (indexTr + index) + ')');
            $.each(inputs, function (obj, v) {
                var id = $(v).attr("id");
                $(v).attr("id", id.replace("applicableProducts_" + (indexTr + index + 1), "applicableProducts_" + (indexTr + index)));
                var name = $(v).attr("name");
                $(v).attr("name", name.replace("applicableProducts[" + (indexTr + index + 1) + "]", "applicableProducts[" + (indexTr + index) + "]"));
            });
        });
        trParent.remove();
    }
</script>