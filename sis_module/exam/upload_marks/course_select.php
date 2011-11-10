<?php
include 'config.php';
include 'common.php';


$examiner="Mr GKA Dias";
openDB();
$query="
SELECT 	c.courseid,c.coursename,e.examiner1,e.examiner2
FROM 
courses AS c,examiners AS e 
WHERE 	c.courseid = e.id 
AND 	( e.examiner1 = '$examiner' OR e.examiner2 = '$examiner')";

$result = mysql_query($query,$CONNECTION);

$select1="";
$select2="";
$select="";
$selectex="<option value=1 >1</option><option value=2 >2</option>";

$courseid=$_GET['courseid'];
$coursename=$_GET['coursename'];
$exid=$_GET['exid'];


while ($row = mysql_fetch_array($result)) {
	$id=$row['courseid'];
	$title=$row['coursename'];
	$match=$courseid;
	//echo "<input type=hidden value='$title' name=coursename>";
	if ($row['examiner1']==$examiner) {
		$select1.=($id == $match)?
		"<option selected=selected title='$title' value='$id'>$id</option>":
		"<option title='$title'  value='$id'>$id</option>";
	}elseif ($row['examiner2']==$examiner){
		$select2.=($id == $match)?
		"<option selected=selected title='$title'  value='$id'>$id</option>":
		"<option title='$title'  value='$id'>$id</option>";
	}
}

$select=$select1;
if ($exid==2) {
	$select=$select2;
	$selectex="<option value=1 >1</option><option value=2 selected=selected>2</option>";
}

$selectexam="";
$examid=$_GET['examid'];

if(!empty($courseid)){
	$query2="
SELECT 	DISTINCT examid	
FROM	csmarks 	
WHERE 	courseid = '$courseid'
ORDER	BY examid DESC
";

	$result = mysql_query($query2,$CONNECTION);

	while ($row = mysql_fetch_array($result)) {
		$id=$row['examid'];
		$match=$examid;
		$exam=exam_detail($id);
		//$title="Year:".$exam['ac_year']." Examination:".$exam['ex_year']." Semester:".$exam['semester'];
		$title=$exam['ex_year'];
		$selectexam.=($id == $match)?
	"<option selected=selected title='$id' value='$id'>$title</option>":
	"<option title='$id' value='$id'>$title</option>";
	}
}
echo "
 <script>
 function ex_change(eid){

 document.getElementById('examid').innerHTML='';
 obj=document.getElementById('courseid');
 switch(eid){
 case '1':
 obj.innerHTML=\"$select1\";
 break;
 case '2':
 obj.innerHTML=\"$select2\";
 break;
 }
 }
 </script>
 <form action='' name='frm_course_select'>
 <select name=exid id=exid onchange='ex_change(this.value)'>
 $selectex
 </select>

 <select name=courseid id=courseid onchange='frm_course_select.submit();'>
 $select
 </select>

 <select name=examid id=examid onchange='frm_course_select.submit()'>
 $selectexam
 </select>

 <input type=submit value=load>
 </form>
 ";
echo "<a href='DB_xml.php?exid=$exid&courseid=$courseid&examid=$examid'>Download</a>";
 if(!empty($courseid) && !empty($examid)){
 	$query3="
SELECT 	indexno,marks1,marks2,marks3,final,adjustment
FROM	csmarks 	
WHERE 	courseid = '$courseid'
AND		examid	 = '$examid'
ORDER	BY indexno DESC
";

 	$result = mysql_query($query3,$CONNECTION);
 	closeDB();
 	echo "<table border=1 style='border-collapse:collapse'>";
 	echo "<tr>";
 	foreach (mysql_fetch_array($result) as $key => $value) {
 		if(!(int)$key)
 		echo "<th>$key</th>";
 	}
 	echo "</tr>";
 	while ($row = mysql_fetch_array($result)) {
 		echo "<tr>";
 		foreach ($row as $key => $value) {
 			if(!(int)$key)
 			echo "<td>$value</td>";
 		}
 		echo "</tr>";
 	}
 	echo"</table>";

 }
