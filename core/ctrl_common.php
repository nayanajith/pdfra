<?php
/**
//Sample array to provide all the configuration of the page

$GLOBALS['PAGE']=array(
   'name'                =>'acc_year';
   'table'               =>$GLOBALS['P_TABLES'][$NAME];
   'primary_key'         =>'id';
   'filter_table'        =>$GLOBALS['P_TABLES']['filter'];
   'filter_primary_key'  =>'id';
);
*/



include_once A_CLASSES."/model_class.php";
//include_once A_MODULES."/".MODULE."/".$GLOBALS['PAGE']['name']."_mdl.php";

//DEBUG: find where a class is declared
/*
$reflector = new ReflectionClass('Model');
echo $reflector->getFileName();
echo $reflector->getStartLine();
 */
$model    = new Model(
   $GLOBALS['PAGE']['table'],
   $GLOBALS['PAGE']['primary_key'],
   $GLOBALS['PAGE']['name'],
   $GLOBALS['PAGE']['filter_table'],
   $GLOBALS['PAGE']['filter_primary_key']
);

if(isset($_REQUEST['form'])){
   switch($_REQUEST['form']){
   case 'main':
      if(isset($_REQUEST['action'])){
         switch($_REQUEST['action']){
         case 'add':
           return $model->add_record();
         break;
         case 'modify':
           return $model->modify_record();
         break;
         case 'delete':
           return $model->delete_record(true);
         break;
         case 'combo':
            //Section of the model to reffered by the filering select data
            $section='MAIN_LEFT';
      
            //Check if the id is from toolbar and if so remote 'toolbar.' prefix from id
            $br=explode('__',$_REQUEST['field']);
            if(isset($br[1])){
               $section=strtoupper($br[0]);
               $_REQUEST['field']=$br[1];
            }
      
            $model->xhr_filtering_select_data($_REQUEST['field'],$section);
         break;
         case 'param':
            //Check if the id is from toolbar and if so remote 'toolbar.' prefix from id
            $param=$_REQUEST['param'];
            $br=explode('__',$_REQUEST['param']);
            if(isset($br[0]) &&  strtoupper($br[0])=='TOOLBAR'){
               $param=$br[1];
            }
      
            if($_REQUEST[$_REQUEST['param']] == 'NULL'){
               //rest the session variable corresponding to the given value if  it is NULL
               unset($_SESSION[PAGE][$param]);
               return_status_json('OK',"Reset ".$_REQUEST['param']);
            }else{
            //Set session variable corresponding to the value changed in front end
               $_SESSION[PAGE][$param]=$_REQUEST[$_REQUEST['param']];
               return_status_json('OK',"Set ".$_REQUEST['param']."=".$_REQUEST[$_REQUEST['param']]);
            }
         break;
         case 'add_filter':
            $_SESSION[PAGE]['FILTER']=get_temp_filter();
            return_status_json('OK','Filter added');
         break;
         case 'del_filter':
            del_temp_filter();
            return_status_json('OK','Filter deleted');
         break;
         case 'filler':
            //request for a record related to a given id
            if(isset($_REQUEST['id'])){
               $model->xhr_form_filler_data($_REQUEST['id'],null,$GLOBALS['MODEL']['KEYS']['PRIMARY_KEY']);
            }
         break;
         case 'filter_filler':
            //request for a record related to a given id
            if(isset($_SESSION[PAGE]['FILTER_ARRAY'])){
               echo json_encode($_SESSION[PAGE]['FILTER_ARRAY']);
            }
         break;

         case 'csv':
            //Custom field lists are accepted
            $field_list=null;
            if(isset($_REQUEST['list']) && $_REQUEST['list'] != ""){
               $field_list=explode(',',$_REQUEST['list']);
            }
            //Choose from module gen_csv or core gen_csv
            if(function_exists('gen_csv')){
               gen_csv($field_list);
            }else{
               $model->gen_csv($field_list);
            }
         break;
         }
    }
   break;
   case 'main_grid_store':
   case 'store3':
      if(isset($_REQUEST['data'])){
         switch($_REQUEST['data']){
         case 'csv':
            $model->gen_grid_csv();
         break;
         case 'json':
            $model->gen_grid_json();
         break;
         }
      }
   break;
   case 'filter':
      switch($_REQUEST['action']){
         case 'add':
           return $model->add_filter();
         break;
         case 'modify':
           return $model->modify_filter();
         break;
         case 'delete':
           return $model->delete_filter(null,true);
         break;
      }
   case 'system':
      if(isset($_REQUEST['action']) && isset($_REQUEST['user_id'])){
         switch($_REQUEST['action']){
         case 'switch_user':
            /*
             * This function moved to /core/login.php
            $user=$_REQUEST['user_id'];
            $arr = exec_query("SELECT * FROM ".$GLOBALS['TBL_LOGIN']['table']." WHERE user_id='$user'",Q_RET_ARRAY);
            $row=$arr[0];

            foreach($GLOBALS['TBL_LOGIN'] as $key => $value){
               if(isset($row[$value])){
                  $_SESSION[$key]   = $row[$value];
               }
            }
            $_SESSION['loged_module']    = MODULE;
             */
         break;
         }
      }
   break;
   }
}else{
   include A_CLASSES."/view_class.php";
   $view = new View($GLOBALS['PAGE']['table'],$GLOBALS['PAGE']['name']);

   //Generate form
   if(isset($GLOBALS['MODEL']['FORM']) && is_array($GLOBALS['MODEL']['FORM']) &&  sizeof($GLOBALS['MODEL']['FORM']) > 0){
      $view->gen_form();
   }

   //Generate toolbar
   $view->gen_toolbar();

   //Generate search grid
   if(isset($GLOBALS['MODEL']['KEYS']['PRIMARY_KEY'])){
      $view->gen_data_grid(array('rid'),$GLOBALS['MODEL']['KEYS']['PRIMARY_KEY']);
   }

   //finish view
   $view->finish_view();
}
?>
