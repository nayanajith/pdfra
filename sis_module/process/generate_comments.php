<?php
/*
--EXEL comment generation functions--

Repeat Modules:
=IF(BI5=0,"All Year 1",IF((P5+V5+AB5+AH5)=0,"All Semester 1",IF(P5=0,"IT1104","")&IF(V5=0,",IT1204","")&IF(AB5=0,",IT1304","")&IF(AH5=0,",IT1404",""))&IF((AN5+AT5+AZ5+BF5)=0,",All Semester 2",IF(AN5=0,",IT2104","")&IF(AT5=0,",IT2204","")&IF(AZ5=0,",IT2304","")&IF(BF5=0,",IT2404","")))&IF(BR5="WH"," (WH)","")&"."

Exam Comment-Part:
=IF(LEFT(C2,3)="BIT",C2,IF(BI2=8,IF(OR(LEFT(C2,1)="C",LEFT(C2,1)="D"),LEFT(C2,3)&" ("&RIGHT(C2,4)&").","Pass Year 1 Courses ("&IF(LEFT(D2,1)="2",D2,"2010")&")."),IF(BI2=7,"To Sit Course: ","To Sit Courses: ")&IF(LEFT(BS2,1)=",",RIGHT(BS2,LEN(BS2)-1),BS2)))

Exam Result:
=IF(LEFT(I2,1)="N","*","")&IF(OR(AND(BL2>=12,I2="R"),RIGHT(I2,2)="Y1"),"May Proceed to Year 2. ","")&IF(OR(RIGHT(I2,2)="Y2",RIGHT(I2,2)="Y3"),"Year "&RIGHT(I2,1)&". ","")&BT2

Year 1 Result:
=IF(AND(LEFT(BQ2,1)="B",LEFT(BX2,1)<>"E"),"---- ("&LEFT(BQ2,LEN(BQ2)-1)&").",IF(OR(LEFT(J2,1)="C",LEFT(J2,1)="D"),BT2,IF(AND(OR(LEFT(BV2,4)="Pass",LEFT(BV2,4)="Exem"),BI2=8),IF(RIGHT(I2,2)="Y2","Year 2. DIT ("&IF(RIGHT(BT2,4)>=RIGHT(BV2,4),LEFT(RIGHT(BU2,6),4),LEFT(RIGHT(BV2,6),4))&").",IF(RIGHT(I2,2)="Y3","Year 3. DIT ("&IF(RIGHT(BT2,4)>=RIGHT(BV2,4),LEFT(RIGHT(BU2,6),4),LEFT(RIGHT(BV2,6),4))&").","DIT ("&IF(RIGHT(BT2,4)>=RIGHT(BV2,4),LEFT(RIGHT(BU2,6),4),LEFT(RIGHT(BV2,6),4))&"). May Proceed to Year 2.")),BU2&" "&BV2)))

Comment:
=IF(BX2>=" ",BW2&" "&BX2,BW2)
*/
?>
<?php
include A_CLASSES."/student_class.php";
$student = new Student("0925561");
echo $student->getName(3);
$fail_array=array('F','E','AB','NS','D-','D','D+');
$comment="";
$count=0;
//TODO: check based on course database 
$year1_marks=$student->getYearMarks(1);
foreach($year1_marks as $course){
	if(in_array($course['grede'],$fail_array)){
		$comment.="To Sit ".$course['course_id'].", ";
		$count++;
	}
}
if($count == 8 ){
	echo "To Sit All Year1";
}else{
	echo $comment;
}

?>
