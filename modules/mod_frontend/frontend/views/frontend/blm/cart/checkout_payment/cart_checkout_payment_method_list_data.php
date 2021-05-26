<?php
use common\config\PaymentMethodEnum;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\SessionUtil;

$paymentMethods = RequestUtil::get ( "paymentMethods" );
$order = SessionUtil::get ( "order" );
?>
<h2
	<?php if (strlen(RequestUtil::getFieldError("order[paymentMethod]")) > 0) { ?>
	style="color: red;" <?php } ?>><?= Lang::get("Payment Method") ?></h2>
<p style="color: #81ad00"><?=Lang::get("Payment will take some time to process. Please refrain from clicking the button again or refreshing the page meanwhile.") ?></p>
<div class="box col-xs-12 payment_box">
	<div>
		<ul style="list-style-type: none;">
			<?php
			foreach ( $paymentMethods as $paymentMethod ) {
				$checked = " ";
				$paymentMethodId = "";
				if (! is_null ( $order ) && ! is_null ( $order->paymentMethod)) {
					$paymentMethodId = $order->paymentMethod;
				}
				if ($paymentMethodId == $paymentMethod->id) {
					$checked = " checked ";
				}
				
				?>
                <li>
                	<?php
				switch ($paymentMethod->id) {
					case PaymentMethodEnum::BANK_TRANSTER :
						include 'methods/bank_transfer/bank_transfer_data.php';
						break;
					case PaymentMethodEnum::AUTHORIZE_NET :
						include 'methods/authorize_net/authorize_net_data.php';
						break;
					case PaymentMethodEnum::CARDGATE :
						include 'methods/cardgate/cardgate_data.php';
						break;
					case PaymentMethodEnum::EPAY :
						include 'methods/epay/epay_data.php';
						break;
					case PaymentMethodEnum::NETWORK_MERCHANTS :
						include 'methods/network_merchants/network_merchants_data.php';
						break;
					default :
						break;
				}
				?>
                </li>
				<?php
			}
			?>
        </ul>
	</div>

</div>