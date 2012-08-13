<?php
if(isset($_REQUEST['fullscreen']) && $_REQUEST['fullscreen'] == 'true'){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >

<html>
   <head>
      <title><?php echo MODULE."&gt;".PAGE.":".$GLOBALS['TITLE']; ?></title>
      <link rel="search" href="/search" >

<!--_________________________________CSS_____________________________________-->
      <?php 
         include A_CORE."/style.php";
      ?>
<!--______________________________FAVICON____________________________________-->
      <link rel="shortcut icon" href="<?php echo $GLOBALS['FAVICON']; ?>"type="image/x-icon" >

   </head>
   <body class="<?php echo $GLOBALS['THEME']; ?>">

<div class='web_bg bgTop'>
<table width='100%' cellpadding=5 cellspacing=0 >
<!--header-->
   <tr>
      <td colspan=2 style>
         <img src="<?php echo $GLOBALS['LOGO']; ?>" width=80px style='float:left'>
         <span style='float:left;font-size:26px;font-weight:bold;padding:0px;span:0px;'><?php echo $GLOBALS['TITLE_LONG']; ?> <font color='green' >Help+Guide</font></span>
      </td>
   </tr>
</table>

<?php
}
echo "<div class='help round' id='help' style='height:500px;overflow:auto' ><div>";

//Get the page name
$page=$menu_array[PAGE];
if(is_array($page)){
   $page=$page['label'];
}

//Help header
echo "<div style='padding-top:10px;padding-left:10px;font-size:20px;font-wight:bold;border-bottom:1px solid silver' >User Guide for the [".$GLOBALS['MODULES'][MODULE]." / ".$page."] </div>";
include_once "markdown.php";
$help_arr=exec_query("SELECT * FROM ".s_t('user_doc')." WHERE module_id='".MODULE."' AND page_id='".PAGE."'",Q_RET_ARRAY);
foreach($help_arr as $key=>$row){
   echo Markdown($row['doc']);
}

//If there is a help file created acordance to the page it will also be loaded
$help_file=A_MODULES."/".MODULE."/".PAGE."_help.txt";
if(file_exists($help_file)){
   $fh=fopen($help_file,'r');
   $content=fread($fh,filesize($help_file));
   fclose($fh);
   echo Markdown($content);
}
echo "</div></div>";

if(isset($_REQUEST['fullscreen']) && $_REQUEST['fullscreen'] == 'true'){
   echo "</body></html>";
}

?>
