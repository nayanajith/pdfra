<img src='icons1.png' style='padding:0px;margine:0px;'>
<pre>
<?php 
$s=getimagesize('icons1.png');
for($i=0;$i<$s[0];$i+=16){
	echo "<div style='height:16px;position:absolute;left:".($s[0]+10).";top:".($i+10)."'>$i</div>";
}
for($i=0;$i<$s[1];$i+=16){
	echo "<div style='-webkit-transform: rotate(270deg);	-moz-transform: rotate(270deg); -ms-transform: rotate(270deg); -o-transform: rotate(270deg); transform: rotate(270deg);;writing-mode: tb-rl;width:16px;position:absolute;left:".($i+8).";top:".($s[1]+20)."'>$i</div>";
}
?>
<div><div>
