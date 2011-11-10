<?php
/*
Student should get at least acquire C passes for subjects worth of 10 credits to eligible to fallow year-2
*/

include(MOD_CLASSES."/student_eligibility_interface.php");
class Eligibility implements eligibility_interface{
	//Override these constants to reflect the relevence
	const program 				= 'bcsc';
	const eligibility_name 	= 'degree-4-eligible';
	const student_year 		= '4';
	const rule 					= 'bla bla degree 4';

	
	protected $index_no		= '';
	protected $info_arr		= '';
	protected $student		= null;

	public function __construct($index_no=null){
		$this->index_no	=$index_no;
		$this->student 	= new Student($index_no);
	}

	/*
	This should return the effective program of the class 
	return: program
	*/
   public function get_program(){
		return  $this::program;
	}

	/*
	Return the effective year of the eligibility
	return: year
	*/
   public function get_year(){
		return  $this::student_year;
	}

	/*
	Return the name of the eligibility
	return: name
	*/
   public function get_name(){
		return  $this::eligibility_name;
	}
	/*
	Return the rule for the eligibility
	return: rule
	*/
   public function get_rule(){
		return  $this::rule;
	}

	/*
	Set the stuent index number to test with
	set: index_no
	*/
   public function set_index_no($index_no){}

	/*
	 * Degreee state array
	 */
	protected $states=array(
		"NA",//0
		"1st year Cretdits &lt; 30",//1
		"2nd year Cretdits &lt; 30",//2
		"3rd year Cretdits &lt; 22",//3

		"1st Class",					//4
		"2nd Class U", 				//5
		"2nd Class L", 				//6
		"Pass", 							//7

		"DGPVA &lt; 2.0",				//8

		"ENH1001 NC",					//9
		"SCS3026 GPV &lt; 2.0",		//10
		"ICT3015 GPV &lt; 2.0",		//11
		"ICT1007=='AB'|| ICT1007=='MC'|| ICT1008=='AB'|| ICT1008=='MC'|| ICT1016=='AB'|| ICT1016=='MC'", //12
	);

	/*
	Return true or false according to the student's performance
	Regurn an array of information 
	array(
		'rule'=>'A discription of the rule which checked',
		'stat'=>'true/false',
		'reason'=>'Reason to be false'
	)

	*/
   public function get_eligibility(){
		$state		=true;
		$state_info	=array();
		if(strtoupper(PROGRAM) == 'BCSC'){
			if($this->student->getRepeatMax("ENH1001")==0 || strtoupper($this->student->getGrade("ENH1001",$this->student->getRepeatMax("ENH1001")))!='CM'){
				$state=false;
				$state_info[]=$this->states[9];
			}
			if(getGradeGpv($this->student->getGrade("SCS3026",$this->student->getRepeatMax("SCS3026")))<2.0){
				$state=false;
				$state_info[]=$this->states[10];
			}
		}else{
			if(getGradeGpv($this->student->getGrade("ICT3015",$this->student->getRepeatMax("ICT3015")))<2.0){
				$state=false;
				$state_info[]=$this->states[11];
			}
		}

		if($this->student->getYearCredits(1)<30){
			$state=false;
			$state_info[]=$this->states[1];
		}
		if($this->student->getYearCredits(2)<30){
			$state=false;
			$state_info[]=$this->states[2];
		}
		if($this->student->getYearCredits(3)<22){
			$state=false;
			$state_info[]=$this->states[3];
		}
		$cgpa=$this->student->getCGPA();
		if(sizeof($state_info)==0){
			if($cgpa >= 3.5){
				// "Final Result : First Class<b>";
				$state_info[]=$this->states[4];
			}elseif(($cgpa >= 3.25) && ($cgpa < 3.5)) {
				//"Final Result : Second Class Upper Division<b>";
				$state_info[]=$this->states[5];
			}elseif(($cgpa >= 3.0) && ($cgpa < 3.25)) {
				//"Final Result : Second Class Lower Division<b>";
				$state_info[]=$this->states[6];
			}elseif(($cgpa >= 2.0) && ($cgpa < 3.0)) {
				//"Final Result : Pass<b>";
				$state_info[]=$this->states[7];
			}elseif(($cgpa < 2.0)){
				//"Final Result : Fail<b>";
				$state=false;
				$stete_info[]=$this->states[8];
			}
		}

		return array(
			'state'	=>$state,
			'info'	=>$state_info,
			'cgpa'	=>round($cgpa,2)
		);
	}
}
?>
