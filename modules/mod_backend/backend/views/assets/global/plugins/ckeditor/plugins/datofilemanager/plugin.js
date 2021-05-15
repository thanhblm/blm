(function(){
	var o = {
		exec: function(p){
			var currentInstance = null;
			for (var ck_instance in CKEDITOR.instances) {
				if (CKEDITOR.instances[ck_instance].focusManager.hasFocus) {
					currentInstance = ck_instance;
					break;
				}
			}
			var url = dato_file_manager_url + '&ckid=' + currentInstance;
			var $dialog = $('<div id = "dfilemanage_editor" class="modal draggable-modal modal-overflow" role="basic" aria-hidden="true" data-width="800px" style="display: none"><iframe style="border: 0px; " src="' + url + '" width="800px" height="600px"></iframe></div>');
			$dialog.modal();
		}
	};
	CKEDITOR.plugins.add('datofilemanager', {
		init: function(editor){
			editor.addCommand('datofilemanager', o);
			editor.ui.addButton('datofilemanager', {
				label: 'Insert Image',
				icon: this.path + 'icons/dato_image_icon.png',
				command: 'datofilemanager',
				toolbar: 'insert'
			});
		}
	});
})();

