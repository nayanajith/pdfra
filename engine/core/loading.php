<style>
/* pre-loader specific stuff to prevent unsightly flash of unstyled content */
#loader {
   padding:0;
   margin:0;
   position:absolute;
   top:0; left:0;
   width:100%; height:100%;
   background:#ededed;
   z-index:999;
   vertical-align:middle;
}
#loaderInner {
   padding:2px;
   position:relative;
   width:155px;
   background:gray;
   color:#fff;
   /*
   margin-top:200px;
   margin-left:auto;
   margin-right:auto;
   */
}
</style>
<?php
/*Loading bar at top*/
echo '<div id="loader"><div id="loaderInner" style="direction:ltr;">Loading <?php echo $GLOBALS["TITLE_SHORT"]; ?> ... </div></div>';
?>
