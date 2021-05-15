<?php
use common\helper\SettingHelper;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use common\config\PaymentMethodEnum;
use core\Lang;

$order = RequestUtil::get("order");
$orderStatus = RequestUtil::get("orderStatus");
\DatoLogUtil::trace($order);
$orderId = $order->id;
$customerId = RequestUtil::get("customerId");
//if (! empty ( $orderStatus )) {
//	$statusStr = ' ,status:' . $orderStatus;
//} else {
//	$statusStr = "";
//}
// echo '<pre>';
// var_dump($order);
// echo '</pre>';
?>
<div class="container-fluid">
    <div class="row">
        <div class="box col-xs-12 photo" style="background-image: url('<?= AppUtil::resource_url("layouts/endoca/img/order-confirm-bg.png") ?>')">
            <div style="color: #fff">
				<span class="wrap">
				
					<?php 
					if($customerId == 0){
					?>
					<h2><?= Lang::get(' Your order was placed successfully (Order Id') ?>
                        = <?php echo $orderId ?><?= $statusStr ?>). <?= Lang::get('You can download your invoice ') ?>
                        <a
                                href="<?= ActionUtil::getFullPathAlias("customer/order/pdf") ?>?orderId=<?=$orderId ?>"><?= Lang::get('here') ?></a>,
						<?= Lang::get('thank you') ?>!
					</h2>
					<?php 
					}else{
					?>
				
					<h2><?= Lang::get(' Your order was placed successfully (Order Id') ?>
                        = <?php echo $orderId ?><?= $statusStr ?>). <?= Lang::get('You can view your order history') ?>
                        <a
                                href="<?= ActionUtil::getFullPathAlias("customer/order/list") ?>"><?= Lang::get('here') ?></a>,
						<?= Lang::get('thank you') ?>!
					</h2>
					<?php 
					}
					?>
				</span>
				<?php if ($order->paymentMethod == PaymentMethodEnum::BANK_TRANSTER) { ?>
                    <h2><?= Lang::get('Please make a payment within 2 days of your purchase
					and include your order number in the purpose field. Your order
					will be processed after we receive your payment.') ?></h2>
                    <h3>
						<?= SettingHelper::getSettingValue("Bank transfer info") ?>
                    </h3>
				<?php } ?>
                <h3>
					<span class="wrap"><span style="font-weight: 400;"><?= Lang::get('If you have any
							questions regarding your order, please contact us') ?>:</span>&nbsp;</span>
                </h3>
                <h3>
					<span class="wrap"><span
                                style="font-weight: bold; text-decoration: underline;"><?= Lang::get('USA') ?></span></span>
                </h3>
                <h3>
					<span class="wrap"><span style="font-weight: 400;"><?= Lang::get('Phone') ?>:&nbsp;<a
                                    href="https://www.endoca.com/tel:+1-619-831-0156">1-619-831-0156</a></span></span><br>
                    <span class="wrap"><span style="font-weight: 400;"><?= Lang::get('Email') ?>: <a
                                    href="/mailto:infousa@endoca.com">infousa@endoca.com</a></span></span>
                </h3>
                <h3>
					<span class="wrap"><span
                                style="font-weight: bold; text-decoration: underline;"><?= Lang::get('Outside USA') ?></span></span>
                </h3>
                <h3>
					<span class="wrap"><span style="font-weight: 400;"><?= Lang::get('Phone') ?>:&nbsp;<a
                                    href="https://www.endoca.com/tel:+45-898-707-00">45-898-707-00</a></span></span><br>
                    <span class="wrap"><span style="font-weight: 400;"><?= Lang::get('Email') ?>: </span><span
                                style="font-weight: 400;"><a href="/mailto:info@endoca.com">info@endoca.com</a></span></span>
                </h3>
            </div>
        </div>
        <div class="light">
            <div>
                <article class="box col-xs-8  text ">
                    <div>
                        <h2>
							<span class="wrap"><?= Lang::get('BUY THE BEST CBD OIL AT ENDOCA - PURE HEMP
								EXTRACT - 100% ORGANIC') ?></span>
                        </h2>
                        <p><?= Lang::get('BUY THE BEST CBD OIL AT ENDOCA - PURE HEMP EXTRACT - 100% ORGANIC') ?></p>
                        <h1>
                            <a class="button" href="/en/products"><?= Lang::get('Visit our store') ?></a>
                        </h1>
                        <p>&nbsp;</p>
                    </div>
                </article>
                <article class="box col-xs-4  text ">
                    <div>
                        <p style="text-align: right; min-height: 150px;">&nbsp;</p>
                        <p style="text-align: right; min-height: 150px;">
                            <img style="position: absolute; right: 20px; bottom: 0;"
                                 src="/uploads/layout/-cbd-hemp-oil-canada-from-endoca-com.png"
                                 alt="" width="404" height="237">
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>