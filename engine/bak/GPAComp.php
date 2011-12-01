<?php
session_start();

//include('commonFunctions.php');
include('examData.php');

include_once("commonHTML.php");
include_once("database.php");
$conn = openDB();

$link_id = openDB();
$gpv = getAFileName("gpv");

HTML_header("GPA Computation");
get_batches("GPAComp.php");

if(isset($_GET['Batch'])){
   echo '<h2 align="center">Processing Results</h2>';

   $BatchId = $_GET['Batch'];
   $stname = getAFileName("student");
   $query = "select  IndexNo from ". $stname . " where Batch = '$BatchId' order by IndexNo";

   echo '<table border="1">';
   $i = 0;

   $result = mysql_query($query, $link_id);
   $row = mysql_fetch_array($result);

   print_table_titles();


   while($row){
      $IndexNo = $row['IndexNo'];
       
      $Grades = GetStudentGrades($link_id,$IndexNo);
      AddTablRows($Grades,$IndexNo,$link_id);
      //print_r($Grades);
      echo "<tr>";
      echo "<td>$IndexNo</td>";
       
      for($i = 1; $i < 5 ; $i++){
         if(isset($Grades[$i]['Courses'])){
            $TC = $Grades[$i]['TCredits'];
            $DGVP = $Grades[$i]['DTGPV'];
            $CGVP = $Grades[$i]['CTGPV'];
            $DGVA = $Grades[$i]['DGPA'];
            $CGVA = $Grades[$i]['CGPA'];

            echo "<td>$TC</td>";
            echo "<td>$DGVA</td>";
            echo "<td>$CGVA</td>";
         } else {
            echo "<td>--</td>";
            echo "<td>--</td>";
            echo "<td>--</td>";
         }
      }
       
       
      if($Grades['CreditsT'] >0){
         $GTC = $Grades['CreditsT'];
         $GDGVA = $Grades['DGPVA'];
         $GCGVA = $Grades['CGPVA'];
         echo "<td>$GTC</td>";
         echo "<td>$GDGVA</td>";
         echo "<td>$GCGVA</td>";
      } else {
         echo "<td>--</td>";
         echo "<td>--</td>";
         echo "<td>--</td>";
          
      }
      echo "</tr>";

      $row = mysql_fetch_array($result);

   }

   echo "</table>";
   echo "<h2> GPA Computation done </h2>";
}
echo '</body>';
echo '</html>';


function print_table_titles(){
   echo "<tr>";
   echo "<td></td>";
   echo "<td colspan=3>Year 1</td>";
   echo "<td colspan=3>Year 2</td>";
   echo "<td colspan=3>Year 3</td>";
   echo "<td colspan=3>Year 4</td>";
   echo "<td colspan=3>Final</td>";

   echo "</tr>";

   echo "<tr>";
   echo "<td>IndexNo</td>";
   echo "<td>Credits</td><td>DGPA</td><td>CGPA</td>";
   echo "<td>Credits</td><td>DGPA</td><td>CGPA</td>";
   echo "<td>Credits</td><td>DGPA</td><td>CGPA</td>";
   echo "<td>Credits</td><td>DGPA</td><td>CGPA</td>";
   echo "<td>Credits</td><td>DGPA</td><td>CGPA</td>";

   echo "</tr>";
}
?>

