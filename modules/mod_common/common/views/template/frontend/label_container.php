<div class="dataTables_length">
	<label>
		<?php
		echo $textBefore. " ";
		foreach ( $elements as $element ) {
			$element->render ();
		}
		echo $textAfter?>
	</label>
</div>
