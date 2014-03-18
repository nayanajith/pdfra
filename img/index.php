<?php
$img='icons1.png';
if(isset($_REQUEST['icons'])){
   $img=$_REQUEST['icons'];
}

$icons=array(
   'icons.png',
   'icons1.png',
   'icons2.png',
);
?>

<img src='<?php echo $img; ?>' style='padding:0px;margine:0px;'>
<pre>

<?php 
$s=getimagesize($img);
for($i=0;$i<$s[0];$i+=16){
   for($j=0;$j<$s[1];$j+=16){
      echo "<div style='height:16px;width:16px;position:absolute;left:".($j+6).";top:".($i+6)."' title='-${j}px -${i}px' onclick='prompt(\"Coordinates:\",\"-${j}px -${i}px\")'></div>";
   }
}

foreach($icons as $file){
   echo "<img src='$file' width=100 onclick='window.location.href=\"index.php?icons=$file\"'>";
}
?>
