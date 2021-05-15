<?php
use common\template\extend\Text;
use core\utils\AppUtil;

?>

<label class="control-label"><?php echo $label;
    if ($required):?>
        <span class="required" aria-required="true"> * </span>
    <?php endif; ?>
</label> <br/>
<?php

$text = new Text();
AppUtil::copyProperties($sourceElement, $text);
$text->class = empty($class) ? "form-control input-sm" : $class;
$text->attributes = ' aria-required="true" aria-describedby="name-error" aria-invalid="false" data-required="1"';
if ($readonly) {
    $text->attributes = $text->attributes . " readonly ";
}
echo $prepend;
$text->render();
echo $append;
?>
<span class="help-block"><?= $errorMessage ?></span>
