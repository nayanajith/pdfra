<?php
session_start();

include_once 'config.php';
if(isset($_SESSION['views']))
$_SESSION['views'] = $_SESSION['views']+1;
else
$_SESSION['views'] = 1;
$_SESSION['host']=$_SERVER['REMOTE_ADDR'];
//session_destroy();
?>

<?php
/*
openDB();
$result = mysql_query("SELECT DISTINCT EmpNo,Name FROM employee",$CONNECTION);
closeDB();

while($row = mysql_fetch_row($result)) {
   //echo "<option value='".$row[0]."'>".$row[1]."</option>";
}
*/

//@unlink($xml_marks);
//@unlink($xml_detail);


if (isset($_GET['rows'])){
   /*Generating xml from data*/
   $marksXML = new SimpleXMLElement("<marks></marks>");
   $marksXML->addAttribute('user', 'nayanajith');
   $rows=(int)$_GET['rows'];
   $cols=array(1=>"INDEX_NO",2=>"PAPER",3=>"ASSIGNMENT",8=>"PUSH");
   for ($i = 1; $i <= $rows; $i++) {
      $row = $marksXML->addChild('student');
      $row->addAttribute('id', $i);
      foreach ($cols as $key => $value) {
         $row->addAttribute($value, $_GET[$key.":".$i]);
      }
   }
   /*Saving data to xml*/
   $file_handler = fopen($xml_marks, 'w') or die("can't open file:".$xml_marks);
   fwrite($file_handler,$marksXML->asXML());
   fclose($file_handler);

   if (file_exists($xml_marks)){
      //$xml = simplexml_load_file($xml_marks);
      //var_dump($xml);
      echo "Marks uploaded.";
   }
}elseif(isset($_GET['detail']) && $_GET['detail'] == 'true') {
   $detailXML = new SimpleXMLElement("<detail></detail>");
   $detailXML->addAttribute('user', 'nayanajith');
   foreach ($_GET as $key => $value) {
      if ($key != 'detail') {
         $row = $detailXML->addChild($key);
         $row->addAttribute('value',$value);
      }
   }
   /*Saving details to file*/
   $file_handler = fopen($xml_detail, 'w') or die("can't open file:".$xml_detail);
   fwrite($file_handler,$detailXML->asXML());
   fclose($file_handler);

   if (file_exists($xml_detail)){
      //$xml = simplexml_load_file($xml_detail);
      //var_dump($xml);
      echo "Detail uploaded.";
   }
}elseif(isset($_GET['update_DB'])){
   $conn = openDB("courseadmin");
   $examiner1="Mr GKA Dias";
   $result = mysql_query("SELECT c.courseid,c.coursename,e.examiner1,e.examiner2 FROM courses AS c, examiners AS e WHERE c.courseid = e.id and e.examiner1 = '$examiner1'",$conn);
}

?>
