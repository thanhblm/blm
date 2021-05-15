<button
	<?php
	echo !empty ($type) ? "type='$type'" : "";
	echo " ";
	echo !empty ($id) ? "id='$id'" : "";
	echo " ";
	echo !empty ($name) ? "name='$name'" : "";
	echo " ";
	echo !empty ($attributes) ? $attributes : "";
	?>
> <?php echo $title ?></button>

