<?php
foreach($GLOBALS['MODULES'] as $key => $value){
   $schema=A_MODULES."/".$key."/core/database_schema.php";
   if(file_exists($schema)){
      include $schema;
      print_r(array_keys($system_table_schemas));
      print_r(array_keys($program_table_schemas));
   }
}

include A_CORE."/database_schema.php";
if(isset($_REQUEST['action'])){ /*haldle requests*/
   switch($_REQUEST['action']){
      case 'generate_db':
         $drop     =drop_tables($GLOBALS["S_TABLES"]);
         $create   =create_tables($system_table_schemas);
         $res      =exec_query("INSERT INTO ".$GLOBALS["S_TABLES"]['users']."(username,password,permission,layout)values('admin',md5('admin'),'SUPER','app') ",Q_RET_MYSQL_RES);

         if(!$create){
            return_status_json('ERROR','Error in table recreation process, it may partially done!');
         }else{
            return_status_json('OK','Table re-generation completed successfully');
         }
      break;
   }
return;
}
d_r('dijit.form.Form');
d_r('dijit.form.Button');
?>
<form id='test_frm' dojoType='dijit.form.Form'>
<button dojoType='dijit.form.Button' onClick='submit_form("generate_db")'>
Regenerate database
</button>
</form>
<script type='text/javascript' >
   function submit_form(action){
      update_status_bar('OK','...');
      update_progress_bar(10);
      if (dijit.byId('test_frm').validate()) {
         dojo.xhrGet({
         url         : '<?php echo gen_url(); ?>&action='+action, 
         handleAs      : 'json',
         form         : 'test_frm', 

         handle: function(response,ioArgs){
            update_status_bar(response.status,response.info);
            if(response.status=='ERROR'){   
               //update_progress_bar(0);
            }else{
               update_progress_bar(100);
            }
         },

         load: function(response) {
            update_status_bar('OK','rquest sent successfully');
            update_progress_bar(50);
         }, 
         error: function() {
            update_status_bar('ERROR','error on submission');
            update_progress_bar(0);
         }
      });

      return false;
   }else{
      update_status_bar('ERROR','Form contains invalid data.  Please correct first');
      return false;
   }
   return true;
}
</script>

