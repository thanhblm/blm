<?php
use common\template\extend\FormContainer;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;

$userGroupMo = RequestUtil::get("userGroupMo");
$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError("userGroupMo[name]");
	$text->hasError = RequestUtil::isFieldError("userGroupMo[name]");
	$text->label = Lang::get("Name");
	$text->name = "userGroupMo[name]";
	$text->required = true;
	$text->value = $userGroupMo->name;
	$text->render();

	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError("userGroupMo[description]");
	$text->hasError = RequestUtil::isFieldError("userGroupMo[description]");
	$text->label = Lang::get("Description");
	$text->name = "userGroupMo[description]";
	$text->value = $userGroupMo->description;
	$text->class = "form-control";
	$text->render();

	$select = new SelectInput ();
	$select->class = "form-control form-filter input-sm";
	$select->errorMessage = RequestUtil::getFieldError("userGroupMo[status]");
	$select->hasError = RequestUtil::isFieldError("userGroupMo[status]");
	$select->label = Lang::get("Status");
	$select->name = "userGroupMo[status]";
	$select->value = $userGroupMo->status;
	$select->collectionType = 1;
	$select->collections = ApplicationConfig::get("common.status.list");
	$select->render();

	$text = new Text ();
	$text->type = "hidden";
	$text->value = $userGroupMo->id;
	$text->name = "userGroupMo[id]";
	$text->render();

	?>
    <p><?= Lang::get("List of permission") ?></p>
    <div class="well" style="max-height: 300px; overflow: auto">
		<?php
		$permissions = RequestUtil::get('permissionMos')->getArray();
		$index = 0;
		foreach (ApplicationConfig::get("admin.memu.list") as $sortName){
			echo "<b>$sortName</b>";
			foreach ($permissions as $permission) {
				if (AppUtil::startsWith($permission->permissionName,$sortName)){
					$text = new Text ();
					$text->name = "permissionMos[" . $index . "][permissionName]";
					$text->value = $permission->permissionName;
					$text->type = "hidden";
					$text->render();
		
					$text = new Text ();
					$text->name = "permissionMos[" . $index . "][permissionActionCode]";
					$text->value = $permission->permissionActionCode;
					$text->type = "hidden";
					$text->render();
					$collection = ApplicationConfig::get("permission.type.list");
					if (!is_null(ApplicationConfig::get("permission.custom.type.list")) && isset(ApplicationConfig::get("permission.custom.type.list")[$permission->permissionName])){
						$collection = ApplicationConfig::get("permission.custom.type.list")[$permission->permissionName];
					}

					$select = new SelectInput ();
					$select->collections = $collection;
					$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
					$select->label = str_replace($sortName."|", "", $permission->permissionName);
					$select->class = "form-control input-sm";
					$select->name = "permissionMos[" . $index . "][permissionType]";
					$select->value = $permission->permissionType;
					$select->render();
					$index++;
				}
			}
		}
		?>
    </div>
    <span class="help-block"><?= RequestUtil::getFieldError("permissions") ?></span>
</div>
<?php $form->renderEnd(); ?>

<script type="text/javascript">
    function checkPermission(checked, selectElement) {
        if (checked) {
            selectElement.attr("disabled", false);
        } else {
            selectElement.attr("disabled", true);
        }
    }
</script>
