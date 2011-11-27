<?php
include_once ('../config.php');
include_once (A_CORE.'/common.php');
header("Content-type: application/javascript");
header("Content-Disposition: attachment; filename=\"common.js\"");
?>
/*--help viewer--*/
function help_dialog(){
	dojo.xhrPost({
      url 		: '<?php echo gen_url(); ?>&form=main&action=help',
  	   handleAs :'text',
  	   load 		: function(response, ioArgs) {	     
         help_Dialog = new dijit.Dialog({
            title: "Help",
            style: "width: 800px;"
         });

         var button="<br/><center><button dojoType='dijit.form.Button' onClick=\"help_Dialog.hide()\" >OK</button></center>";
         help_Dialog.attr("content", response+button);
         help_Dialog.show();
  	   },
  	   error : function(response, ioArgs) {
  	  			update_status_bar('ERROR',response);
  	   }
   });
}


/*-- Downloader --*/
dojo.require('dojo.io.iframe');

function download(url){
	update_status_bar('OK','Processing...');
	var iframe = dojo.io.iframe.create("downloader");
	dojo.io.iframe.setSrc(iframe, url, true);
	update_status_bar('OK','Done');
   //DEBUG ONLY
	update_status_bar('OK',url);
	update_progress_bar(100);
}


function get_request_value( name ){
   name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
   var regexS = "[\\?&]"+name+"=([^&#]*)";
   var regex = new RegExp( regexS );
   var results = regex.exec( window.location.href );
   if( results == null ){
		return "";
   }else{
		return results[1];
	}
}

function info_dialog(info){
infoDialog = new dijit.Dialog({
   title: "Information",
   style: "width: 400px;"
});

var button="<br/><center><button dojoType='dijit.form.Button' onClick=\"infoDialog.hide()\" >OK</button></center>";
infoDialog.attr("content", info+button);
infoDialog.show();
}


