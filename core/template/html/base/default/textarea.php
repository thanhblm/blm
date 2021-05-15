<textarea
	<?php
	echo !empty ($id) ? "id='$id'" : "";
	echo " ";
	echo !empty ($name) ? "name='$name'" : "";
	echo " ";
	echo !empty ($attributes) ? $attributes : "";
	echo " ";
	echo !empty ($value) ? "value='$value'" : "";
	?>
>
<?php echo ("0" == $value || !empty ($value)) ? "$value" : ""; ?>
</textarea>
