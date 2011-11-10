<?php
define('MOD_CLASSES',A_MODULES."/".MODULE."/classes");
define('MOD_RESOURCE',A_MODULES."/".MODULE."/res");
define('MOD_W_RESOURCE',W_MODULES."/".MODULE."/res");
define('MOD_CORE',A_MODULES."/".MODULE."/core");
$GLOBALS['MARK_FILE_STORE'] = "mcq/scanned_mark_sheets";

include_once(A_CORE."/database_schema.php");
include_once(MOD_CORE."/database.php");
?>
