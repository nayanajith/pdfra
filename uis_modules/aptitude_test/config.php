<?php 

define('MOD_CLASSES',A_MODULES."/".MODULE."/classes");
define('MOD_CORE',A_MODULES."/".MODULE."/core");
define('MOD_A_ROOT',A_MODULES."/".MODULE);

/*---------------------------onfigure Database--------------------------------*/

$GLOBALS['DB']     = 'bict_admissions_2010';
//$GLOBALS['DB']     = 'aptitude_test';
$GLOBALS['DB_HOST']= 'localhost';
$GLOBALS['DB_USER']= 'root';
$GLOBALS['DB_PASS']= 'letmein';
$GLOBALS['DB_TYPE']= 'mysql';

$GLOBALS['TBL_LOGIN']   = array(
   'table'     =>'employee', 
   'username'  =>'EmployeeNo',
   'password'  =>'EmployeeNo',
   'fullname'  =>'OtherName',
   'permission'=>'EmployeeNo'       
);

$GLOBALS['TITLE_SHORT'] = 'APTTESTREG';
$GLOBALS['TITLE']       = 'Aptitude Test Registration';
$GLOBALS['TITLE_LONG']  = 'University of Colombo School of Computing Attendance System';
$GLOBALS['LOGO']        = 'ucsc-logo.png';
$GLOBALS['FAVICON']     = 'favicon.ico';

//include(MOD_CORE."/database_schema.php");
include(MOD_CORE."/database.php");
?>
