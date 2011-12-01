<?php
//session_start();
//session_start();
//phpinfo();

//include('commonFunctions.php');
include('examData.php');

include_once("commonHTML.php");
include_once("database.php");
$link_id = openDB();
$gpv = getAFileName("gpv");
$student = getAFileName("student");

HTML_header("GPA of a Batch");

get_batches("GPAAllStudents2_l.php");
echo "<a href='".$_SERVER['REQUEST_URI']."&order=indexno'>Order by index</a>";
echo "
<style>
table,td,tr{
border-collapse:collapse;
font-size:12px;
font-weight:bold;
}
a{
color:black;
}
</style>
";

$error=array(
"NA",
"<span style='color:yellow'>1<sup>st</sup> year Cretdits &lt 30</span>",
"<span style='color:orange'>2<sup>nd</sup> year Cretdits &lt 30</span>",
"<span style='color:blue'>3<sup>rd</sup> year Cretdits &lt 22</span>",

"1<sup>st</sup> Class",//4
"2<sup>nd</sup> Class U", //5
"2<sup>nd</sup> Class L", //6
"Pass", //7

"<span style='color:red'>DGPVA &lt 2.0</span>",

"<span style='color:#00FF00'>ENH1001 NC</span>",
"<span style='color:green'>SCS3026 GPV < 2.0</span>"
);


function print_error($errors,$error){
   $er="";
   foreach ($errors as $value) {
      $er.=$error[$value]."<br/>";
   }
   return $er;
}


if(isset($_GET['Batch'])){
   $Batch = $_GET['Batch'];
   echo "<table border=\"1\">";
   echo "<tr>";
   echo "<td></td>";
   echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Index No</td>";
   echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Name</td>";
   echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Res Type</td>";
   for($i=1; $i < 5 ; $i++){
      echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">GPV($i)</td>";
      echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Credits($i)</td>";
      echo "<td bgcolor=\"#99FFCC\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">GPA($i)</td>";
   }
   echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">GPV(T)</td>";
   echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Credits(T)</td>";
   echo "<td bgcolor=\"#99FFCC\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">GPA</td>";
   echo "<td bgcolor=\"#99FFCC\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">STATE</td>";

   echo "</tr>";
    
   //$query = "select g.*,concat(s.Name,\" \",s.Initials,\" \",s.Title) Name from $student s,$gpv g where s.IndexNo = g.IndexNo and Batch = '$Batch' and g.Tag='D' order by g.GPAT DESC";
   //$query = "select g.*,concat(s.Name,\" \",s.Initials,\" \",s.Title) Name from $student s,$gpv g where s.IndexNo = g.IndexNo and Batch = '$Batch' and g.Tag='D' and GPV4>0 order by g.GPAT DESC";
   
   $query = "select g.*,concat(s.Name,\" \",s.Initials,\" \",s.Title) Name
   from $student s,$gpv g 
   where s.IndexNo = g.IndexNo and Batch = '$Batch' ";

   if($_GET['order']=='indexno'){
      $query.="order by ABS(s.indexno)";
   }else{
      $query.="order by ABS(g.GPAT) DESC,ABS(s.indexno)";
   }


   $resultS = mysql_query($query, $link_id);
   $IndexNo = "";
   $SNo = 0;
   while ($row = @ mysql_fetch_array($resultS)){
      $SNo++;
      if($row['Tag']=='D'){
         echo "<tr>";
      }else{
         echo "<tr style='background:silver;'>";
      }
      echo "<td>" . $SNo . "</td>";
      echo "<td>" . $row['IndexNo'] . "</td>";
      echo "<td>" . $row['Name'] . "</td>";
      echo "<td>" . $row['Tag'] . "</td>";
      for($i =3; $i < 15; $i++){
         echo "<td>" . $row[$i] . "</td>";
      }
      echo "<td>" . $row['GPVT'] . "</td>";
      echo "<td>" . $row['CreditsT'] . "</td>";
      echo "<td>" . round($row['GPAT'],2) . "</td>";
      echo "<td><a href='GPAStudent_l.php?IndexNo=". $row['IndexNo']."'>" . print_error(student_state($row['IndexNo'],$link_id),$error). "</a></td>";
      echo "</tr>";
   }
   echo "</table>";
}

echo '</body>';
echo '</html>';



//4,5,6,7 -> good
function student_state($indexno,$link_id){
   global $GradeGpv;

   $errorText="";
   $error=array();

   $Grades = GetStudentGrades($link_id,$indexno);

   if(($Grades[1]['TCredits'] < 30 ) || (strpos($Grades[1]['Grades']['ENH1001'],'CM') === FALSE)){
      //$errorText = "First year Not Complete<b>";
      if($Grades[1]['TCredits'] < 30){
         $error[]=1;
      }else{
         $error[]=9;
      }
   }
    
   if($Grades[2]['TCredits'] < 30 ){
      //$errorText = "Second year Not Complete<b>";
      $error[]=2;
   }
    
   $SCS3026ok = FALSE;
   $gradesT = explode(",",$Grades[3]['Grades']['SCS3026']);
   foreach($gradesT as $key=>$value){
      echo $GradeGpv[$value];
      if ($GradeGpv[$value] >= 2.0) {
         $SCS3026ok = TRUE;
      }
   }
   if(($Grades[3]['TCredits'] < 22 ) || (!$SCS3026ok)){
      //$errorText = "Third year Not Complete <b>";
      if($Grades[3]['TCredits'] < 22){
         $error[]=3;
      }else{
         $error[]=10;
      }
   }
    
   if(sizeof($error)==0){
      if($Grades['CGPVA'] >= 3.5){
         //$errorText = "Final Result : First Class<b>";
         $error[]=4;
      }elseif(($Grades['CGPVA'] >= 3.25) && ($Grades['CGPVA'] < 3.5)) {
         //$errorText = "Final Result : Second Class Upper Division<b>";
         $error[]=5;
      }elseif(($Grades['CGPVA'] >= 3.0) && ($Grades['CGPVA'] < 3.25)) {
         //$errorText = "Final Result : Second Class Lower Division<b>";
         $error[]=6;
      }elseif(($Grades['DGPVA'] >= 2.0) && ($Grades['CGPVA'] < 3.0)) {
         //$errorText = "Final Result : Pass<b>";
         $error[]=7;
      }elseif(($Grades['DGPVA'] < 2.0)){
         //$errorText = "Final Result : Fail<b>";
         $error[]=8;
      }
   }
   return $error;
}
?>


