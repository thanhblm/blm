<?php
use common\template\extend\ButtonAction;
use common\template\extend\ModalTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\AppUtil;
use core\config\ApplicationConfig;

$regionShippingMethods = RequestUtil::get ( "regionShippingMethods" )->getArray ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-green-sharp bold uppercase">
			<i class="fa fa-list font-green-sharp"></i><?= Lang::get("List Shipping Method")?>
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
						<th><?= Lang::get('Actions'); ?></th>
					</tr>
				</thead>
				<tbody id="tbody_list_region_shipping_method">
				<?php
				if (count ( $regionShippingMethods ) == 0) {
					?>
					<tr role="row" id="tr_no_data">
						<td colspan="5"><?= Lang::get("No data available...") ?></td>
					</tr>
				<?php
				} else {
					$index = 0;
					foreach ( $regionShippingMethods as $regionShippingMethod ) {
						?>
             		<tr class="gradeX odd indexRegionShippingMethod" role="row">
						<td><?=$regionShippingMethod->shippingMethodId?></td>
						<td><?=$regionShippingMethod->shippingMethodName?></td>
						<td id="col_region_shipping_method_status_<?=$regionShippingMethod->shippingMethodId?>"><?=AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ),$regionShippingMethod->status)?></td>
						<td><input type="hidden" name="regionShippingMethods[<?=$index?>][id]" value="<?=$regionShippingMethod->id?>" /> <input type="hidden" name="regionShippingMethods[<?=$index?>][shippingMethodId]" value="<?=$regionShippingMethod->shippingMethodId?>" /> <input type="hidden" name="regionShippingMethods[<?=$index?>][shippingMethodName]" value="<?=$regionShippingMethod->shippingMethodName?>" /> <input type="hidden" name="regionShippingMethods[<?=$index?>][regionId]" value="<?=$regionShippingMethod->regionId?>" /> <input id="region_shipping_method_status_<?=$regionShippingMethod->shippingMethodId?>" type="hidden" name="regionShippingMethods[<?=$index?>][status]" value="<?=$regionShippingMethod->status?>" /> <input id="region_shipping_method_info_<?=$regionShippingMethod->shippingMethodId?>" type="hidden" name="regionShippingMethods[<?=$index?>][settingInfo]" value="<?=$regionShippingMethod->settingInfo?>" />
						<?php
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-cog";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						$actionBtn->attributes = "onclick='configShippingMethod(" . $regionShippingMethod->shippingMethodId . ")'";
						$actionBtn->title = Lang::get ( "Config" );
						$actionBtn->render ();
						?>
                    	</td>
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
$modalTemplate = new ModalTemplate ();
$modalTemplate->size = 900;
$modalTemplate->id = "edit_shipping_method_setting_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
    function configShippingMethod(shippingMethodId){
        var setting = $("input#region_shipping_method_info_" + shippingMethodId).val();
        setting = encodeURIComponent(setting);
        var gUrl = "";
        var pUrl = "";
        switch (shippingMethodId) {
        case 1:
            // Is Zone Table.
            gUrl = "<?=ActionUtil::getFullPathAlias("admin/zone/table/setting/edit/view?rtype=json&setting=")?>" + setting;
            pUrl = "<?=ActionUtil::getFullPathAlias("admin/zone/table/setting/edit?rtype=json")?>";
            break;
        case 2:
            // Is Flat Rate.
            gUrl = "<?=ActionUtil::getFullPathAlias("admin/flat/rate/setting/edit/view?rtype=json&setting=")?>" + setting;
            pUrl = "<?=ActionUtil::getFullPathAlias("admin/flat/rate/setting/edit?rtype=json")?>";
            break;
        default:
        	showMessage("No support this shipping method","error");
            return false;
        }
    	simpleCUDModal(
    		"#edit_shipping_method_setting_dialog",
    		"#edit_shipping_method_setting_form",
    		guid(),
    		"#btnEditShippingMethodSetting",
    		gUrl,
    		pUrl,
    		function (dialogId,btn,res){
    			$(dialogId).modal("toggle");
    			$("input#region_shipping_method_info_" + shippingMethodId).val(res.extra.setting);
    			$("td#col_region_shipping_method_status_" + shippingMethodId).html(res.extra.statusName);
    			$("input#region_shipping_method_status_" + shippingMethodId).val(res.extra.statusId);
    		}
    	);
    }
</script>