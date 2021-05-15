<?php
use common\template\extend\Select;
use core\utils\AppUtil;
?>
<label class="control-label"><?=$label?><?=$required?"<span class='required' aria-required='true'> * </span>":""?>  </label>
<?php
$select = new Select ();
AppUtil::copyProperties ( $sourceElement, $select );
echo $prepend;
$select->render ();
echo $append;
?>
<span class="help-block"><?=$errorMessage?></span>
