<input <?php
echo !empty ($type) ? "type=\"" . $type . "\"" : "";
echo " ";
echo !empty ($id) ? "id=\"" . $id . "\"" : "";
echo " ";
echo !empty ($name) ? "name=\"" . $name . "\"" : "";
echo " ";
echo ("0" == $value || !empty ($value)) ? " value=\"" . $value . "\"" : "";
echo " ";
echo !empty ($attributes) ? $attributes : "";
?>>
