<?php
/*--------------------------------paths---------------------------------------*/
//define('A_ROOT'    , getcwd());
define('A_ROOT'      , '/home/nayanajith/Projects/sis/engine');
define('W_ROOT'      , '/sis');
define('IMG'         , W_ROOT.'/img');
define('A_IMG'       , A_ROOT.'/img');
define('CSS'         , W_ROOT.'/css');
define('JS'          , W_ROOT.'/js');
define('A_MODULES'   , A_ROOT.'/mod');
define('W_MODULES'   , W_ROOT.'/mod');
define('A_CORE'      , A_ROOT.'/core');
define('A_CLASSES'   , A_ROOT.'/classes');
define('A_LIB'       , A_ROOT.'/lib');
define('W_LIB'       , W_ROOT.'/lib');
define('A_RPT'       , A_ROOT.'/rpt');
define('W_RPT'       , W_ROOT.'/rpt');
define('TMP'         , '/tmp/');
define('DB_CONF'     , A_ROOT.'/db_config.php');
define('INSTALLER'   , A_ROOT.'/install/install.php');
define('LOGIN'       , A_CORE.'/login.php');
define('LOG'         , A_ROOT.'/messages.log');
define('LOG_ENABLED' , 'YES'); //YES/NO : this will enable write messages to LOG
define('ERROR_LOG'   , A_ROOT.'/errors.log');

define('FPDF_FONTS_PATH'  , A_ROOT.'/errors.log');

/*Enable disable HTTP compression YES/NO */
define('COMPRESS' , 'NO'); 

/*------------------------------title info------------------------------------*/
$GLOBALS['TITLE_SHORT'] = 'UIS';
$GLOBALS['TITLE']       = 'UCSC Information System';
$GLOBALS['TITLE_LONG']  = '&nbsp;University of Colombo School of Computing<br/>&nbsp;Information System';
$GLOBALS['INSTITUTE']   = 'University of Colombo School of Computing';
$GLOBALS['ADMIN_MAIL']  = 'uis@ucsc.cmb.ac.lk';
$GLOBALS['INFO_MAIL']   = 'info@ucsc.cmb.ac.lk';
$GLOBALS['NOREPLY_MAIL']= 'noreply@ucsc.cmb.ac.lk';
$GLOBALS['LOGO']        = 'ucsc-logo.png';
$GLOBALS['LOGO2']       = 'uoc-logo.png';
$GLOBALS['FAVICON']     = 'favicon.ico';
$GLOBALS['LAYOUT']      = 'pub'; //web,app,pub
$GLOBALS['THEME']         = 'claro'; //claro,nihilo,soria,tundra
$GLOBALS['PAGE_GEN']      = '';

/*---------------------------configure Database--------------------------------*/
$GLOBALS['DB']          = 'ucscsis';
$GLOBALS['DB_HOST']     = 'localhost';
$GLOBALS['DB_USER']     = 'root';
$GLOBALS['DB_PASS']     = 'letmein';
$GLOBALS['DB_TYPE']     = 'mysql';
$GLOBALS['CONNECTION']  = null;

/*-----------------------configure login system--------------------------------*/
$GLOBALS['TBL_LOGIN']   = array(
   'table'      =>'users', 
   'username'   =>'username',
   'password'   =>'password',
   'fullname'   =>'username',
   'user_id'   =>'user_id',
   'permission'=>'permission'       
);
$GLOBALS['AUTH_MOD']       ='MYSQL'; //authentication modes: LDAP,MYSQL,PASSWD

//UCSC ldap [zimbra] configuration
$GLOBALS['LDAP_SERVER']    = "192.248.16.86";//mail.ucsc.lk
$GLOBALS['LDAP_PORT']      = 389;
$GLOBALS['LDAP_BIND_RDN']  = "uid=%s,ou=people,dc=ucsc,dc=cmb,dc=ac,dc=lk";
 

/*-------------------------------onfigure mail--------------------------------*/
$GLOBALS['MAIL_CONF']=array (
   //'host'       => 'ssl://192.248.16.86',
   //'port'       => '465',
   'port'       => '25',
   'host'       => '192.248.16.86',
   'auth'       => 'true',
   'username'    => 'expr',
   'password'    => base64_decode('RXhwZXJpbWVuVDU2Nwo=') 
); 
/*------------------------------DEBUG ON OFF ---------------------------------*/
define('DEBUG',   true); //true=ON and false=OFF
?>
