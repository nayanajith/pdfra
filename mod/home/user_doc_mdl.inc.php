<?php
function get_doc_file_(){
   $mod_page=get_param('page_id');
   $mod_page=explode('/',$mod_page);
   return get_doc_file($mod_page[0],$mod_page[1],get_param('role_id'));
}


//Add user doc file
function add_doc(){
   $doc_file=get_doc_file_();
   if(!file_exists($doc_file)){
      $fh=fopen($doc_file,'wb');
      fwrite($fh,$_REQUEST['doc']);
      fclose($fh);
      return_status_json('OK',"File created!");
   }else{
      return_status_json('ERROR',"File already exists!");
   }
}

//Update user doc file
function save_doc(){
   $doc_file=get_doc_file_();
   if(file_exists($doc_file)){
      $fh=fopen($doc_file,'wb');
      fwrite($fh,stripslashes($_REQUEST['doc']));
      fclose($fh);
      return_status_json('OK',"File updated!");
   }else{
      return_status_json('ERROR',"File not found!");
   }
}

//Delete user doc file
function delete_doc(){
   $doc_file=get_doc_file_();
   if(file_exists($doc_file)){
      if(unlink($doc_file)){
         return_status_json('OK',"File deleted!");
      }else{
         return_status_json('ERROR',"Error deleting file!");
      }
   }else{
      return_status_json('ERROR',"File not found!");
   }
}
?>
