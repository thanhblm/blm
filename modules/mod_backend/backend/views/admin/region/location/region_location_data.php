<?php
use common\template\extend\ButtonAction;
use common\template\extend\Link;
use common\template\extend\SelectInput;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$countryList = RequestUtil::get ( "countryList" );
$stateList = RequestUtil::get ( "stateList" );
$regionCountries = RequestUtil::get ( "regionCountries" )->getArray ();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-green-sharp bold uppercase">
			<i class="fa fa-map-marker font-green-sharp"></i><?=Lang::get("List Location")?>
		</div>
		<div class="actions">
			<?php
			$link = new Link ();
			$link->class = "btn btn-circle blue";
			$link->link = "javascript:addRegionCountry(\"0\");";
			$link->title = "<i class=\"fa fa-plus white\"></i> " . Lang::get ( "Add new" );
			$link->id = "iAddRegionCountry";
			$link->render ();
			$link = new Link ();
			$link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
			$link->render ();
			?>
		</div>
	</div>
	<div class="portlet-body" id="page_result_tax">
		<div class="table-scrollable">
			<table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable " id="page_table_tax">
				<thead class="flip-content">
					<tr role="row">
						<th><?=Lang::get('Country');?></th>
						<th><?=Lang::get('State');?></th>
						<th><?=Lang::get('Actions');?></th>
					</tr>
				</thead>
				<tbody id="tbody_list_region_country">
				<?php
				if (count ( $regionCountries ) == 0) {
					?>
					<tr role="row" id="tr_no_data">
						<td colspan="3"><?= Lang::get("No data available...") ?></td>
					</tr>
                <?php
				} else {
					$index = 0;
					foreach ( $regionCountries as $regionCountry ) {
						?>
					<tr class="gradeX odd indexRegionCountry" role="row">
						<td>
						<?php
						$select = new SelectInput ( 'select_input_single' );
						$select->id = 'regionCountry_countryId';
						$select->errorMessage = RequestUtil::getFieldError ( "regionCountries[" . $index . "][countryId]" );
						$select->hasError = RequestUtil::isFieldError ( "regionCountries[" . $index . "][countryId]" );
						$select->class = "form-control input-sm countryClass";
						$select->required = true;
						$select->name = "regionCountries[" . $index . "][countryId]";
						$select->value = $regionCountry->countryId;
						$select->collections = $countryList;
						$select->headerKey = "";
						$select->headerValue = "-Select-";
						$select->propertyName = "id";
						$select->propertyValue = "name";
						$select->attributes = "onChange=\"getState(this);\"";
						$select->render ();
						?>
						</td>
						<td>
						<?php
						$select = new SelectInput ( 'select_input_single' );
						$select->name = "regionCountries[$index][stateId]";
						$select->class = "form-control input-sm";
						$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
						$select->collections = $stateList [$regionCountry->countryId];
						$select->headerKey = "";
						$select->headerValue = "-Select-";
						$select->propertyName = "id";
						$select->propertyValue = "name";
						$select->value = $regionCountry->stateId;
						$select->render ();
						?>
						</td>
						<td>
						<?php
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-trash-o";
						$actionBtn->color = ButtonAction::COLOR_RED;
						$actionBtn->attributes = "onclick='deleteRegionCountry($(this), " . $index . ")'";
						$actionBtn->title = Lang::get ( "Delete" );
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
<script type="text/javascript">
uuid = guid();
gUrlRegionCountry = "<?=ActionUtil::getFullPathAlias("admin/region/country/add") ?>" + "?rtype=json";
$(document).ready(function(){
	var countRegionCountry = $("tr.indexRegionCountry").length;
	$("a#iAddRegionCountry").attr("href", "javascript:addRegionCountry('"+countRegionCountry+"')");
});

function addRegionCountry(index){
    simpleAjaxPost(
	    uuid, 
	    gUrlRegionCountry+"&indexRegionCountry="+index, 
	    "", 
	    addSuccessRegionCountry, 
	    null
	    );
}
function addSuccessRegionCountry(res){
    $("#tr_no_data").remove();
    $("#tbody_list_region_country").append(res.content);
    var countRegionCountry = $("tr.indexRegionCountry").length;
    $("a#iAddRegionCountry").attr("href", "javascript:addRegionCountry('"+countRegionCountry+"')");
}
function deleteRegionCountry(element,indexTr){
    var countRegionCountry = $("tr.indexRegionCountry").length;
    $("a#iAddRegionCountry").attr("href", "javascript:addRegionCountry('"+(countRegionCountry-1)+"')");
	var trParent = element.parent().parent();
	trParent.nextAll().each(function(index) {
	    var inputs =  $(this).find(' input,select');
	    $(this).find("a").attr("id", "aButtonDel"+(indexTr+index));
	    $(this).find("a").attr("onclick", 'deleteRegionCountry($(this), '+(indexTr+index)+')');
	    $.each(inputs, function(obj, v) {
			var id = $(v).attr("id");
			$(v).attr("id", id.replace("regionCountries_"+(indexTr+index+1), "regionCountries_"+(indexTr+index)));
			var name = $(v).attr("name");
			$(v).attr("name", name.replace("regionCountries["+(indexTr+index+1)+"]", "regionCountries["+(indexTr+index)+"]"));
		});
	});
	trParent.remove();
}
function getState(obj){
	var start = obj.name.indexOf("[")+1;
	var end = obj.name.indexOf("]");
	var index = obj.name.slice(start,end);
	App.blockUI({
        target: '#id_region_state'
    })
	var data = "";
	data += "&countryId=" + obj.value;
	$.post("<?=ActionUtil::getFullPathAlias("admin/region/state/add/get?rtype=json")?>", data, function(res) {
		App.unblockUI('#id_region_state');
		if (res.errorCode == "SUCCESS") {
			$("select[name='regionCountries["+index+"][stateId]']").html(res.content);
		} else {
			alert(res.errorMessage);
		}
	}).fail(function() {
		App.unblockUI('#id_region_state');
		alert("System error.");
	});
}
</script>