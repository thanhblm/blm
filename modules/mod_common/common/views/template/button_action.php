<a <?=isset($id) && !empty($id) ? "id='".$id."'" : ""?> class="btn btn-circle btn-icon-only btn-outline <?=$color?> tooltips" data-placement="top" title="<?=$title?>" data-original-title="<?=$title?>" <?=$attributes?>
href="<?=isset($url) && !empty($url) ? $url : "javascript:$js"?>"><i class="<?=$iconClass?>"></i></a>