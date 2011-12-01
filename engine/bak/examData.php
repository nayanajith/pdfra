<?php
include_once("database.php");

$GradeGpv =  array(
   "A+"=>4.25,"A"=>4.00,"A-"=>3.75,
   "B+"=>3.25,"B"=>3.00,"B-"=>2.75,
   "C+"=>2.25,"C"=>2.00,"C-"=>1.75,
   "D+"=>1.25,"D"=>1.00,"D-"=>0.75,
   "E"=>0.00,"ab"=>0.00,"AB"=>0.00,
   "NC"=>0.00,"NR"=>0.00,"mc"=>0.00,
   "MC"=>0.00);

$EGrades =  "'A+','A','A-','B+','B'";

//$gpv ="gpv";

function comGrade($Mark){
$Grade = "NN";
if ($Mark < 20) {
    $Grade = "E";
} elseif ($Mark < 30) {
    $Grade = "D-";
} elseif ($Mark < 40) {
    $Grade = "D";
}elseif ($Mark < 45) {
    $Grade = "D+";
}elseif ($Mark < 50) {
    $Grade = "C-";
}elseif ($Mark < 55) {
    $Grade = "C";
}elseif ($Mark < 60) {
    $Grade = "C+";
}elseif ($Mark < 65) {
    $Grade = "B-";
}elseif ($Mark < 70) {
    $Grade = "B";
}elseif ($Mark < 75) {
    $Grade = "B+";
}elseif ($Mark < 80) {
    $Grade = "A-";
}elseif ($Mark < 90) {
    $Grade = "A";
}elseif ($Mark < 101) {
    $Grade = "A+";
}


return $Grade;

}

function init_array(&$Grades){
   $Grades['CreditsT']= 0;
   $Grades['DGPVT']= 0;
   $Grades['CGPVT']= 0;
   $Grades['TotalCredits']= 0;

    for($i=1; $i < 5; $i++){
      $Grades[$i]["DTGPV"] = 0;
      $Grades[$i]["CTGPV"] = 0;
      $Grades[$i]["TCredits"] = 0;
      $Grades[$i]["DGPA"] = 0;
      $Grades[$i]["CGPA"] = 0;
      $Grades[$i]["SubIds"] = array();
   }
}

function GetStudentGrades($conn,$IndexNo){
    global $GradeGpv;
    $Grades = array();
   
   init_array($Grades);
   $Marks = getAFileName("marks");
   $Courses = getAFileName("courses");
    $query = "select m.RId RId,m.IndexNo IndexNo,c.CourseId CourseId,c.SYear Year,m.Final Final,c.Credits_L + c.Credits_P Credits,c.GPACon GPACon from ". $Marks." m,". $Courses ." c where m.IndexNo = '$IndexNo' and m.CourseId = c.CourseId order by CourseId,ExamId";
    //echo $query;
    $result = mysql_query($query, $conn);

    while($row = @ mysql_fetch_array($result)){
     if($row['Final'] != "NA"){
           fill_array($Grades,$row); 
     } 
   }
      //Compute Year GPV
   for($i=1; ($i < 5),isset($Grades[$i]['Courses']); $i++){
         // compute Degree and Class GPV
       $DGPV = array();
       $CGPV = array();
       
       foreach ($Grades[$i]['GPV'] As $c => $gpvs){
           $agds = explode(",",$gpvs);
           if (count($agds) > 1){
            //echo $c . ":" . $Grades[$i]['Grades'][$c] . ":" . $Grades[$i]['GPV'][$c] . " <BR>";
           // remove "MC" grade from computations
              
            $agds = array();
            $gdsT1 = explode(",",$Grades[$i]['Grades'][$c]);
            $gdsT2 = explode(",",$Grades[$i]['GPV'][$c]);
            foreach ($gdsT1 As $I1 => $V1){
              if ( strtoupper($V1) != "MC"){
               $agds[] = $gdsT2[$I1];
             }
            }
           // print_r($agds) . "<br>";
            
            $GPVMax = max($agds);
            $DGPV[$c] = $GPVMax;
            $CGPV[$c] = $GPVMax;
            
            if (count($agds) > 1){
               $ClassMax = $Grades[$i]['Courses'][$c] * 2.0;
            
               if($GPVMax > $ClassMax){
                  $CGPV[$c] = $ClassMax;
               }
            }
         } else {
            $DGPV[$c] = $agds[0];
            $CGPV[$c] = $agds[0];
         }  
        
       }
       
        if(isset($Grades[$i]['Courses'])){
         $Grades[$i]['TCredits'] = array_sum($Grades[$i]['Courses']);
         $Grades[$i]['DTGPV'] = array_sum($DGPV);
         $Grades[$i]['CTGPV'] = array_sum($CGPV);
           $Grades['CreditsT'] += $Grades[$i]['TCredits'];
         $Grades['DGPVT'] += $Grades[$i]['DTGPV'];
          $Grades['CGPVT'] += $Grades[$i]['CTGPV'];

         if($Grades[$i]['TCredits'] != 0){
               $Grades[$i]['DGPA'] = round(($Grades[$i]['DTGPV']/$Grades[$i]['TCredits']),2);
            $Grades[$i]['CGPA'] = round(($Grades[$i]['CTGPV']/$Grades[$i]['TCredits']),2);
           } else {
              $Grades[$i]['DGPA'] = 0;
            $Grades[$i]['CGPA'] = 0;

        }
       } else {
         $Grades[$i]['TCredits'] = 0;
         $Grades[$i]['DTGPV'] = 0;
         $Grades[$i]['CTGPV'] = 0;
         
       }
   } 
      
   
   if($Grades['CreditsT'] >0 ){
      $Grades['DGPVA'] = round(($Grades['DGPVT']/$Grades['CreditsT']),2);
      $Grades['CGPVA'] = round(($Grades['CGPVT']/$Grades['CreditsT']),2);
   } else {
      $Grades['DGPVA'] = 0;
      $Grades['CGPVA'] = 0;
   }
   
   //print_r($Grades);
    return $Grades;
}

function validGrades($var){
   return ( strtoupper($var) != 'MC');
}

function  fill_array(&$Grades,&$row){
      global $GradeGpv;
      
       $y = trim($row['Year']);
      $c = trim($row['CourseId']);
       $g = trim($row['Final']);
      $w = $row['Credits'];
      $RId = $row['RId'];
     
    $Grades[$y]['GPACon'][$c] = "Y";
    if((isset($row['GPACon'])) && ($row['GPACon'] == 'N')){
        $w = 0;
       $Grades[$y]['GPACon'][$c] = "N";
     }
      
      if(isset($GradeGpv[$g])){
         $gpv = $GradeGpv[$g] * $w;
      } else {
         $gpv = 0;
      }

     // if(!array_search($c, $Grades[$y]['SubIds'])){ 
      if(!in_array($c, $Grades[$y]['SubIds'])){ 
          $Grades[$y]['SubIds'][] = $c;
      }
      
      $Grades[$y]['Courses'][$c] = $w;
      if(isset($Grades[$y]['Grades'][$c])){
          if($g == 'NR'){
           $Grades['Tag'] = 'NR';
         }
          $Grades[$y]['Grades'][$c] .= "," .$g;
        //  $Grades[$y]['RId'][$c] .= "," . $RId;
         $Grades[$y]['GPV'][$c] .= "," . $gpv;
      } else {
          $Grades[$y]['Grades'][$c] = $g;
          $Grades[$y]['RId'][$c] = $RId;
         $Grades[$y]['GPV'][$c] = $gpv;
         $Grades['TotalCredits'] += $row['Credits'];

      }
}

function AddTablRows(&$Grades,$IndexNo,$conn){
   global $gpv;
   //  if($IndexNo == 'A0087'){
    //  print_r($Grades);
    //}
   
    //print_r($Grades);
   
    $query ="delete from $gpv where IndexNo ='$IndexNo'";  
    mysql_query($query, $conn);
   
   $C1 ="D";
   $C2 = "C";
   /*
   if($Grades['DGPVA'] != $Grades['CGPVA']){
     $C1 ="D";
     $C2 = "C";
   }
   */
    $query ="insert into $gpv (IndexNo,Tag,GPV1,Credits1,GPA1,GPV2,Credits2,GPA2,GPV3,Credits3,GPA3,GPV4,Credits4,GPA4,GPVT,CreditsT,GPAT,Comments) values('" .$IndexNo ."','". $C1. "',";  
    $query = $query .$Grades[1]["DTGPV"]. ",". $Grades[1]["TCredits"].",". $Grades[1]["DGPA"] .",";
    $query = $query .$Grades[2]["DTGPV"]. ",". $Grades[2]["TCredits"].",". $Grades[2]["DGPA"] .",";
    $query = $query .$Grades[3]["DTGPV"]. ",". $Grades[3]["TCredits"].",". $Grades[3]["DGPA"] .",";
    $query = $query .$Grades[4]["DTGPV"]. ",". $Grades[4]["TCredits"].",". $Grades[4]["DGPA"] .",";
    $query = $query . $Grades['DGPVT'] . "," . $Grades['CreditsT'] . "," . $Grades['DGPVA'] . ",'xx')";
   //echo $query;
    mysql_query($query, $conn);
   
   if( $Grades['DGPVA'] != $Grades['CGPVA']){
     $query ="insert into $gpv (IndexNo,Tag,GPV1,Credits1,GPA1,GPV2,Credits2,GPA2,GPV3,Credits3,GPA3,GPV4,Credits4,GPA4,GPVT,CreditsT,GPAT,Comments) values('" .$IndexNo ."','".$C2. "',";  
    $query = $query .$Grades[1]["CTGPV"]. ",". $Grades[1]["TCredits"].",". $Grades[1]["CGPA"] .",";
    $query = $query .$Grades[2]["CTGPV"]. ",". $Grades[2]["TCredits"].",". $Grades[2]["CGPA"] .",";
    $query = $query .$Grades[3]["CTGPV"]. ",". $Grades[3]["TCredits"].",". $Grades[3]["CGPA"] .",";
    $query = $query .$Grades[4]["CTGPV"]. ",". $Grades[4]["TCredits"].",". $Grades[4]["CGPA"] .",";
    $query = $query . $Grades['CGPVT'] . "," . $Grades['CreditsT'] . "," . $Grades['CGPVA']. ",'xx')";
    mysql_query($query, $conn);
   }
   
}
?>
