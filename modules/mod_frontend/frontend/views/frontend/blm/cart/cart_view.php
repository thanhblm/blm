<?php
use core\Lang;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").attr("class", "_shopping-cart __simplepage");
    });
</script>
<div class="container" id="main">
    <div class="light">
        <div>
            <div class="box col-xs-12"><h1><?= Lang::get("Cart") ?></h1>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="headline tabs">
                            <div class="col-sm-3 active">
                                <a href="Cart"><?= Lang::get("1. Cart") ?></a>
                            </div>
                            <div class="col-sm-3">
                                <a href="Order"><?= Lang::get("2. Order") ?></a>
                            </div>
                            <div class="col-sm-3">
                                <span><?= Lang::get("3. Payment") ?></span>
                            </div>
                            <div class="col-sm-3">
                                <span><?= Lang::get("4. Complete") ?></span>
                            </div>
                            <div class="clear" style="padding:0px!important;"></div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="shopping-cart cart_block">
                            <form name="cart" action="/en/shopping-cart?action=update" method="post" class="purlForm">
                                <div class="cart-products-reload">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th></th>
                                            <th><?= Lang::get("Product") ?></th>
                                            <th class="center"><?= Lang::get("Price") ?></th>
                                            <th style="width:75px;" class="center"><?= Lang::get("Amount") ?></th>
                                            <th class="center"><?= Lang::get("Sum") ?></th>
                                            <th class="center"><?= Lang::get("Subscription") ?></th>
                                            <th class="center"><?= Lang::get("Remove") ?></th>
                                        </tr>
                                        <tr>
                                            <td class="image">
                                                <a href="/en/p68-buy-cbd-oil-drops-3-percent-cbd-hemp-oil-drops-300mg-cbd-drops?uid=68">
                                                    <img src="/images/0063-105x140/cbd-oil-10g-hemp-oil-drops-300mg-cbd-from-endoca-com.png" alt="" width="105" height="140">
                                                </a>
                                            </td>
                                            <td class="name">
                                                <a href="/en/p68-buy-cbd-oil-drops-3-percent-cbd-hemp-oil-drops-300mg-cbd-drops?uid=68">
                                                   <?= Lang::get("Hemp Oil Drops 300mg CBD (Cannabidiol) (3%)")?> 
                                                </a>
                                            </td>
                                            <td class="price">
                                                <div>€26.00</div>
                                            </td>
                                            <td class="quantity">
                                                <div class="amount">
                                                    <span class="frm_field frm_number"><input type="number" name="qty[68]" value="1"></span>
                                                    <div class="plus arrow">+</div>
                                                    <div class="minus arrow">-</div>
                                                </div>
                                            </td>
                                            <td class="price">
                                                <div>€26.00</div>
                                            </td>
                                            <td class="as_shipping_column">
                                                <div class="as_no_shipping"><?= Lang::get("No") ?></div>
                                            </td>
                                            <td>
                                                <a href="javascript:productRemove(68)" class="cart_remove"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="break"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <form name="coupon" action="/en/shopping-cart?action=coupon" method="post" class="purlForm">
                                <div class="discount col-sm-4"><h4><?= Lang::get("Cart") ?><?= Lang::get("Do you have a discount code? Enter it here.") ?></h4>
                                    <span class="frm_field frm_text"><input type="text" name="coupon_code" value="" placeholder="<?= Lang::get("Discount code...") ?>" required=""></span>
                                    <button type="submit"><span><?= Lang::get("Submit") ?></span></button>
                                    <div id="coupon_list_container">
                                        <table class="coupons2 cpb1"></table>
                                    </div>
                                </div>
                            </form>
                            <div class="suma col-sm-6">
                                <div id="order_price_summary"><span><?= Lang::get("Subtotal") ?></span>
                                    <div class="price" id="cart_total_price">€26.00</div>
                                    <span><?= Lang::get("Grand Total") ?></span>
                                    <div class="price sum" id="cart_total_price2">€26.00</div>
                                    <a href="/en/checkout" class="button continue"><span><?= Lang::get("Proceed to Checkout") ?></span></a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>