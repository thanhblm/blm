<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include "discount_coupon_copy_form_data.php" ?>
	</div>
</div>
<script type="text/javascript">
	function copyDiscountCoupon(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/discount/coupon/copy?rtype=json")?>",
			$("#discount_coupon_copy_form").serialize(),
			onCopyDiscountCouponSuccess,
            onCopyDiscountCouponFieldErrors,
            onCopyDiscountCouponActionErrors
		);
	}
	function onCopyDiscountCouponSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/discount/coupon/edit/view')?>" + "?id=" + res.extra.discountCouponId;
	}
	function onCopyDiscountCouponFieldErrors(res){
        $("#discount_coupon_copy_form").replaceWith(res.content);
    }
    function onCopyDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
	function onCopyAndCloseDiscountCouponSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/discount/coupon/list')?>" ;
    }
    function onCopyAndCloseDiscountCouponFieldErrors(res){
        $("#discount_coupon_copy_form").replaceWith(res.content);
    }
    function onCopyAndCloseDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function copyAndCloseDiscountCoupon(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/copy?rtype=json")?>",
            $("#discount_coupon_copy_form").serialize(),
            onCopyAndCloseDiscountCouponSuccess,
            onCopyAndCloseDiscountCouponFieldErrors,
            onCopyAndCloseDiscountCouponActionErrors
        );
    }
</script>