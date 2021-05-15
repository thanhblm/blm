<form <?php 
echo ! empty ( $id ) ? "id='$id'" : "";
echo " ";
echo ! empty ( $ufid ) ? "ufid='$ufid'" : "";
echo " ";
echo ! empty ( $method ) ? "method='$method'" : "";
echo " ";
echo ! empty ( $enctype ) ? "enctype='$enctype'" : "";
echo " ";
echo ! empty ( $attributes ) ? $attributes : "";
	?> >
	<?php
		foreach ($elements as $element) {
			$element->render();
		}
	 ?>
</form>