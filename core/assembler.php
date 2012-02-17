<?php
//main page selection logic
$main='';

if($GLOBALS['LAYOUT']=='pub'){
   if(!file_exists(A_MODULES."/".MODULE."/".PAGE.".php")){
      $main="error.php";
   }else{
      $main=A_MODULES."/".MODULE."/".PAGE.".php";
   }
}else{
   if(!isset($_SESSION['username'])){
      if(file_exists(A_MODULES."/".MODULE."/about.php")){
         $main=A_MODULES."/".MODULE."/about.php";
      }else{
         $main="error.php";
      }
   }elseif(!file_exists(A_MODULES."/".MODULE."/".PAGE.".php")){
      $main="error.php";
   }else{
      $main=A_MODULES."/".MODULE."/".PAGE.".php";
   }
}


//Main file contains the module+page specific features and outputs which will affect the view 
add_to_view('MAIN',       $main);



//Page footer
add_to_view('FOOTER',     A_CORE."/footer.php");


//Status bar  for seb/app layouts
add_to_view('STATUSBAR',  A_CORE."/status_bar.php");

//Loading animation for all reloads
add_to_view('LOADING',    A_CORE."/loading.php");

//Javascript of requiring dojo and other custom scripts
add_to_view('JS',         A_CORE."/dojo_require.php");

//Javascript for status bar functions
add_to_view('JS',         A_CORE."/status_bar_func.php");

//Stylesheets for the page
add_to_view('CSS',        A_CORE."/style.php");


//Fill the view according to different layouts
switch($GLOBALS['LAYOUT']){
case 'pub':
   
   //Stylesheets for the page
   add_to_view('BREADCRUMB', A_CORE."/breadcrumb.php");

   //Navigator for public layout is a link list
   add_to_view('NAVIGATOR',  A_CORE."/module_link_list.php");

   if(isset($_SESSION['username'])){
      $GLOBALS['VIEW']['LOGIN'] .="You are loged in as ".$_SESSION['username']."<br>";
      $GLOBALS['VIEW']['LOGIN'] .="<a href=\"?page=".PAGE."&module=".MODULE."&logout=logout\">Logout</a>";
   }

break;
case 'app':
   //Program selector
   ob_start();
   echo "Change Program:";
   program_select($program); 
   $GLOBALS['VIEW']['PROGRAM'] .= ob_get_contents();
   ob_end_clean();

   //login/logout 
   ob_start();
   if (isset($_SESSION['username'])){
      echo after_login();
   }else{
      echo before_login();
   }
   $GLOBALS['VIEW']['LOGIN'] .= ob_get_contents();
   ob_end_clean();

   //Navigator tree
   add_to_view('NAVIGATOR',A_CORE."/module_tree.php");

   //Menubar
   add_to_view('MENUBAR',  A_CORE."/menubar.php");

   //WIdgetst column
   add_to_view('WIDGETS',  A_CORE."/widget_column.php");

   //Tool bar for web/app layouts
   add_to_view('TOOLBAR',  A_CORE."/toolbar.php");
break;
case 'web':
   //Program selector
   ob_start();
   echo "Change Program:";
   program_select($program); 
   $GLOBALS['VIEW']['PROGRAM'] .= ob_get_contents();
   ob_end_clean();

   //login/logout 
   ob_start();
   if (isset($_SESSION['username'])){
      echo after_login();
   }else{
      echo before_login();
   }
   $GLOBALS['VIEW']['LOGIN'] .= ob_get_contents();
   ob_end_clean();

   //Navigator for web layout is a tab bar
   add_to_view('NAVIGATOR',  A_CORE."/module_tab_bar.php");

   //Tool bar for web/app layouts
   add_to_view('TOOLBAR',    A_CORE."/toolbar.php");
break;
}

?>
