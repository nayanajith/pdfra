<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);


include_once("../config.php");
include_once("../func/student_class.php");
opendb();
//$student = new Student("cs","07001071","2006/2007");
//$student = new Student("cs","06001289","2005/2006");
/*
 echo "<br/>1)";
 echo $student->printYearMarks(1);
 echo "<br/>1)";
 echo $student->printYearMarks(2);
 echo "<br/>1)";
 echo $student->printYearMarks(3);
 echo "<br/>2) ";
 echo $student->getRepeatMax('ENH1001');
 echo "<br/>3)";
 echo getCredits('SCS1002');
 echo "<br/>4)";
 echo $student->getYearCGPV(1);
 echo "<br/>5)";
 echo $student->getYearCGPV(2);
 echo "<br/>6)";
 echo $student->getYearCredits(1);
 echo "<br/>7)";
 echo $student->getYearCredits(2);
 echo "<br/>8)";
 echo $student->getYearCredits(3);
 echo "<br/>9)";
 echo $student->getCGPV();
 echo "<br/>10)";
 echo $student->getCGPA();
 echo "<br/>11)";
 echo $student->getDGPA();
 echo "<br/>12)";
 echo $student->getState($student->eligibility());
 echo "<br/>13)";
 $student->getDGrade('SCS1001');
 echo "<br/>14)";
 echo $student->getRegDate();
 echo "<br/>15)";
 echo $student->getName(4);
 echo "<br/>16)";
 */

/*
$query="SELECT DISTINCT indexno FROM csstudent WHERE batch='2004/2005'";
$result  = mysql_query($query, $GLOBALS['CONNECTION']);
while ($row = mysql_fetch_array($result)) {
	$student = new Student("cs",$row['indexno'],null);
	echo $row['indexno']."<br/>";
	echo "<pre>";
	echo print_r($student->push());
	echo "</pre>";
}
*/

$check=array(
"A0427",
"A1067",
"A1113",
"A1121",

"04000072",
"04000392",
"04000919",
"04000978",

"05000132",
"05000191",
"05000505",
"05000612",
"05000858",
"05001196",
"05001293",
"05001536",
"04000331",

"06000053",
"06000436",
"06000673",
"06000827",
"06000916",
"06000942",
"06001149",
"06001181",
"06001343",
"06001386"
);

/*
 foreach ($check as $indexno){
 echo $indexno;
 $student = new Student("cs",$indexno,null);
 //	echo $row['indexno']."->".$student->getDGPA()."<br/>";
 echo "<pre>";
 //echo $student->printYearMarks(3);
 echo print_r($student->push());
 //echo $student->getState($student->eligibility());
 //print_r($student->getTranscript());
 echo "</pre>";
 echo "<br/>";
 }
 */

/*
$student = new Student("cs",'06001386',null);
echo print_r($student->push());
*/
$student = new Student('07020572');
echo "<pre>";
print_r($student->getTranscript());
echo "</pre>";

closeDB();

?>
