<?php

use core\utils\AppUtil;
use core\template\html\base\BaseTextArea;

?>
<div class="col-md-12 form-group <?= $required ? "required": ""?>  <?php echo $hasError ? 'has-error' : '' ?>">
    <?php
    if (!empty ($label)) {
	    ?>
        <div class="_label"><?= $label ?></div>
	    <?php
    }
    ?>
            <?php
            $appendAttribute = !empty ($class) ? "class='$class'" : "class = 'form-control'";
            $appendAttribute .= " " . (!empty ($placeholder) ? "placeholder='$placeholder'" : "");
            $textarea = new BaseTextArea();
            AppUtil::copyProperties($sourceElement, $textarea);
            $textarea->attributes .= " " . $appendAttribute;
            $textarea->render();
            ?>
</div>