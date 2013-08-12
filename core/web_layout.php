<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<html>
   <head>
      <title><?php echo MODULE."&gt;".PAGE.":".$GLOBALS['TITLE']; ?></title>
      <link rel="search" href="/search" >

<!--_________________________________CSS_____________________________________-->
      <?php 
         echo $GLOBALS['VIEW']['CSS'];
         echo get_css();
      ?>
<!--______________________________FAVICON____________________________________-->
      <link rel="shortcut icon" href="<?php echo $GLOBALS['FAVICON']; ?>" type="image/x-icon" >
<!--______________________DOJO JAVASCRIPT load modules_______________________-->
      <?php 
         echo get_js();
      ?>
   </head>
<!--_____________________BODY with dojo border container_____________________-->
<!--
Three border containers were used 
1) 
top:         Bannar
leading:      Tree menu
center:      [border container 2]
trailing:   ___
bottom:      Organization info

2)
top:         [border container 3]
center:      Body

3)
top:         Menu
bottom:      Tool bar
-->
   <body class="<?php echo $GLOBALS['THEME']; ?>" >
<!--__________________________start loading ________________________________-->
   <?php
      echo get_loading();
   ?>
<!--____________________________end loading ________________________________-->
      <div dojoType="dijit.layout.BorderContainer" class='bgTop bContainer'    gutters="false" liveSplitters="true" >

<!--
This contains the login box from core/login.php and program selector from core/program.php
-->
         <div dojoType="dijit.layout.ContentPane" region="top" gutter="false" style="padding:5px;">
            <!-- bannar -->
            <img src="<?php echo $GLOBALS['LOGO']; ?>" width=60px style='float:left'>
            <h1 style='float:left;font-size:24px;padding:0px;span:0px;'><?php echo $GLOBALS['TITLE_LONG']; ?></h1>
            <div style='float:right;'>
<!--__________________________end Login form ________________________________-->
            <?php 
               echo get_login();
            ?>
<!--______________________________end Login form ____________________________-->

<!--_________________________start Program selector__________________________-->
            <?php 
               //program_select($program); 
            ?>
<!--__________________________end Program selector___________________________-->
            </div>
         </div>
<!--___________________Leading area with the tree menu_______________________-->
<!--
JSON file for the menu is generated dinamically from mod/module_man/manage_module.php
-->

            <!--CENTER box of the BorderContainer-1 -->
            <div dojoType="dijit.layout.ContentPane" region="center" style="padding:0px;" >

               <!--BorderContainer-2 (BorderContainer-3 and body)-->
               <div dojoType="dijit.layout.BorderContainer" style="width:100%; height:100%; padding:0px;" gutters="false">
                     
                  <!--TOP box of BorderContainer-2 (BorderContainer-3)-->
                  <div dojoType="dijit.layout.ContentPane" region="top" style="height:100px; padding:0px;">
                     <?php
                        d_r("dijit.layout.BorderContainer");
                        echo get_navigator();
                     ?>
                  </div>

                  <!--end TOP box of BorderContainer-2 (BorderContainer-3)-->

                  <!--CENTER box of BorderContainer-2-->
                  <div dojoType="dijit.layout.ContentPane" region="center" id="data_body" class="bgBottom" style="padding:5px;">
<!--________________________start data_body area_____________________________-->
                     <table width='100%'>
                        <tr>
                           <td id='MAIN_TOP' colspan='2' valign='top' width='100%'>
                              <?php 
                              echo get_main_top();
                              ?>
                           </td>
                        </tr>
                        <tr>
                           <td id='MAIN_LEFT' valign='top' align='left' width='50%'>
                              <?php 
                              echo get_main_left();
                              ?>
                           </td>
                           <td id='MAIN_RIGHT' valign='top'  align='right'  width='50%'>
                              <?php 
                              echo get_main_right();
                              ?>
                           </td>
                        </tr>
                        <tr>
                           <td id='MAIN_BOTTOM' colspan='2' valign='top' width='100%'>
                              <?php 
                              echo get_main_bottom();
                              ?>
                           </td>
                        </tr>

                     </table>
<!--_________________________end data_body area______________________________-->
                  </div>
                  <!--end CENTER box of BorderContainer-2-->

                  <!--BOTTOM box of BorderContainer-2-->
                  <div dojoType="dijit.layout.ContentPane" region="bottom" class="bgBottom" jsId="status_bar">
<!--___________________________start statusbar_______________________________-->
                     <?php
                        d_r("dijit.layout.ContentPane");
                        d_r("dijit.Toolbar");

                        echo "<div id='toolbar' jsId='toolbar' dojoType='dijit.Toolbar'>";
                        echo get_toolbar();
                        echo "</div>";
                        echo get_statusbar();   
                     ?>
<!--___________________________end statusbar_________________________________-->
                  </div>
                  <!--end BOTTOM box of BorderContainer-2-->
               </div>
               <!--end of BorderContainer-2-->
            </div>
            <!--end CENTER box of the BorderContainer-1 -->

            <!--BOTTOM box of the BorderContainer-1 -->
            <div dojoType="dijit.layout.ContentPane" region="bottom" class="bgBottom" style='padding:5px;' >
<!--______________________________start footer_______________________________-->
            <?php
               echo get_footer();
            ?>
<!--_______________________________end footer________________________________-->
            </div>
            <!--end BOTTOM box of the BorderContainer-1 -->
      </div>
      <!--end of the BorderContainer-1 -->
<!--_______________________________parse dojo________________________________-->
      <?php parse_dojo(); ?>
   </body>
</html>
