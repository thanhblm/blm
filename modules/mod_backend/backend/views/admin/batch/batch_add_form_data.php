<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
$listBatchGroup = RequestUtil::get('listBatchGroup');
$batchMo = RequestUtil::get ( "batchMo" );
$form = new FormContainer ();
$form->id = "batchAddFormId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
<?php
	
	$text = new TextInput ();
	$text->attributes = ' multiple="" onChange="makeFileList();" accept="application/pdf"';
	$text->type = "file";
	$text->id = "fileUpload";
	$text->errorMessage = RequestUtil::getFieldError ( "fileUpload" );
	$text->hasError = RequestUtil::isFieldError ( "fileUpload" );
	$text->label = Lang::get ( "Files" );
	$text->required = true;
	$text->name = "fileUpload";
	$text->render ();
	
?>
<div id="div_batch_group">
 <?php include 'batch_add_batch_group_form_data.php';?>
</div>
	<p>
		<strong><?=Lang::get("Files You Selected:") ?></strong>
	</p>
	<ul id="fileList" style="list-style: none;">
		<li><?=Lang::get("No Files Selected") ?></li>
	</ul>
</div>
<?php $form->renderEnd ();?>
<script type="text/javascript">
<?php
	if (count ( $listBatchGroup ) < 1) {
		?>
		function addBatchGroupSuccess(res){
		    showMessage("<?=Lang::get("Add Batch Group success") ?>");
		    $("#div_batch_group").html(res.content);
		}
		function addBatchGroupError(res){
		    $("#div_batch_group").html(res.content);
		}
	
		function addBatchGroup(){
		    data = $("#batchAddFormId").serialize();
		    simpleAjaxPost(
			    	guid(), 
			    	"<?=ActionUtil::getFullPathAlias("admin/batch/group/quick/add") ?>" + "?rtype=json", 
				    data, 
				    addBatchGroupSuccess,
				    addBatchGroupError,
				    addBatchGroupError
			    );
		}
	<?php
	}
	?>
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
			li.innerHTML = ' ' + input.files[i].name + 
			' <i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
			ul.appendChild(li);
			//uploadFile(input.files[i]);
			
		}
		if(!ul.hasChildNodes()) {
			var li = document.createElement("li");
			li.innerHTML = "<?=Lang::get("No Files Selected") ?>";
			ul.appendChild(li);
		}
	}

	function removeLine(obj)
    {
      var jqObj = $(obj);
      var container = jqObj.closest('li');
      var index = container.attr("id").split('_')[1];
      container.remove(); 
      delete input.files[index];
      input.files.length = input.files.length - 1
    }
</script>