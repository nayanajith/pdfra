<?php 
/*---------------------------onfigure Database--------------------------------*/

$GLOBALS['DB']     = 'UCSCAttendance';
$GLOBALS['DB_HOST']= '10.16.80.150';
$GLOBALS['DB_USER']= 'sa';
$GLOBALS['DB_PASS']= 'gads71';
$GLOBALS['DB_TYPE']= 'mssql';

$GLOBALS['TBL_LOGIN']   = array(
   'table'     =>'employee', 
   'username'  =>'EmployeeNo',
   'password'  =>'EmployeeNo',
   'fullname'  =>'OtherName',
   'permission'=>'EmployeeNo'       
);

$GLOBALS['TITLE_SHORT'] = 'UAS';
$GLOBALS['TITLE']       = 'UCSC Attendance System';
$GLOBALS['TITLE_LONG']  = 'University of Colombo School of Computing Attendance System';
$GLOBALS['LOGO']        = IMG.'/ucsc-logo.png';
$GLOBALS['FAVICON']     = IMG.'/favicon.ico';

?>
