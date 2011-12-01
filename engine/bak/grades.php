<?php
session_start();
include_once("config.php");
include_once('common.php');
$page_title="Grades";
include_once('header.php');
?>
<table width=600px; style='margin-left:auto;margin-right:auto' >
<tr>
<td>
<?php
echo "
<ul class=ul_menu>
<li><a href='$url&enter=1'>Enter</a></li>
<li><a href='$url&reports=1'>Reports</a></li>
</ul>
";
?>
</td>
<td>
<?php
include "course_browse.php";
?>
</td>
<td>
<?php
$url="?";
foreach($_GET as $key => $value){
   $url.="$key=$value&";
}

echo "
<ul class=ul_menu>
<li><a href='$url&summery=1'>Summery</a></li>
<li><a href='$url&all=1'>All</a></li>
<li><a href='$url&repeat=1'>repeat</a></li>
<li><a href='$url&absent=1'>absent</a></li>
<li><a href='$url&fail=1'>fail</a></li>
<li><a href='$url&pass=1'>pass</a></li>
<li><a href='$url&stat=1'>stat</a></li>
</ul>
";
?>
</td>
</tr>
</table>
<?php
openDB();
$indexno =$_GET['indexno'];
$courseid=$_GET['courseid'];
$examid  =$_GET['examid'];
$table   =$_GET['table'];

$all     =$_GET['all'];
$repeat  =$_GET['repeat'];
$absent  =$_GET['absent'];
$fail    =$_GET['fail'];
$pass    =$_GET['pass'];
$stat    =$_GET['stat'];
$summery =$_GET['summery'];

$cols =array('indexno'=>'Index No','marks3'=>'Marks','final'=>'Grades');

function count_rows($table,$condition){
   $query="
   SELECT  COUNT(indexno)
   FROM     $table 
   WHERE    $condition 
   ";

   $result  = mysql_query($query, $GLOBALS['CONNECTION']);
   $row     = mysql_fetch_array($result);
   return $row['COUNT(indexno)'];
}

function find_repeat($examid,$indexno){
   //1011,0931,1031
   //09002323
   $cur_year   =(int)substr($examid,0,2); 
   $ac_year    =(int)substr($examid,-2,1); 
   $reg_year   =(int)substr($indexno,0,2);
   if($indexno){
      /*If index number provided it will return the remainder 0 for CURRENT students >0 for REPEAT STUDENTS*/
      return $reg_year-($cur_year-$ac_year);
   }
   else{
      /*will return CURRENT students registration year*/
      $reg_year=$cur_year-$ac_year; 
      if($reg_year >= 10){
         return  $reg_year;
      }else{
         return  "0".$reg_year;
      }
   }
   
}

function print_table($table,$cols_th,$condition,$orderby,$title,$co){
   $count=0;
   global $examid;
   $th   =array();
   $cols =array();

   foreach($cols_th as $key => $value){
      $cols[]  =$key;
      $th[]    =$value; 
   }

   if($co==2){
      $count= count_rows($table,$condition);
      echo "<td>$count</td>";
   }else{
      $count= count_rows($table,$condition);

      $query="
      SELECT   ".implode(',',$cols)." 
      FROM     $table 
      WHERE    $condition 
      ORDER BY $orderby
      ";

      $result  = mysql_query($query, $GLOBALS['CONNECTION']);
      echo "<table border=1 class=clean>\n<tr><th colspan=".sizeof($cols).">$title ($count)</th></tr>\n";
      echo "<tr><th>".implode('</th><th>',$th)."</th></tr>\n";
       while($row = @ mysql_fetch_array($result)){
         echo "<tr>\n";
         foreach($cols as $col){
            echo "<td class=color".find_repeat($examid,$row['indexno']).">".$row[$col]."</td>\n"; 
         }
         echo "</tr>\n";
      }
      echo "</table>\n";
   }
   return $count;
}


echo "
<table class=data_table ><tr><td class='data round' >
<div class=data style='border:0px;'>
";

$condition="examid='$examid' AND courseid='$courseid'";
$medical=null;
if($summery){
   echo "<table class=clean border=1><tr><th>All</th><th>Repeat</th><th>Absent</th><th>Pass</th><th>Fail</th></tr><tr>";
   $all     =2;
   $repeat  =2;
   $absent  =2;
   $fail    =2;
   $pass    =2;
   $stat    =1;
}

if($all){
   print_table($table,$cols,$condition,"final","All",$all);
}

if($repeat){
   print_table($table,$cols,$condition." AND indexno NOT LIKE '".find_repeat($examid,false)."%'","indexno DESC","Repeaters",$repeat);
}
if($absent){
   print_table($table,$cols,$condition." AND (final='ab') ","final","Absent",$absent);
}
if($medical){
   print_table($table,$cols,$condition." AND (final='mc') ","final","Absent",$medical);
}
if($fail){
   print_table($table,$cols,$condition." AND marks3 < 50","marks3 DESC","Fail",$fail);
}
if($pass){
   print_table($table,$cols,$condition." AND marks3 >= 50","marks3 DESC",'Pass',$pass);
}
if($stat){
   $cols=array("max(marks3)"=>"Max","min(marks3)"=>"Min","avg(marks3)"=>"Avg","std(marks3)"=>"Std");
   print_table($table,$cols,"examid='$examid' AND courseid='$courseid'","indexno","Statistics",$stat);
}

if($summery){
   echo "</tr></table>";
}

echo "</div></td><td class='data round'>";
echo "<div class=data style='border:0px;'>a";
echo "</div></td></tr></table>";
?>

</body>
</html>

