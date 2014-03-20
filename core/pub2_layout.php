<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<html>
   <head>
      <title><?php echo MODULE."&gt;".PAGE.":".$GLOBALS['TITLE']; ?></title>
      <link rel="search" href="/search" >
      <?php echo get_css(); ?>
      <link rel="shortcut icon" href="<?php echo $GLOBALS['FAVICON']; ?>" type="image/x-icon" >
      <?php echo get_js(); ?>
   </head>
   <body class="<?php echo $GLOBALS['THEME']; ?>" >
      <?php echo get_loading(); ?>
      <div dojoType="dijit.Dialog" refreshOnShow="true" id='DIALOG' ></div>
      <div dojoType="dijit.layout.BorderContainer" style='width:100%' class='bContainerApp2'  gutters="false" liveSplitters="true" >
         <div dojoType="dijit.layout.ContentPane" region="top" gutter="false" style="padding:5px;" href="<?php echo gen_url(); ?>section=TOP">top</div>
         <div dojoType="dijit.layout.ContentPane" region="center" gutter="false" style="padding:5px;" href="<?php echo gen_url(); ?>section=CENTER">center</div>
         <div dojoType="dijit.layout.ContentPane" region="bottom" class="bgBottom" style='padding:5px;' > <?php echo get_footer(); ?> </div>
      </div>
      <?php parse_dojo(); ?>
   </body>
</html>
