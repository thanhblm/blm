<?php
echo "<form ";
echo ! empty ( $id ) ? "id='$id'" : "";
echo ! empty ( $ufid ) ? "ufid='$ufid'" : "";
echo ! empty ( $method ) ? "method='$method'" : "";
echo ! empty ( $enctype ) ? "enctype='$enctype'" : "";
echo ! empty ( $action ) ? "action='$action'" : "";
echo ! empty ( $attributes ) ? $attributes : "";
echo ">";