<?php
session_start();
include_once 'config.php';
include_once 'common.php';

$examiner="Mr GKA Dias";

$courseid=$_GET['courseid'];
$coursename=$_GET['coursename'];
$exid=$_GET['exid'];
$examid=$_GET['examid'];

openDB();

if(!empty($courseid) && !empty($examid)){
   $query3="
SELECT    indexno,marks1,marks2,marks3,final,adjustment
FROM   csmarks    
WHERE    courseid = '$courseid'
AND      examid    = '$examid'
ORDER   BY indexno DESC
";

   $result = mysql_query($query3,$CONNECTION);
   closeDB();

   /*DB to XML*/
   $cols=$GLOBALS['columns_map'];
   $marksXML = new SimpleXMLElement("<marks></marks>");
   $marksXML->addAttribute('user', $_SESSION['username']);
   $marksXML->addAttribute('course', $courseid);
   while ($row = mysql_fetch_array($result)) {
      $rowx = $marksXML->addChild('student');
      foreach ($cols as $key => $value) {
         $rowx->addAttribute($value, $row[$key]);
      }
   }

   /*Saving data to xml*/
   $xml_marks=xml_marks();
   $file_handler = fopen($xml_marks, 'w') or die("can't open file:".$xml_marks);
   fwrite($file_handler,$marksXML->asXML());
   fclose($file_handler);
}
echo "<a href='report.php?exid=$exid&courseid=$courseid&examid=$examid'>Download</a>";
function print_xml($xml){
   $cols=array("INDEX_NO"=>"","PAPER"=>"","ASSIGNMENT"=>"","FINAL"=>"","GRADE"=>"","PUSH"=>"");
   $xml=null;
   $index_no   ="";
   $paper       ="";
   $assignment   ="";
   $push         ="";

   $xml = simplexml_load_file($xml);
   $rows=sizeof($xml->student);
   echo "<table><tr>";
   foreach ($cols as $key => $value) {
      echo "<th>$key</th>";
   }
   echo "</tr>";
   if($rows){
      for ($i=1; $i<$rows; $i++){
         /*Reading data from xml*/
         echo "<tr>";
         if($xml){
            foreach($xml->student[$i-1]->attributes() as $attribute => $value) {
               $cols[$attribute]=$value;
               echo "<td>$value</td>";
            }
         }

         echo "<tr>";
      }
      echo "</table></div>";
   }
}
?>
