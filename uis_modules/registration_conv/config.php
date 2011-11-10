<?php 
/*---------------------------easy generic paths--------------------------------*/
define('MOD_CLASSES',A_MODULES."/".MODULE."/classes");
define('MOD_CORE',A_MODULES."/".MODULE."/core");
define('INVOICE_DIR',A_MODULES."/".MODULE."/invoice");
define('VOUCHER_DIR',A_MODULES."/".MODULE."/voucher");

/*---------------------------configure Database--------------------------------*/
/*
$GLOBALS['DB']     = 'payment_gateway';
$GLOBALS['DB_HOST']= 'localhost';
$GLOBALS['DB_USER']= 'root';
$GLOBALS['DB_PASS']= 'letmein';
$GLOBALS['DB_TYPE']= 'mysql';
*/

include_once(MOD_CORE."/database_schema.php");
include_once(MOD_CORE."/database.php");

//convocation registration login
$GLOBALS['MOD_TBL_LOGIN']   = array(
   'db_host'		=>'192.248.16.109', 
   'db_user'		=>'uis', 
   //'db_password'	=>base64_decode('bGV0bWVpbgo='), 
   'db_password'	=>'!@#$%', 
   'db'				=>'moodledb_pg', 

   'table'			=>'mdl_user', 
   'username'		=>'username',
   'password'		=>'password',
   'fullname'		=>'lastname',
   'user_id'		=>'email',
   'permission'	=>'auth'       
);

/*---------------------------header modification--------------------------------*/
/*
$GLOBALS['TITLE_SHORT'] = 'Convocation rag';
$GLOBALS['TITLE']       = 'Convocation registration form ';
$GLOBALS['TITLE_LONG']  = 'University of Colombo School of Computing Payment Gateway';
$GLOBALS['LOGO']        = 'ucsc-logo.png';
$GLOBALS['FAVICON']     = 'favicon.ico';
*/

/*--------------------email confirmation key addtion----------------------------*/
$GLOBALS['CONFIRM_ADDITION']=md5('#ucsc$');

/*---------------------------header modification--------------------------------*/
$GLOBALS['PAYMENT_ADMIN_MAIL'] = 'UCSC information system <info@ucsc.cmb.ac.lk>';
$GLOBALS['PAYMENT_CLAER_MAIL'] = '<nml@ucsc.cmb.ac.lk>';

/*----------------------postgraduate payment gategories--------------------------------*/
$payment_category=array(
	'MSC'=>array('2000','SRI LANKAN RUPEES TWO THOUSAND ONLY'),
	'DIP'=>array('2500','SRI LANKAN RUPEES TWO THOUSAND FIVE HUNDRED ONLY'),
	'MPHIL'=>array('3000','SRI LANKAN RUPEES THREE THOUSAND ONLY')
);

//Convenience fee tax percentage
$GLOBALS['TAX']=3.093;
?>
