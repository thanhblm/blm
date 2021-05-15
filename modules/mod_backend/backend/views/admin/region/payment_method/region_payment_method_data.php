<?php
use common\template\extend\ButtonAction;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use common\template\extend\ModalTemplate;
use core\utils\ActionUtil;
use common\template\extend\Select;

$regionPaymentMethods = RequestUtil::get ( "regionPaymentMethods" )->getArray ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-green-sharp bold uppercase">
			<i class="fa fa-list font-green-sharp"></i><?= Lang::get("List Payment Method")?>
        </div>
	</div>
	<div class="portlet-body" id="page_result_tax">
		<div class="table-scrollable">
			<table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable " id="page_table_tax">
				<thead class="flip-content">
					<tr role="row">
						<th><?= Lang::get('Id'); ?></th>
						<th><?= Lang::get('Name'); ?></th>
						<th><?= Lang::get('Status'); ?></th>
						<!--  
						<th><?= Lang::get('Actions'); ?></th>
						-->
					</tr>
				</thead>
				<tbody id="tbody_list_region_payment_method">
				<?php
				if (empty ( $regionPaymentMethods )) {
					?>
					<tr role="row" id="tr_no_data">
						<td colspan="3"><?= Lang::get("No data available...") ?></td>
					</tr>
				<?php
				} else {
					$index = 0;
					foreach ( $regionPaymentMethods as $regionPaymentMethod ) {
						?>
                 	<tr class="gradeX odd indexRegionPaymentMethod" role="row">
						<td><?=$regionPaymentMethod->paymentMethodId?></td>
						<td><?=$regionPaymentMethod->paymentMethodName?></td>
						<td id="col_region_payment_method_status_<?=$regionPaymentMethod->paymentMethodId?>">
						<?php
							$select = new Select();
							$select->label = Lang::get ( "Status" );
							$select->name = "regionPaymentMethods[" . $index . "][status]";
							$select->errorMessage = RequestUtil::getFieldError ( "regionPaymentMethods[" . $index . "][status]" );
							$select->hasError = RequestUtil::isFieldError ( "regionPaymentMethods[" . $index . "][status]" );
							$select->required = true;
							$select->collections = ApplicationConfig::get ( "common.status.list" );
							$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
							$select->value = $regionPaymentMethod->status;
							$select->render ();
						?>
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][id]" value="<?=$regionPaymentMethod->id?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][paymentMethodId]" value="<?=$regionPaymentMethod->paymentMethodId?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][paymentMethodName]" value="<?=$regionPaymentMethod->paymentMethodName?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][regionId]" value="<?=$regionPaymentMethod->regionId?>" />
						</td>
						<!--  
						<td id="col_region_payment_method_status_<?=$regionPaymentMethod->paymentMethodId?>"><?=AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ),$regionPaymentMethod->status)?></td>
						<td>
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][id]" value="<?=$regionPaymentMethod->id?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][paymentMethodId]" value="<?=$regionPaymentMethod->paymentMethodId?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][paymentMethodName]" value="<?=$regionPaymentMethod->paymentMethodName?>" /> 
							<input type="hidden" name="regionPaymentMethods[<?=$index?>][regionId]" value="<?=$regionPaymentMethod->regionId?>" /> 
							<input id="region_payment_method_status_<?=$regionPaymentMethod->paymentMethodId?>" type="hidden" name="regionPaymentMethods[<?=$index?>][status]" value="<?=$regionPaymentMethod->status?>" /> 
							<input id="region_payment_method_info_<?=$regionPaymentMethod->paymentMethodId?>" type="hidden" name="regionPaymentMethods[<?=$index?>][settingInfo]" value="<?=$regionPaymentMethod->settingInfo?>" />
							<?php
							$actionBtn = new ButtonAction();
							$actionBtn->iconClass = "fa fa-cog";
							$actionBtn->color = ButtonAction::COLOR_BLUE;
							$actionBtn->attributes = "onclick='configPaymentMethod(" . $regionPaymentMethod->paymentMethodId . ")'";
							$actionBtn->title = Lang::get ( "Config" );
							$actionBtn->render ();
							?>
						</td>
						-->
					</tr>
				<?php
						$index += 1;
					}
				}
				?>
                </tbody>
			</table>
		</div>
	</div>
</div>
<?php
$modalTemplate = new ModalTemplate();
$modalTemplate->size = 900;
$modalTemplate->id = "edit_payment_method_setting_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	function configPaymentMethod(paymentMethodId){
	    var setting = $("input#region_payment_method_info_" + paymentMethodId).val();
	    setting = encodeURIComponent(setting);
	    var gUrl = "";
	    var pUrl = "";
	    switch (paymentMethodId) {
	    case 1:
	        // Is Bank Transfer.
	        gUrl = "<?=ActionUtil::getFullPathAlias("admin/bank/transfer/setting/edit/view?rtype=json&setting=")?>" + setting;
	        pUrl = "<?=ActionUtil::getFullPathAlias("admin/bank/transfer/setting/edit?rtype=json")?>";
	        break;
	    default:
		    showMessage("No support this payment method","error");
	        return false;
	    }
		simpleCUDModal(
			"#edit_payment_method_setting_dialog",
			"#edit_payment_method_setting_form",
			guid(),
			"#btnEditPaymentMethodSetting",
			gUrl,
			pUrl,
			function (dialogId,btn,res){
				console.log(res.extra.statusId);
				console.log(res.extra.statusName);
				$(dialogId).modal("toggle");
				$("input#region_payment_method_info_" + paymentMethodId).val(res.extra.setting);
				$("td#col_region_payment_method_status_" + paymentMethodId).html(res.extra.statusName);
				$("input#region_payment_method_status_" + paymentMethodId).val(res.extra.statusId);
			}
		);
	}
</script>