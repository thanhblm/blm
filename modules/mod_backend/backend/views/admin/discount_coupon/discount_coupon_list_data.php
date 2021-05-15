<?php
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;
use common\template\extend\Button;

$paging = RequestUtil::get ( "discountCoupons" );
$discountCoupons = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="discount_coupon_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Code');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Discount value (%)');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td></td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[code]";
					$text->value = $filter->code;
					$text->placeholder = Lang::get ( "Code" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->placeholder = Lang::get ( "Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[discountFrom]";
					$text->value = $filter->discountFrom;
					$text->placeholder = Lang::get ( "From" );
					// $text->render ();
					
					$text = new Text ();
					$text->name = "filter[discountTo]";
					$text->value = $filter->discountTo;
					$text->placeholder = Lang::get ( "To" );
					// $text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->value = $filter->status;
					$select->name = "filter[status]";
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = ApplicationConfig::get ( "common.status.list" );
					$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
					// $select->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchDiscountCoupons()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchDiscountCoupons(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $discountCoupons ) || count ( $discountCoupons ) == 0) {
				?>
			<tr role="row">
				<td colspan="8"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $discountCoupons as $discountCoupon ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$discountCoupon->id?></td>
				<td><?=$discountCoupon->code?></td>
				<td><?=$discountCoupon->name?></td>
				<td><?=$discountCoupon->discount?></td>
				<td><?=$discountCoupon->status?></td>

				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "onEditDiscountCoupon('$discountCoupon->id')";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/discount/coupon/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "onCopyDiscountCoupon('$discountCoupon->id')";
					$actionBtn->title = Lang::get ( "Copy" );
					$actionBtn->checkActionPath = "admin/discount/coupon/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteDiscountCouponDialog('$discountCoupon->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/discount/coupon/del/view";
					$actionBtn->render ();
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
$pagingTemplate->changePageJs = "changePageDiscountCoupons";
$pagingTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
 			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
		});
	});
</script>