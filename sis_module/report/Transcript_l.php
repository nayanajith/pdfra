<?php
session_start();
include_once("database.php");
include('reports.php');
$link_id = opendb();	
$gpv 		= getAFileName("gpv");
$student = getAFileName("student");
   
function selectGpa($cgpa,$dgpa){
	$text="";
   if(($cgpa >= 3.0) && ($dgpa != $cgpa)){ 
		if($cgpa>4.0)
		{ 
			$text = "GRADE POINT AVERAGE :4.0" ;
	   }else{
			$text = "GRADE POINT AVERAGE :" . $cgpa;
	   }
	
	}else{
		if($dgpa>4.0)
		{ 
			$text = "GRADE POINT AVERAGE :4.0" ;
		}else{
			$text = "GRADE POINT AVERAGE :" . $dgpa;
   	}
  	}
	return $text; 
}

function getClass($gpa){
   $text="";
		if(sizeof($error)==0){
		if($gpa >= 3.5){
			$text = "First Class";
		}elseif(($gpa >= 3.25) && ($gpa < 3.5)) {
			$text = "Second Class(Upper Division)s";
		}elseif(($gpa >= 3.0) && ($gpa < 3.25)) {
			$text = "Second Class(Lower Division)";
		}elseif(($gpa >= 2.0) && ($gpa < 3.0)) {
			$text = "Pass";
		}elseif(($gpa < 2.0)){
			$text = "Pending";
		}
	}
	return $text;
}

function getDegree($indexno,$class){
	$query="";	
}

if(!empty($_GET['indexno'])){
  $indexno	=$_GET['indexno'];
  $query 	= "SELECT s.fullname AS fullname,s.dreg AS dreg,s.dgrad AS dgrad,g.gpat,g.tag AS gpa 
			 FROM $student AS s, $gpv AS g 
			 WHERE s.indexno='$indexno' AND s.indexno=g.indexno";
  echo $query;
  $result  	= mysql_query($query, $link_id);
  echo "<table>";
  while($row = mysql_fetch_array($result)){
	echo "<tr><td>Degree</td><td><input type=text name='fullname' id='fullname' value='".$row['fullname']."' size=80></td></tr>";
	echo "<tr><td>Full Name</td><td><input type=text name='fullname' id='fullname' value='".$row['fullname']."' size=80></td></tr>";
	echo "<tr><td>Date Of Admission</td><td><input type=text name='dreg' id='dreg' value='".$row['dreg']."'></td></tr>";
	echo "<tr><td>Date Of Award</td><td><input type=text name='dgrad' id='dgrad' value='".$row['dgrad']."'></td></tr>";
	echo "<tr><td>Class Obtained</td><td><input type=text name='status' id='status' value='".$row['gpa']."'></td></tr>";
  }
  echo "</table>";
}else{
?>
<form target="">
<label for='indexno'>Index No:</label><input type=text name='indexno' id='indexno'> 
<input type=submit name='view' id='view' value='view'> 
</form>
<?php

}

?>
