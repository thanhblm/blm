<?php
use common\template\extend\FormContainer;
use common\template\extend\Link;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\ButtonAction;

$shippingMethodSetting = RequestUtil::get("regionShippingMethodSetting");

$form = new FormContainer ();
$form->id = "edit_shipping_method_setting_form";
$form->renderStart();
?>
    <div class="form-body">
		<?php
		$select = new SelectInput("select_input_fluid");
		$select->label = Lang::get("Status");
		$select->name = "regionShippingMethodSetting[status]";
		$select->errorMessage = RequestUtil::getFieldError("regionShippingMethodSetting[status]");
		$select->hasError = RequestUtil::isFieldError("regionShippingMethodSetting[status]");
		$select->required = true;
		$select->collections = ApplicationConfig::get("common.status.list");
		$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
		$select->value = $shippingMethodSetting->status;
		$select->render();
		?>
        <span class="title"><?= Lang::get("Offer Flat Rate shipping?") ?></span>
		<?php
		$select = new SelectInput("select_input_fluid");
		$select->label = Lang::get("Currency");
		$select->name = "regionShippingMethodSetting[currency]";
		$select->errorMessage = RequestUtil::getFieldError("regionShippingMethodSetting[currency]");
		$select->hasError = RequestUtil::isFieldError("regionShippingMethodSetting[currency]");
		$select->required = true;
		$select->collections = RequestUtil::get("currencies");
		$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
		$select->propertyName = "code";
		$select->propertyValue = "name";
		$select->value = $shippingMethodSetting->currency;
		$select->render();
		?>
        <span class="title"><?= Lang::get("The shipping cost must be entered in this currency") ?></span>
        <div class="row">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption green-sharp">
                        <i class="fa fa-truck"></i> <?= Lang::get("Shipping methods") ?>
                    </div>
                    <div class="actions">
						<?php
						$link = new Link();
						$link->class = "btn btn-circle blue";
						$link->title = "<i class=\"fa fa-plus white\"></i> " . Lang::get("Add shipping method");
						$link->attributes = "onclick=\"addShippingMethodRow()\"";
						$link->render();

						$link = new Link();
						$link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
						$link->render();
						?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable" style="max-height: 300px; overflow: auto">
                        <div id="scroll-div">
                            <table id="shipping_method_table" class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable">
                                <tr>
                                    <th>#</th>
                                    <th><?= Lang::get("Method") ?></th>
                                    <th><?= Lang::get("Cost") ?></th>
                                    <th><?= Lang::get("COD Only") ?></th>
                                    <th><?= Lang::get("Cash") ?></th>
                                    <th><?= Lang::get("Actions") ?></th>
                                </tr>
								<?php
								if (empty ($shippingMethodSetting->shippingMethods->getArray())) {
									?>
                                    <tr>
                                        <td data-no-data="no data" colspan="6"><?= Lang::get("No data available...") ?></td>
                                    </tr>
									<?php
								} else {
									$index = 0;
									foreach ($shippingMethodSetting->shippingMethods->getArray() as $shippingMethod) {
										$idTextName = "regionShippingMethodSetting[shippingMethods][" . $index . "][id]";
										$methodTextName = "regionShippingMethodSetting[shippingMethods][" . $index . "][name]";
										$costTextName = "regionShippingMethodSetting[shippingMethods][" . $index . "][cost]";
										$codOnlyTextName = "regionShippingMethodSetting[shippingMethods][" . $index . "][codOnly]";
										$cashTextName = "regionShippingMethodSetting[shippingMethods][" . $index . "][cash]";
										?>
                                        <tr>
                                            <td><?= ($index + 1) ?><input name="<?= $idTextName ?>" type="hidden" value="<?= ($index + 1) ?>"/></td>
                                            <td>
                                                <input name="<?= $methodTextName ?>" type="text" value="<?= $shippingMethod->name ?>"/>
                                            </td>
                                            <td>
                                                <input name="<?= $costTextName ?>" type="number" value="<?= $shippingMethod->cost ?>"/>
                                            </td>
                                            <td>
                                                <input name="<?= $codOnlyTextName ?>" type="checkbox" <?php echo $shippingMethod->codOnly ? "checked='checked'" : '' ?> value="<?= $shippingMethod->codOnly ?>"/>
                                            </td>
                                            <td>
                                                <input name="<?= $cashTextName ?>" type="checkbox" <?php echo $shippingMethod->cash ? "checked='checked'" : '' ?> value="<?= $shippingMethod->cash ?>"/>
                                            </td>
                                            <td>
	                                            <?php
												$actionBtn = new ButtonAction();
												$actionBtn->iconClass = "fa fa-remove";
												$actionBtn->color = ButtonAction::COLOR_RED;
												$actionBtn->attributes = "onclick='removeShippingMethodRow(" . $index . ")'";
												$actionBtn->title = Lang::get ( "Delete" );
												$actionBtn->render ();
												?>
                                            </td>
                                        </tr>
										<?php
										$index++;
									}
								}
								?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
		$text = new TextInput("text_input_fluid");
		$text->label = Lang::get("Handling Fee");
		$text->type = "number";
		$text->name = "regionShippingMethodSetting[handlingFee]";
		$text->errorMessage = RequestUtil::getFieldError("regionShippingMethodSetting[handlingFee]]");
		$text->hasError = RequestUtil::isFieldError("regionShippingMethodSetting[handlingFee]");
		$text->required = false;
		$text->value = $shippingMethodSetting->handlingFee;
		$text->render();
		?>
        <span class="title"><?= Lang::get("Additional handling fee to charge") ?></span>
		<?php
		$select = new SelectInput("select_input_fluid");
		$select->label = Lang::get("Shipping Zone");
		$select->name = "regionShippingMethodSetting[shippingZone]";
		$select->errorMessage = RequestUtil::getFieldError("regionShippingMethodSetting[shippingZone]");
		$select->hasError = RequestUtil::isFieldError("regionShippingMethodSetting[shippingZone]");
		$select->required = false;
		$select->headerKey = "";
		$select->headerValue = "Select One";
		$select->collections = RequestUtil::get("shippingZones");
		$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
		$select->propertyName = "id";
		$select->propertyValue = "name";
		$select->value = $shippingMethodSetting->shippingZone;
		$select->render();
		?>
        <span class="title"><?= Lang::get("If a zone is selected, only enable this shipping method for that zone") ?></span>
    </div>
<?php $form->renderEnd(); ?>