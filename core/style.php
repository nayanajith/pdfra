<?php
//Select effective theme
$theme=$GLOBALS['THEME'];
if(isset($_SESSION['THEME'])){
   $theme=$_SESSION['THEME'];
}

$enhanced_grid_theme='claro';
if(in_array($theme,array('tundra'))){
   $enhanced_grid_theme=$theme;
}
echo "<style type='text/css'>
	@import '".JS."/dijit/themes/".$theme."/".$theme.".css';

	@import '".JS."/dojox/grid/resources/".$theme."Grid.css';
	@import '".JS."/dojox/grid/resources/Grid.css';

   @import '".JS."/dojox/grid/enhanced/resources/".$enhanced_grid_theme."/EnhancedGrid.css';
   @import '".JS."/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css';

	@import '".CSS."/common_css.php';
</style>"
?>
