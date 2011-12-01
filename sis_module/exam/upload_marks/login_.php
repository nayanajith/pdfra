<?php
if (isset($_SESSION['username']) && $_SESSION['permission'] == 'examiner') {
   for ($i = 0; $i < sizeof($admin_menu_array); $i++) {
      $item=$admin_menu_array[$i];
      if ($page == $item) {
         print "<li class='first active'><a  href='".$GLOBALS['PAGE_GEN']."?page=$item'>".$item."</a></li>";
      } elseif ($i == (sizeof($admin_menu_array) - 1)) {
         print "<li class='last'><a  href='".$GLOBALS['PAGE_GEN']."?page=$item'>$item</a></li>";
      } else {
         print "<li><a  href='".$GLOBALS['PAGE_GEN']."?page=$item'>$item</a></li>";
      }
   }
    
} elseif (isset($_SESSION['username'])) {

   for ($i = 0; $i < sizeof($user_menu_array); $i++) {
      $item=$user_menu_array[$i];
      if ($item == $page) {
         print "<li class='first active'><a class='trac' href='".$GLOBALS['PAGE_GEN']."?page=$item'>".$item."</a></li>";
      } elseif ($i == (sizeof($user_menu_array) - 1)) {
         print "<li class='last'><a class='trac' href='".$GLOBALS['PAGE_GEN']."?page=$item'>$item</a></li>";
      } else {
         print "<li><a class='trac' href='".$GLOBALS['PAGE_GEN']."?page=$item'>$item</a></li>";
      }
   }
}
?>
