<a
	<?php
	echo "href='$link'";
	echo " ";
	echo ! empty ( $id ) ? "id='$id'" : "";
	echo " ";
	echo ! empty ( $attributes ) ? $attributes : "";
	?>>
	<?php echo ! empty ( $title ) ? $title : ""; ?>
	</a>
