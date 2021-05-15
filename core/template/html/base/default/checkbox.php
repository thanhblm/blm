<input type="checkbox"
	<?php
	echo !empty ($id) ? "id='$id'" : "";
	echo " ";
	echo !empty ($name) ? "name='$name'" : "";
	echo " ";
	echo !empty ($value) ? "value='$value'" : "";
	echo " ";
	echo !empty ($attributes) ? $attributes : "";
	echo " ";
	?>
>