<?php


$staticStr = !isset($isStatic) || $isStatic == true ? "data-backdrop='static' data-keyboard='true'" : "";
?>
<div class="modal draggable-modal modal-overflow" <?php echo ! empty ( $id ) ? "id='$id'" : ""; ?> role="basic" aria-hidden="true" style="display: none;" <?=isset($size) && !empty($size)? "data-width='$size'" : ""?> <?=$staticStr?>></div>