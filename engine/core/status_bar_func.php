<?php 
d_r('dijit.Dialog');
?>
<script language='javascript'>
   
   /*Update status bar*/
   var max_status_length=150;
   var stausDialog;

   function update_status_bar(status,info){
      status=status.toUpperCase();
      var orig_info=info;
      switch(status){
         case 'OK':
            info=info;
         break;
         case 'ERROR':
            info="<font color='red'>"+info+"</font>";
         break;
         case 'NOT_DEFINED':
            info="<font color='orange'>"+info+"</font>";
         break;
         default:
            info="<font color='green'>"+info+"</font>";
         break;
      }
      <?php if($GLOBALS['LAYOUT']!='pub'){ ?>
      /*If the message too lengthy show it as a dialog*/
      if(info.length < max_status_length){
         var status_bar = document.getElementById('status_bar') ;
         status_bar.innerHTML=info;
         status_bar.title=orig_info;
      }else{
         /*Create dialog only if not initialized*/
         if(typeof stausDialog === 'undefined') {
            stausDialog = new dijit.Dialog({
               title: "Status report",
               style: "width: 400px;"
            });
         }
      
         var button="<br/><center><button dojoType='dijit.form.Button' onClick=\"stausDialog.hide()\" >OK</button></center>";
         stausDialog.attr("content", info+button);
         stausDialog.show();
      }
      <?php }else{ ?>
         /*Create dialog only if not initialized*/
         if(typeof stausDialog === 'undefined') {
            stausDialog = new dijit.Dialog({
               title: "Status report",
               style: "width: 400px;"
            });
         }
      
         var button="<br/><center><button dojoType='dijit.form.Button' onClick=\"stausDialog.hide()\" >OK</button></center>";
         stausDialog.attr("content", info+button);
         stausDialog.show();
      <?php } ?>
   }

   /*Update progress bar and processing image (rotating arrows)*/
   function update_progress_bar(progress){
   
      <?php if($GLOBALS['LAYOUT']!='pub' ){ ?>
      jsProgress.update({maximum: 100, progress: progress });
      <?php } ?>
      var process = document.getElementById('process') ;
      if(progress == 100 || progress == 0){
         process.innerHTML="<img src='<?php echo IMG."/process-stopped.gif"; ?>' >";
      }else{
         process.innerHTML="<img src='<?php echo IMG."/process.gif"; ?>' >";
      }
   }

</script>
