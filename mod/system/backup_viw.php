<?php
d_r('dijit.form.Form');
d_r('dijit.form.CheckBox');

add_to_main_top(
"
<script>
dojo.require('dojox.embed.Flash');
if(dojox.embed.Flash.available){
  dojo.require('dojox.form.uploader.plugins.Flash');
}else{
  dojo.require('dojox.form.uploader.plugins.IFrame');
}
</script>

<label for='file_name'>
	<b>
		Upload database restore file 
	</b>
</label>
<form method='post' action='?form=main&action=upload_cadre&file_id=import_csv' enctype='multipart/form-data' style='border:1px dotted silver;width:400px;'>
	<div id='file_name_info' >
	</div>
	<input id='file_name_path' type='hidden' value='".MOD_BACKUP."'/>
	<input 
		name='import_csv' 
		type='file' 
		dojoType='dojox.form.Uploader' 
		label='Select database restore file' 
		id='file_name' 
		class='browseButton' 
		multiple='false'
		data-dojo-props='
			onComplete:function(arr){
				var status=\"OK\";
				if(arr.match(/error/g)){
					status=\"ERROR\";
					update_progress_bar(0);
				}else{
					reload_main_right();
					update_progress_bar(100);
				}
            update_status_bar(status,arr);
			},
			onUpload:function(arr){
				var status=\"OK\";
				if(arr.match(/error/g)){
					status=\"ERROR\";
				}
            update_status_bar(status,arr);
            update_progress_bar(100);
			}'
	/>
	<input type='submit' label='Upload' dojoType='dijit.form.Button' />
	<div dojoType='dojox.form.uploader.FileList' uploaderId='file_name'>
	</div>
</form>
"
);

add_to_main_bottom("<form dojoType='dijit.form.Form' jsId='main' id='main' name='main'>");
add_to_main_bottom(list_backups());
add_to_main_bottom("</form>");

set_layout_property('app2','MAIN_TOP','style','height','20%');
set_layout_property('app2','MAIN_BOTTOM','style','height','80%');
?>
