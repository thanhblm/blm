<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include "discount_coupon_edit_form_data.php" ?>
	</div>
</div>
<script type="text/javascript">
	function editDiscountCoupon(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/discount/coupon/edit?rtype=json")?>",
			$("#discount_coupon_edit_form").serialize(),
			onEditDiscountCouponSuccess,
            onEditDiscountCouponFieldErrors,
            onEditDiscountCouponActionErrors
		);
	}
	function onEditDiscountCouponSuccess(res){
        $("#discount_coupon_edit_form").replaceWith(res.content);
	}
	function onEditDiscountCouponFieldErrors(res){
        $("#discount_coupon_edit_form").replaceWith(res.content);
    }
    function onEditDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
	function onEditAndCloseDiscountCouponSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/discount/coupon/list')?>" ;
    }
    function onEditAndCloseDiscountCouponFieldErrors(res){
        $("#discount_coupon_edit_form").replaceWith(res.content);
    }
    function onEditAndCloseDiscountCouponActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function editAndCloseDiscountCoupon(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/edit?rtype=json")?>",
            $("#discount_coupon_edit_form").serialize(),
            onEditAndCloseDiscountCouponSuccess,
            onEditAndCloseDiscountCouponFieldErrors,
            onEditAndCloseDiscountCouponActionErrors
        );
    }
</script>