<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include "discount_coupon_add_form_data.php" ?>
	</div>
</div>
<script type="text/javascript">
	function addDiscountCoupon(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/discount/coupon/add?rtype=json")?>",
			$("#discount_coupon_add_form").serialize(),
			onAddDiscountCouponSuccess,
            onAddDiscountCouponFieldErrors,
            onAddDiscountCouponActionErrors
		);
	}
	function onAddDiscountCouponSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/discount/coupon/edit/view')?>" + "?id=" + res.extra.discountCouponId;
	}
	function onAddDiscountCouponFieldErrors(res){
        $("#discount_coupon_add_form").replaceWith(res.content);
    }
    function onAddDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
	function onAddAndCloseDiscountCouponSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/discount/coupon/list')?>" ;
    }
    function onAddAndCloseDiscountCouponFieldErrors(res){
        $("#discount_coupon_add_form").replaceWith(res.content);
    }
    function onAddAndCloseDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function addAndCloseDiscountCoupon(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/add?rtype=json")?>",
            $("#discount_coupon_add_form").serialize(),
            onAddAndCloseDiscountCouponSuccess,
            onAddAndCloseDiscountCouponFieldErrors,
            onAddAndCloseDiscountCouponActionErrors
        );
    }
</script>