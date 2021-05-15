<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\App;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\DateTimeUtil;
use core\config\ApplicationConfig;

$paging = RequestUtil::get("orders");
$orders = $paging->records;
$filter = RequestUtil::get("filter");
$paymentMethodList = RequestUtil::get("paymentMethodList");
$orderStatusList = RequestUtil::get("orderStatusList");
$shippingStatusList = RequestUtil::get("shippingStatusList");
$countryList = RequestUtil::get("countryList");
$priceLevelList = RequestUtil::get("priceLevelList");

?>
<div class="table-scrollable">
    <input id="page" name="page" type="hidden" value="<?= RequestUtil::get("page") ?>"/>
    <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="order_table">
        <thead>
        <tr role="row">
            <th><?= Lang::get('Id'); ?></th>
            <th><?= Lang::get('Customer'); ?></th>
            <th><?= Lang::get('Date'); ?></th>
            <th><?= Lang::get('Status'); ?></th>
            <th><?= Lang::get('Country'); ?></th>
            <th><?= Lang::get('Shipping'); ?></th>
            <th><?= Lang::get('Discount'); ?></th>
            <th><?= Lang::get('Comments'); ?></th>
            <th><?= Lang::get('Payment'); ?></th>
            <th><?= Lang::get('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr role="row" class="filter">
            <td>
				<?php
				$text = new Text ();
				$text->name = "filter[id]";
				$text->value = $filter->id;
				$text->placeholder = Lang::get("Id");
				$text->attributes = "style='width: 80px'";
				$text->render();

				$text = new Text ();
				$text->name = "filter[megaId]";
				$text->value = $filter->megaId;
				$text->placeholder = Lang::get("Mega Id");
				$text->attributes = "style='width: 80px'";
				$text->render();
				?>
            </td>
            <td>
				<?php
				$text = new Text ();
				$text->name = "filter[customerFirstname]";
				$text->value = $filter->customerFirstname;
				$text->placeholder = Lang::get("First name");
				$text->render();

				$text = new Text ();
				$text->name = "filter[customerLastname]";
				$text->value = $filter->customerLastname;
				$text->placeholder = Lang::get("Last name");
				$text->render();

				$text = new Text ();
				$text->name = "filter[customerEmail]";
				$text->value = $filter->customerEmail;
				$text->placeholder = Lang::get("Customer email");
				$text->render();
				?>
            </td>
            <td>
				<?php
				$text = new Text ("text_date");
				$text->name = "filter[dateFrom]";
				$text->value = $filter->dateFrom;
				$text->placeholder = Lang::get("From");
				$text->attributes = "style='width: 80px'";
				$text->render();
				$text = new Text ("text_date");
				$text->name = "filter[dateTo]";
				$text->value = $filter->dateTo;
				$text->placeholder = Lang::get("To");
				$text->attributes = "style='width: 80px'";
				$text->render();
				?>
            </td>
            <td>
				<?php
				$select = new Select ();
				$select->collections = $orderStatusList;
				$select->value = $filter->orderStatusId;
				$select->name = "filter[orderStatusId]";
				$select->propertyName = 'id';
				$select->propertyValue = 'name';
				$select->headerKey = '';
				$select->class = "form-control input-sm";
				$select->headerValue = Lang::get('Order');
				$select->attributes = "style=\"width: 90px\"";
				$select->render();

				$select = new Select ();
				$select->collections = $shippingStatusList;
				$select->value = $filter->shippingStatusId;
				$select->name = "filter[shippingStatusId]";
				$select->propertyName = 'id';
				$select->propertyValue = 'name';
				$select->class = "form-control input-sm";
				$select->headerKey = '';
				$select->headerValue = Lang::get('Shipping');
				$select->attributes = "style=\"width: 90px\"";
				$select->render();
				?>
            </td>
            <td>
				<?php
				$select = new Select ();
				$select->collections = $countryList;
				$select->value = $filter->billCountryCode;
				$select->name = "filter[billCountryCode]";
				$select->propertyName = 'iso2';
				$select->propertyValue = 'name';
				$select->attributes = "style='width: 100px'";
				$select->class = "form-control input-sm";
				$select->headerKey = '';
				$select->headerValue = Lang::get('Billing');
				$select->render();

				$select = new Select ();
				$select->collections = $countryList;
				$select->value = $filter->shipCountryCode;
				$select->name = "filter[shipCountryCode]";
				$select->propertyName = 'iso2';
				$select->propertyValue = 'name';
				$select->attributes = "style='width: 100px'";
				$select->class = "form-control input-sm";
				$select->headerKey = '';
				$select->headerValue = Lang::get('Shipping');
				$select->render();
				?>
            </td>
            <td>
				<?php
				$select = new Select ();
				$select->collections = ApplicationConfig::get("is.usa.list");
				$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
				$select->value = $filter->isUSA;
				$select->name = "filter[isUSA]";
				//$select->propertyName = 'id';
				//$select->propertyValue = 'name';
				$select->attributes = "style='width: 100px' onchange=\"changeUSAFilter(this)\"";		
				$select->headerKey = '';
				$select->headerValue = Lang::get('Shipped by');
				$select->render();
				?>
				
				<div id="usaFilter" <?php if( $filter->isUSA==1) echo "style=\"display:none\"" ?> >
				<?= Lang::get('ERDT'); ?>
				 <input <?php if( $filter->isUSA==1) echo "disabled" ?> type="checkbox" name="filter[erdt]" <?php if($filter->erdt){echo "checked";}?>>
				 </div>

            </td>
            <td>
				<?php
				$text = new Text ();
				$text->name = "filter[couponCode]";
				$text->value = $filter->couponCode;
				$text->placeholder = Lang::get("Coupon code");
				$text->attributes = "style='width: 100px'";
				$text->render();

				$text = new Text ();
				$text->name = "filter[priceLevel]";
				$text->value = $filter->priceLevel;
				$text->placeholder = Lang::get("Price level");
				$text->attributes = "style='width: 100px'";
				$text->render();
				
				?>
            </td>
            <td>
				<?php
				$text = new Text ();
				$text->name = "filter[adminComment]";
				$text->value = $filter->adminComment;
				$text->placeholder = Lang::get("Admin's comment");
				$text->render();

				$text = new Text ();
				$text->name = "filter[customerComment]";
				$text->value = $filter->customerComment;
				$text->placeholder = Lang::get("Customer's comment");
				$text->render();

				$text = new Text ();
				$text->name = "filter[invoiceComment]";
				$text->value = $filter->invoiceComment;
				$text->placeholder = Lang::get("Invoice's comment");
				$text->render();
				?>
            </td>
            <td>
				<?php
				$text = new Text ();
				$text->name = "filter[paymentMethod]";
				$text->value = $filter->paymentMethod;
				$text->placeholder = Lang::get("Payment method");
				$text->attributes = "style='width: 100px'";
				$text->render();
				
				$text = new Text ();
				$text->name = "filter[grandTotalFrom]";
				$text->value = $filter->grandTotalFrom;
				$text->placeholder = Lang::get("From");
				$text->attributes = "style='width: 100px'";
				$text->render();

				$text = new Text ();
				$text->name = "filter[grandTotalTo]";
				$text->value = $filter->grandTotalTo;
				$text->placeholder = Lang::get("To");
				$text->attributes = "style='width: 100px'";
				$text->render();
				?>
            </td>
            <td>
				<?php
				$button = new Button ();
				$button->type = "button";
				$button->title = " " . Lang::get("Search");
				$button->icon = "<i class='fa fa-search'></i>";
				$button->attributes = "onclick=\"searchOrders()\"";
				$button->render();
				$button = new Button ();
				$button->type = "button";
				$button->title = " " . Lang::get("Reset");
				$button->icon = "<i class='fa fa-refresh'></i>";
				$button->attributes = "onclick=\"searchOrders(true)\"";
				$button->render();
				?>
            </td>

        </tr>
		<?php
		if (empty ($orders) || count($orders) == 0) {
			?>
            <tr role="row">
                <td colspan="8"><?= Lang::get("No data available...") ?></td>
            </tr>
			<?php
		} else {
			foreach ($orders as $order) {
				?>
                <tr class="gradeX odd" role="row">
                    <td>#<?= $order->id ?>
						<?= !empty($order->megaId) ? "<br/><strong class='text-uppercase'>" . Lang::get("Mega ID:") . " $order->megaId</strong>" : "" ?></td>
                    <td><strong><?= Lang::get("Name:") ?></strong><br/>
						<?= $order->customerFirstname . ' ' . $order->customerLastname ?><br/><br/>
                        <strong><?= Lang::get("Email:") ?></strong><br/>
						<?=$order->customerEmail; ?>
                    </td>
                    <td><?= $order->date ?></td>
                    <td>
                        <strong><?= Lang::get("Order:") ?></strong>
						<?php
						$select = new Select ();
						$select->collections = $orderStatusList;
						$select->value = $order->orderStatusId;
						$select->propertyName = 'id';
						$select->propertyValue = 'name';
						$select->attributes = "onchange=\"changeOrderStatus(this,$order->id)\"";
						$select->class = "form-control input-sm";
						$select->render();
						?>
                        <br/>
                        <strong><?= Lang::get("Shipping:") ?></strong>
						<?php
						$select = new Select ();
						$select->collections = $shippingStatusList;
						$select->value = $order->shippingStatusId;
						$select->propertyName = 'id';
						$select->propertyValue = 'name';
						$select->attributes = "onchange=\"changeShippingStatus(this,$order->id)\"";
						$select->class = "form-control input-sm";
						$select->render();
						?>
                    </td>
                    <td>
                        <strong><?= Lang::get("Billing:") ?></strong><br/>
						<?= $order->billCountry ?>
                        <br/><br/>
                        <strong><?= Lang::get("Shipping:") ?></strong><br/>
						<?= $order->shipCountry ?>
                    </td>
                    <td>
						<?php
						if ($order->shipCountryCode == 'US') {
							echo 'USA';
						} else {
							echo 'Outside USA';
						}
						?>
                        <br/><?php
						if ($order->shipCountryCode != 'US') {// 2 is id of shipping status 'ordered';
							if (is_null($order->shipBy)){
					?>
								<strong><?= Lang::get("ERDT:") ?></strong>
	                            <input type="checkbox" onclick="checkERDT(this,<?= $order->id ?>);">
					<?php 
							}else{
								if ($order->shipBy === 'erdt'){
									?>
									<strong><?= ($order->shipBy != 'erdt')?$order->shipBy:Lang::get("ERDT:") ?></strong>
									<input type="checkbox" checked onclick="unCheckERDT(this,<?= $order->id ?>);" <?=AppUtil::isEmptyString($order->shipDate)?"":"disabled"?>>
									<?php 
								}else{
									?>
										<strong><?=Lang::get($order->shipBy) ?></strong>
									<?php
								}
							}
						}
						?>	
	
                    </td>
                    <td>
						<?= !AppUtil::isEmptyString($order->couponCode) ? "<strong>" . Lang::get("Coupon Code:") . "</strong><br/>$order->couponCode<br><br>" : "" ?>
						<?= !AppUtil::isEmptyString($order->priceLevel) ? "<strong>" . Lang::get("Price Level:") . "</strong><br/>$order->priceLevel" : "" ?></td>
                    <td>
                        <?= !AppUtil::isEmptyString($order->adminComment) ? "<strong>".Lang::get("Admin:")."</strong><br/> $order->adminComment<br><br>" : "" ?>
                        <?= !AppUtil::isEmptyString($order->customerComment) ? "<strong>".Lang::get("Customer:")."</strong><br/> $order->customerComment <br><br>" : "" ?>
                        <?= !AppUtil::isEmptyString($order->invoiceComment) ? "<strong>".Lang::get("Invoice:")."</strong><br/> $order->invoiceComment" : "" ?>
                    </td>
                    <td><?= !AppUtil::isEmptyString($order->paymentMethod) ? "<strong>" . Lang::get("Method:") . "</strong><br/>$order->paymentMethod" : "" ?>
                        <br/><br/>
                        <strong><?= Lang::get("Total:") ?></strong><br/>
						<?= $order->currencyCode." " . $order->grandTotalAmount; ?>
						<?php 
						if ($order->refundAmount != 0){
						?>
						<span style='color:red;font-weight: bold;'>(<?= $order->refundAmount;?>)</span>
						<?php 	
						}
						?>
						</td>
                    <td>
						<?php
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-search";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						$actionBtn->url = ActionUtil::getFullPathAlias("admin/order/detail/view?id=" . $order->id);
						$actionBtn->title = Lang::get("Detail");
						$actionBtn->checkActionPath = "admin/order/detail/view";
						$actionBtn->render();

						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-trash-o";
						$actionBtn->color = ButtonAction::COLOR_RED;
						$actionBtn->js = "deleteOrderDialog('$order->id')";
						$actionBtn->title = Lang::get("Delete");
						$actionBtn->checkActionPath = "admin/order/del/view";
						$actionBtn->render();

						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-file";
						$actionBtn->color = ButtonAction::COLOR_YELLOW;
						$actionBtn->url = ActionUtil::getFullPathAlias("admin/order/pdf?id=" . $order->id);
						$actionBtn->title = Lang::get("View pdf");
						$actionBtn->attributes="target=\"_blank\"";
						$actionBtn->checkActionPath = "admin/order/pdf";
						$actionBtn->render();
						?>
                    </td>
                </tr>
				<?php
			}
		}
		?>
        </tbody>
    </table>
</div>
<?php
$pagingTemplate = new PagingTemplate ();
$pagingTemplate->paging = $paging;
$pagingTemplate->changePageJs = "changePageOrders";
$pagingTemplate->render();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
			format: "<?=DateTimeUtil::getDatePickerFormat()?>",
		});
	});
</script>
