<?php
use core\template\html\base\BaseSelect;
use core\Lang;
use core\utils\AppUtil;

?>
<select <?php
echo ! empty ( $id ) ? "id='$id'" : "";
echo " ";
echo ! empty ( $name ) ? "name='$name'" : "";
echo " ";
echo ! empty ( $attributes ) ? $attributes : "";
echo " ";
?>>
<?php
if (! is_null ( $headerValue ) && ! is_null ( $headerKey )) {
	?>
	<option value="<?=$headerKey?>" <?=$headerKey===$value?"selected":""?>><?=$headerValue?></option>
<?php
}
if (is_array ( $collections ) && ! empty ( $collections )) {
	switch ($collectionType) {
		case BaseSelect::CT_SINGLE_ARRAY_OBJECT :
			foreach ( $collections as $obj ) {
				if ($i18n){
					echo "<option value='" . $obj->$propertyName . "' " . ((!AppUtil::isEmptyString($value) && $value == $obj->$propertyName) ? "selected" : "") . " >" . Lang::get($obj->$propertyValue) . "</option>";
				}else{
					echo "<option value='" . $obj->$propertyName . "' " . ((!AppUtil::isEmptyString($value) && $value == $obj->$propertyName) ? "selected" : "") . " >" . $obj->$propertyValue . "</option>";
				}
			}
			break;
		case BaseSelect::CT_MULTI_ARRAY_VALUE :
			foreach ( $collections as $k => $v ) {
				if ($i18n){
					echo "<option value='" . $k . "' " . (($value == $k) ? "selected" : "") . " >" . Lang::get($v) . "</option>";
				}else{
					echo "<option value='" . $k . "' " . (($value == $k) ? "selected" : "") . " >" . $v . "</option>";
				}
			}
			break;
		case BaseSelect::CT_SINGLE_ARRAY_VALUE :
			foreach ( $collections as $k ) {
				if ($i18n){
					echo "<option value='" . $k . "' " . (($value == $k) ? "selected" : "") . " >" . Lang::get($k) . "</option>";
				}else{
					echo "<option value='" . $k . "' " . (($value == $k) ? "selected" : "") . " >" . $k . "</option>";
				}
			}
		default :
			break;
			throw new \Exception ( "No support collection type" );
	}
}
?>
</select>
<?php
// echo var_dump(array_keys($collections))
?>