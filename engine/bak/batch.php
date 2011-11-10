<?php
/*
 *
 * This file is to be included in reports.php
 * As a part of it 
 * 
 * This will not work alone
 *
 *
 */
echo "<table class=data_table ><tr><td class='data round'><h3>Summery</h3>
<div class=data style='border:0px;'>";
$cols2=array("coursesid");
foreach (get_examids($batch) as $key => $value){
   print_table($table,$cols2,$condition." AND marks3 >= 50","marks3 DESC",'Pass',$count);
}

echo "</div></td><td class='data round'><h3>Detail</h3>";
echo "<div class=data style='border:0px;'>";

echo "</div></td></tr></table>";
?>
