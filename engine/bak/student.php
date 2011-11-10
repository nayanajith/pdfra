<?php

include_once('common.php');



class Student{

	/*Array to hold index and batch*/
	protected $self   	= array();

	/*Calculate Grades from mark or use Calculated Grade*/
	protected $absGrade	= false;

	/*
	 * Print debug messages
	 */
	protected $DEBUG=false; //Turn ON and OFF debug messages
	public function debug($msg,$id,$color){
		if($this->DEBUG){
			echo "<span style='color:".$color."'>[".$id."]</span>".$msg."<br/>";
		}
	}

	/*Array to hold all the course data*/

	/*
	 courses= array(
	 -----'scs1001'=> array(
	 -----------'0911'=> array(
	 -----------------'marks1'=>55,
	 -----------------'marks2'=>55,
	 -----------------'marks3'=>55,
	 -----------------'final' =>c
	 ------------------),
	 ---------- '0811'=> array(
	 ------------------),
	 ------------),
	 -----),
	 );
	 */

	protected $courses= array();
	protected $regInfo= array();

	public function __construct($indexno=null) {

		$this->self['stream']   = 'cs';
		if(!isCS($indexno)){
			$this->self['stream']   = 'it';
		}
		$this->self['indexno']  = $indexno;
		$stream=$this->self['stream'];

		/*Related tables*/
		$this->self['marks']    = $stream."marks";
		$this->self['regist']   = $stream."student";
		$this->self['gpv']      = $stream."gpv";

		$this->loadRegData();
		$this->loadCourses();
	}

	public function getRegNo(){
		return $this->regInfo['RegNo'];
	}

	public function getIndex(){
		return $this->self['indexno'];
	}

	public function getBatch(){
		return $this->self['batch'];
	}

	/*
	 * Return students registration date
	 */
	public function getRegDate(){
		return $this->regInfo['dreg'];
	}

	/*
	 * Return full name of the user
	 */
	public function getName($cat){
		switch($cat){
			case 1:
				return $this->regInfo['Name']." ".$this->regInfo['Initials'];
				break;
			case 2:
				return $this->regInfo['fullname'];
				break;
			case 3:
				return $this->regInfo['Title']." ".$this->regInfo['Name']." ".$this->regInfo['Initials'];
				break;
			case 4:
				return $this->regInfo['Title']." ".$this->regInfo['fullname'];
				break;
			default:
				return $this->regInfo['fullname'];
		}
	}

	/*
	 * Return the query to set registration detail
	 */

	public function getRegQuery($set){
		$query	="UPDATE ".$this->self['regist']." SET ";
		$query   .=" ".$set." ";
		$query   .="WHERE IndexNo =".$this->getIndex();
		return $query;
	}

	/*
	 *Set name,initials,fullname,title of the student
	 */
	public function setName($name,$initials,$fullname,$title){
		$set="";
		if(!empty($name)|| $name != null){
			$set   .="Name='$name'";
		}elseif(!empty($initials)||$initials != null){
			$set   .="initials='$initials'";
		}elseif(!empty($fullname)||$fullname != null){
			$set   .="fullname='$fullname'";
		}elseif(!empty($title)||$title != null){
			$set   .="title='$title'";
		}
		$query   = $this->getRegQuery($set);
		echo $query;
		$this->debug("setName|query", $query, "red");

		$result  = execQuery($query, $GLOBALS['CONNECTION']);

		if(mysql_affected_rows($result)==0){
			return -1;
		}else{
			return 0;
		}
	}

	public function setRegDate($date){
		$index=$this->getIndex();
		$query   ="UPDATE ".$this->self['regist']." SET ";
		$query   .="";
		$query   .="WHERE indexno ='$index'";
		$result  = execQuery($query, $GLOBALS['CONNECTION']);
	}
	public function setDegDate($date){
		$index=$this->getIndex();
		$query   ="UPDATE ".$this->self['regist']." SET ";
		$query   .="WHERE indexno ='$index'";
		$result  = execQuery($query, $GLOBALS['CONNECTION']);
	}

	/*
	 * Return registered year
	 */
	public function getDegYear(){
		return $this->regInfo['dgrad'];
	}

	/*
	 * Return registered year
	 */
	public function getTitle(){
		return $this->regInfo['Title'];
	}

	/*
	 * Load students registration detail to the regInfo array to be used
	 */
	protected $validIndex=false;
	public function loadRegData(){
		$query   ="
      SELECT * 
      FROM ".$this->self['regist']."
      WHERE indexno ='".$this->self['indexno']."'";
		$result  = mysql_query($query, $GLOBALS['CONNECTION']);
		$this->regInfo = mysql_fetch_array($result);

		if($this->regInfo['IndexNo']==''){
			return false;
		}else{
			$this->validIndex=true;
		}
	}

	/*
	 * Check validity of the index no
	 */
	public function isValidIndex(){
		return $this->validIndex;
	}

	/*
	 Return Descriptive detailes to print the transcript
	 DEGREE :Bachelor of Science (Computer Science) with Honours
		YEAR OF ADMISSION :
		DATE OF AWARD :
		GRADE POINT AVERAGE :0
		CLASS OBTAINED :First Class(Honours)
	 */
	public function getTranscript(){
		global $descDegree;
		global $descClass;

		$transcript=array();
		$myGPA=$this->getCGPA();
		$myClass=$this->getClass($myGPA);

		$transcript['DOA']=$this->getDegYear(); //Date of Admission
		$transcript['YOA']=$this->getRegDate(); //Year of Award
		$transcript['GPA']=round($myGPA,2);		 //Grade Point Avarage
		//Selecting Descriptive degree and Descriptive class
		switch($this->getDegree().":".$myClass){
			//four year
			case '4:2L':
				$transcript['DEGREE']=$descDegree[0];  //Degree
				$transcript['CLASS']=$descClass[3];		//Class
				break;
			case '4:2U':
				$transcript['DEGREE']=$descDegree[0];
				$transcript['CLASS']=$descClass[2];
				break;
			case '4:1':
				$transcript['DEGREE']=$descDegree[0];
				$transcript['CLASS']=$descClass[0];
				break;
			case '4:P':
				$transcript['DEGREE']=$descDegree[1];
				$transcript['CLASS']=$descClass[4];
				break;
				//Three year
			case '3:2L':
				$transcript['DEGREE']=$descDegree[2];
				$transcript['CLASS']=$descClass[3];
				break;
			case '3:2U':
				$transcript['DEGREE']=$descDegree[2];
				$transcript['CLASS']=$descClass[2];
				break;
			case '3:1':
				$transcript['DEGREE']=$descDegree[2];
				$transcript['CLASS']=$descClass[1];
				break;
			case '3:P':
				$transcript['DEGREE']=$descDegree[3];
				$transcript['CLASS']=$descClass[4];
				break;
			default:
				$transcript['DEGREE']=$descDegree[4];
				$transcript['CLASS']=$descClass[5];
				break;
		}
		return $transcript;
	}

	/*
	 * Return Years of the degree (3,4) or the degree name if $descriptive is true
	 */
	public function getDegree(){
		$degreeYear=3;
		foreach($this->courses as $courseid => $course){
			if(courseYear($courseid)==4){
				$degreeYear=4;
				break;
			}
		}
		return $degreeYear;
	}

	/*
	 * Degreee state array
	 */
	protected $states=array(
	 "NA",//0
	 "<span style='color:yellow'>1<sup>st</sup> year Cretdits &lt 30</span>",//1
	 "<span style='color:orange'>2<sup>nd</sup> year Cretdits &lt 30</span>",//2
	 "<span style='color:blue'>3<sup>rd</sup> year Cretdits &lt 22</span>",//3

	 "1<sup>st</sup> Class",//4
	 "2<sup>nd</sup> Class U", //5
	 "2<sup>nd</sup> Class L", //6
	 "Pass", //7

	 "<span style='color:red'>DGPVA &lt 2.0</span>",//8

	 "<span style='color:#00FF00'>ENH1001 NC</span>",//9
	 "<span style='color:green'>SCS3026 GPV < 2.0</span>",//10
	 "<span style='color:green'>ICT3015 GPV < 2.0</span>"//11
	);

	/*
	 * Retrun description of the output of eligibility
	 */

	public function printState($st){
		$state_txt="";
		foreach ($st as $state)
		{
			$state_txt.= $this->states[$state]."<br/>";
		}
		return $state_txt;
	}


	/*
	 * Check the criteria to bel elligible to bye a fourth year student or
	 * to be awarded the degree
	 */
	public function getState(){
		$state=array();

		if(strtoupper($this->self['stream']) == 'CS'){
			if($this->getRepeatMax("ENH1001")==0 || strtoupper($this->getGrade("ENH1001",$this->getRepeatMax("ENH1001")))!='CM'){
				$state[]=9;
			}
			if(getGradeGpv($this->getGrade("SCS3026",$this->getRepeatMax("SCS3026")))<2.0){
				$state[]=10;
			}
		}else{
			if(getGradeGpv($this->getGrade("ICT3015",$this->getRepeatMax("ICT3015")))<2.0){
				$state[]=11;
			}
		}

		if($this->getYearCredits(1)<30){
			$state[]=0;
		}
		if($this->getYearCredits(2)<30){
			$state[]=1;
		}
		if($this->getYearCredits(3)<22){
			$state[]=2;
		}

		$cgpa=$this->getCGPA();
		if(sizeof($state)==0){
			if($cgpa >= 3.5){
				// "Final Result : First Class<b>";
				$state[]=4;
			}elseif(($cgpa >= 3.25) && ($cgpa < 3.5)) {
				//"Final Result : Second Class Upper Division<b>";
				$state[]=5;
			}elseif(($cgpa >= 3.0) && ($cgpa < 3.25)) {
				//"Final Result : Second Class Lower Division<b>";
				$state[]=6;
			}elseif(($cgpa >= 2.0) && ($cgpa < 3.0)) {
				//"Final Result : Pass<b>";
				$state[]=7;
			}elseif(($cgpa < 2.0)){
				//"Final Result : Fail<b>";
				$error[]=8;
			}
		}
		return $state;
	}

	public function fourthElig(){
		$state=1;
		if(strtoupper($this->self['stream']) == 'CS'){
			if($this->getRepeatMax("ENH1001")==0 || strtoupper($this->getGrade("ENH1001",$this->getRepeatMax("ENH1001")))!='CM'){
				$state=-1;
			}
			if(getGradeGpv($this->getGrade("SCS3026",$this->getRepeatMax("SCS3026")))<2.0){
				$state=-1;
			}
		}else{
			if(getGradeGpv($this->getGrade("ICT3015",$this->getRepeatMax("ICT3015")))<2.0){
				$state=-1;
			}
		}

		if($this->getYearCredits(1)<30){
			$state=-1;
		}
		if($this->getYearCredits(2)<30){
			$state=-1;
		}
		if($this->getYearCredits(3)<22){
			$state=-1;
		}
		return $state;
	}

	public function degEligi(){
		$state=1;
		if(strtoupper($this->self['stream']) == 'CS'){
			if($this->getRepeatMax("ENH1001")==0 || strtoupper($this->getGrade("ENH1001",$this->getRepeatMax("ENH1001")))!='CM'){
				$state=-1;
			}
			if(getGradeGpv($this->getGrade("SCS3026",$this->getRepeatMax("SCS3026")))<2.0){
				$state=-1;
			}
		}else{
			$ict1007=strtoupper($this->getGrade("ICT1007",$this->getRepeatMax("ICT1007")));
			$ict1008=strtoupper($this->getGrade("ICT1008",$this->getRepeatMax("ICT1008")));
			$ict1016=strtoupper($this->getGrade("ICT1016",$this->getRepeatMax("ICT1016")));
			if(
			getGradeGpv($this->getGrade("ICT3015",$this->getRepeatMax("ICT3015")))<2.0 &&
			($ict1007=='AB'|| $ict1007=='MC'||$ict1008=='AB'||$ict1008=='MC'||$ict1016=='AB'||$ict1016=='MC')){
				$state=-1;
			}
		}

		if($this->getYearCredits(1)<30){
			$state=-1;
		}
		if($this->getYearCredits(2)<30){
			$state=-1;
		}
		if($this->getYearCredits(3)<22){
			$state=-1;
		}
		return $state;
	}

	/*
	 * Classes for GPA
	 */
	protected $classes=array("P"=>2,"2L"=>3,"2U"=>3.25,"1"=>3.5);

	public function getClass($GPA){
		$gpa=$GPA;

		if(!$gpa){
			$mycgpa=$this->getCGPA();
			$mydgpa=$this->getDGPA();

			$gpa=$mydgpa;
			//Choose from degree gpa and class gpa
			if($mydgpa >=$this->classes['P'] && $mycgpa < $mydgpa){
				$gpa=$mycgpa;
			}
		}
		$this->debug($gpa, $this->getIndex(), 'red');
		if($gpa <2){
			return -1;
		}elseif($gpa <3){
			return array_search(2,$this->classes);
		}elseif($gpa <3.25){
			return array_search(3,$this->classes);
		}elseif($gpa <3.5){
			return array_search(3.25,$this->classes);
		}else{
			return array_search(3.5,$this->classes);
		}
	}

	/*
	 * Suggesting the students who can be pushed to a higher class  or push to
	 * be eligible to pass
	 */
	public function push(){
		//The next GPA which the student should be pushed
		$nextGPA			=0;
		//The GPA which the student should obtained just to pass the Degree
		$minDegreeGPA	=2;
		//Maximum push for a class
		$classPush		=5;
		//Maximus Push for a degree
		$degreePush		=10;
		$isDegreePush	=false;
		//My GPV can either be my CGPV or my DGPV
		$myGPV			=0;

		//The grades which gives higher jump whiel changing the grade (0.5)
		$maxJumps		=array("D+","C+","B+");

		$myCGPV			=$this->getCGPV();
		$myCGPA			=$this->getCGPA();
		$myDGPV			=$this->getDGPV();
		$myDGPA			=$this->getDGPA();


		/*
		 * Finding next closed GPA and suitable GPV for calculations (to just pass
		 * or to upgrade in class)
		 */
		if($myDGPA < 2){
			$nextGPA	=$minDegreeGPA;
			$myGPV	=$myDGPV;
			$myGPA	=$myDGPA;
			$maxPush	=$degreePush;
			$isDegreePush	=true;
		}else{
			$maxPush	=$classPush;
			$myGPV	=$myCGPV;
			$myGPA	=$myCGPA;
			foreach ($this->classes as $class => $gpa){
				if($gpa-$myCGPA > 0){
					$nextGPA	=$gpa;
					break;
				}
			}
		}

		$this->debug($isDegreePush, "Degree push","red");
		$this->debug($maxPush, "Max GPV Push","red");
		$this->debug($nextGPA, "Next GPA","red");

		//Finding total credits available from the courses done
		$credits=0;
		for($i=1;$i<5;$i++){
			$credits+=$this->getYearCredits($i);
		}

		$this->debug($credits, "Total Credits","red");
		//Total GPV that should obtain to get next closed GPA
		$nextGPV	=$credits*$nextGPA;

		//GPV difference
		$GPVDiff	=$nextGPV-$myGPV;
		if($GPVDiff<0){
			//GPA could not push
			$this->debug($myGPA, "FIRST CLASS","blue");
			return;
		}

		if($GPVDiff > $maxPush){
			//Not possible to push
			$this->debug($GPVDiff,"Cannot try GPVDIFF","green");
			return false;
		}

		$this->debug($GPVDiff,"Can try GPVDIFF","red");


		//Array to hold the adjustment marks to raech next grade
		$pushMarksCourses	=array(
		/*'SCS1001'=>markPush*/
		);

		$pushGPVCourses	=array(
		/*'SCS1001'=>GPVPush*/
		);

		/*
		 * Calculating the marks whch can be pushed for each subject and their out
		 * come grade incriments to be selected afterword
		 */
		foreach($this->courses as $courseid => $course){
			//Students actual marks for the particular course
			$examid=$this->getRepeatMax($courseid);
			$mymark=$this->getMark($courseid,$examid);

			//Reduce previous push from max push
			$myPreviousePush=$mymark[1];
			if($myPreviousePush>0){
				$maxPush-=$myPreviousePush;
				$this->debug($myPreviousePush, "Previous push:".$courseid,"blue");
			}

			//Selecting 3rd year subjects if this is class push and not noneGrade and not nonCredit and not previousely pushed
			//Selecting all year subjects if this is degree push and not noneGrade and not nonCredit and not previousely pushed

			if(( $isDegreePush || courseYear($courseid)==3 )&& strtoupper($this->getGrade($courseid, $examid))!= 'AB' && !isNoneGrade($courseid) && !isNoneCredit($courseid) && $myPreviousePush==0){
				global $minGradeMark; //from common.php
				$nextMark=0;

				//Finding the adjesent next mark of the particular course which can be pushed
				foreach ($minGradeMark as $grade => $mark){
					if(($mark-$mymark[0]) > 0 && ($mark-$mymark[0])<=$maxPush){
						$nextMark=$mark;
						break;
					}
				}
				$this->debug($nextMark, $courseid,"blue");

				if($nextMark!=0){ //Ignore courses which can not be pushed with maxPush
					$markPush=$nextMark-$mymark[0]; // Possible push of marks for particular course
					//Ammont of GPV push coucl be obtained after pushing the course by above marks
					$GPVPush	=(getGradeGpv(getGradeC($nextMark))-getGradeGpv(getGradeC($mymark[0])))*getCredits($courseid);

					if(!($markPush==5 && $GPVPush < $GPVDiff)){//Ignore pushes which can not obtain required GPV push wiht pushing maxMarks
						$pushMarksCourses[$courseid."@".$examid]	=$markPush; //Filling mark Push Array
						$pushGPVCourses[$courseid."@".$examid]		=$GPVPush;	//Filling GPV push Array
					}
				}
			}
		}

		// Sort GPV Push array and Mark Push array  to choose the most efficient one
		asort($pushMarksCourses);
		asort($pushGPVCourses);

		//Generate all possible combinations of courses which can be used to push the studnt
		$combinations = array(array( ));
		foreach ($pushGPVCourses as $element => $mark){
			foreach ($combinations as $combination){
				array_push($combinations, array_merge(array($element), $combination));
			}
		}

		//Soltion candidate array.. This will filled after calculating marks for each combinations and filtering
		$solCandidates=array();

		//Filtering the valid candidate combinations
		foreach ($combinations as  $combination){
			$pushSum=0;
			$markSum=0;
			foreach ($combination as $courseS){
				$pushSum+=$pushGPVCourses[$courseS];
				$markSum+=$pushMarksCourses[$courseS];
			}
			if($pushSum >= $GPVDiff && $markSum <= $maxPush){
				$this->debug($pushSum, implode(",", $combination), "yellow");
				$solCandidates[implode(",", $combination)]=$pushSum;
			}
		}

		//Sort the candidate combinations to get the most efficient one
		if(sizeof($solCandidates)>0){
			asort($solCandidates);
		}else{
			$this->debug("0","No candidate combinations found", "red");
			return ;
		}

		//Choose the best solution from the candidate solutions, whcih to be returned
		$minPush=-1;
		$minMark=5;
		$solution=null;
		foreach ($solCandidates as  $candidate => $mark){
			$tmpSolution=null;
			$markCourses=explode(",",$candidate);
			$markSum=0;
			$solString="";
			foreach ($markCourses as $courseS ){
				$course = explode('@', $courseS);
				$markSum+=$pushMarksCourses[$courseS];

				$courseid	=$course[0];
				$examid		=$course[1];
				$markP		=$pushMarksCourses[$courseS];
				$gradeP		=$pushGPVCourses[$courseS];
				$tmpMark		=$this->getMark($courseid, $examid);
				$myMark		=$tmpMark[0];
				$nextMark	=$myMark+$markP;
				$myGrade		=$this->getGrade($courseid,$examid);
				$nextGrade	=getGradeC($nextMark);

				$solString.=$courseid.":".$examid.":".$markP.":".$gradeP.":".$myMark.":".$nextMark.":".$myGrade.":".$nextGrade.",";
			}
			if($minPush==-1){
				$minPush=$mark;
				$minMark=$markSum;
				$solution=explode(",",substr($solString,0,-1));
			}elseif($minPush==$mark && $markSum < $minMark){
				$minMark=$markSum;
				$solution=explode(",",substr($solString,0,-1));
			}
		}
		$solution[]=$myGPV.":".$nextGPV;
		$solution[]=$myGPA.":".$nextGPA;
		$solution[]=$this->getClass($myGPA).":".$this->getClass($nextGPA);

		return $solution;
	}


	/*
	 * Return Overall Grade Point Value
	 */
	public function getDGPV(){
		$gpv=0;
		for($i=1;$i<5;$i++){
			$gpv+=$this->getYearDGPV($i);
		}
		return $gpv;
	}

	/*
	 * Return Overall Grade Point Average
	 */
	public function getDGPA(){
		$credits=0;
		for($i=1;$i<5;$i++){
			$credits+=$this->getYearCredits($i);
		}
		return ($this->getDGPV()/$credits);
	}

	/*
	 * Return Overall Grade Point Value
	 */
	public function getCGPV(){
		$gpv=0;
		for($i=1;$i<5;$i++){
			$gpv+=$this->getYearCGPV($i);
		}
		return $gpv;
	}

	/*
	 * Return Overall Grade Point Average
	 */
	public function getCGPA(){
		$credits=0;
		for($i=1;$i<5;$i++){
			$credits+=$this->getYearCredits($i);
		}
		if($credits>0){
			return ($this->getCGPV()/$credits);
		}else{
			return -1;
		}
	}


	/*
	 * Return Total credits for the given year
	 */
	public function getYearCredits($year){
		$creditss=0;
		foreach($this->courses as $courseid => $course){
			if(courseYear($courseid)==$year && !isNoneGrade($courseid) && !isNoneCredit($courseid)){
				$creditss+=getCredits($courseid);
			}
		}
		return $creditss;
	}

	/*
	 * Return Degree GPV for a given year
	 */
	public function getYearDGPV($year){
		$gpv=0;
		foreach($this->courses as $courseid => $course){
			if(courseYear($courseid)==$year && !isNoneGrade($courseid) && !isNoneCredit($courseid)){
				$gpv+=getGradeGpv($this->getDGrade($courseid,$this->getRepeatMax($courseid)))*getCredits($courseid);
			}
		}
		return $gpv;
	}

	/*
	 * Return Class GPV for a given year
	 */
	public function getYearCGPV($year){
		$gpv=0;
		foreach($this->courses as $courseid => $course){
			if(courseYear($courseid)==$year && !isNoneGrade($courseid) && !isNoneCredit($courseid)){
				if($this->isRepeatCourse($courseid)){
					$this->debug("repeat", $this->getIndex()."|".$courseid."|".$this->getGrade($courseid,$this->getRepeatMax($courseid)),"red");
				}
				$gpv+=getGradeGpv($this->getGrade($courseid,$this->getRepeatMax($courseid)))*getCredits($courseid);
			}
		}
		return $gpv;
	}

	/*
	 * Chech whether the course id repeating course and
	 * return suitable Degraded Grade for repeted subjects
	 */
	public function getGrade($courseid,$examid){
		//Grades to be degraded
		$dgrades=array('A+','A','A-','B+','B','B-','C+');
		$grade=$this->getDGrade($courseid, $examid);
		if($this->isRepeatCourse($courseid)==true){
			if(in_array($grade, $dgrades)){
				return "C";
			}else{
				return $grade;
			}
		}else{
			return $grade;
		}
	}

	/*
	 * Return Mark of a given subject
	 */
	public function getMark($courseid,$examid){
		$course=$this->courses[$courseid];
		$marks=$course[$examid];
		return array($marks['marks3'],$marks['adjustment']);
	}

	/*
	 * Return Grade of a given subject
	 */
	public function getDGrade($courseid,$examid){
		if(!isset($this->courses[$courseid])){
			//Return when requesting for unavailable courses
			return null;
		}
		$course=$this->courses[$courseid];
		$marks=$course[$examid];
		if($this->absGrade && !isNoneGrade($courseid)){
			//Calling this; This is the grade function in common.php
			return getGradeC($marks['marks3']+$marks['adjustment']);
		}else{
			return $marks['final'];
		}
	}

	/*
	 * Check whether the given course is repeating course
	 */
	public function isRepeatCourse($courseid){
		if(!isset($this->courses[$courseid])){
			//Return when requesting for unavailable courses
			$this->debug("not found", $courseid, "red");
			return null;
		}
		$course=$this->courses[$courseid];

		//get the initial atempt to top
		asort($course);
		//reset the key to first
		reset($course);
		$marks=$course[key($course)];
		if(sizeof($course)==1){
			return false;
			//IF THE STUDENT HAVE REPEATED THE FIRST ABSENT ATTEMPT WITH SUBMITTING MEDICAL IT IS NOT REPEAT
		}elseif(sizeof($course)==2 && strtoupper($marks['final']) == 'MC'){
			echo $this->debug('not repeat',$courseid."|".$marks['final'], 'red');
			return false;
		}else{
			return true;
		}
	}

	/*
	 * Return Max Repeat mark for a given couurse
	 */
	public function getRepeatMax($courseid){
		global $gradeExp;//from common.php
		if(!isset($this->courses[$courseid])){
			//Return when requesting for unavailable courses
			return null;
		}
		$course=$this->courses[$courseid];
		$mark=0;
		$eid=0;
		//If the student have repeated the subject find the maximum he earned
		if(sizeof($course) >1){
			foreach ($course as $examid => $marks){
				if(key_exists(strtoupper($marks['final']), $gradeExp)){
					$eid=$examid;
				}elseif($marks['marks3']>$mark)
				{
					$mark=$marks['marks3'];
					$eid=$examid;
				}
			}
		}else{
			$eid=key($course);
		}
		return $eid;
	}

	/*
	 * Print Marks obtained for the yearlly subjects
	 */
	public function getYearMarks($year){
		$marks=array();
		foreach($this->courses as $courseid => $course){
			if(courseYear($courseid)==$year){
				foreach($course as $key => $exam){
					$mark=array(
						'courseid'	=>$courseid,
						'coursename'=>getCourseName($courseid),
						'credit'		=>getCredits($courseid),
						'grede'		=>$exam['final'],
						'exam'		=>getExamYear($key),
					);
					$marks[]=$mark;
				}
			}
		}
		return $marks;
	}

	/*
	 * Load ALL marks optained in all exams for the student in to an array
	 */
	public function loadCourses(){
		$cols    = array('marks3','final','adjustment');
		$course  = null;

		$query   ="
         SELECT courseid,examid,".implode(",",$cols)."
         FROM ".$this->self['marks']."
         WHERE indexno ='".$this->self['indexno']."'
         ORDER BY courseid DESC";

		$result  = mysql_query($query, $GLOBALS['CONNECTION']);
		while($row = mysql_fetch_array($result)){

			$marks=array();
			foreach($cols as $col){
				$marks[$col]=$row[$col];
			}

			if(!empty($this->courses[$row['courseid']]))
			{
				$course=$this->courses[$row['courseid']];
				$course[$row['examid']]  = $marks;
				$this->courses[$row['courseid']]=$course;
			}else{
				$course=array();
				$course[$row['examid']]  = $marks;
				$this->courses[$row['courseid']]=$course;
			}
		}
	}
}

?>
