<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$batchGroupMo = RequestUtil::get ( "batchGroupMo" );
$form = new FormContainer ();
$form->id = "batchGroupAddFormId";
$form->attributes = 'class="form-horizontal" enctype="multipart/form-data" method="post"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "batchGroupMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "batchGroupMo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "batchGroupMo[name]";
	$text->value = $batchGroupMo->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->attributes = ' multiple="" onChange="makeFileList();" accept="application/pdf"';
	$text->type = "file";
	$text->id = "fileUpload";
	$text->errorMessage = RequestUtil::getFieldError ( "fileUpload" );
	$text->hasError = RequestUtil::isFieldError ( "fileUpload" );
	$text->label = Lang::get ( "Files" );
	$text->name = "fileUpload";
	$text->render ();
	?>
	<p>
		<strong><?=Lang::get("Selected files")?>:</strong>
	</p>
	<ul id="fileList" style="list-style: none;">
		<li><?=Lang::get("No selected files")?> </li>
	</ul>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	var input = document.getElementById("fileUpload");
	var ul = document.getElementById("fileList");
	var http_arr = new Array();
	function makeFileList() {
		while (ul.hasChildNodes()) {
			ul.removeChild(ul.firstChild);
		}
		for (var i = 0; i < input.files.length; i++) {
			var li = document.createElement("li");
			li.setAttribute("id", "file_upload_"+i);
			li.innerHTML = input.files[i].name + 
			' <i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
			ul.appendChild(li);
		}
		if(!ul.hasChildNodes()) {
			var li = document.createElement("li");
			li.innerHTML = 'No Files Selected';
			ul.appendChild(li);
		}
	}

	function removeLine(obj)
    {
	    var jqObj = $(obj);
	    var container = jqObj.closest('li');
	    var index = container.attr("id").split('_')[2];
	    container.remove(); 
	    delete input.files[index];
	    input.files.length = input.files.length - 1;
    }
</script>