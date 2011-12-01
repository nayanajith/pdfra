<?php

$RULE= "The sum of the credits which have 'C' or greater in YEAR-2 should be grater than or equal to 10 to eligible YEAR-3";
$KEYS=array('state','cgpa','detail');

include(MOD_CLASSES."/student_eligibility_interface.php");
class Eligibility implements eligibility_interface{
   //Override these constants to reflect the relevence
   const program             = 'bcsc';
   const eligibility_name    = 'degree-3-eligible';
   const student_year       = '3';
   const rule                = 'bla bla to get degree-3';

   protected $index_no      = '';
   protected $info_arr      = '';
   protected $student      =   null;

   public function __construct($index_no=null){
      $this->index_no   =$index_no;
      $this->student    = new Student($index_no);
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

      "1st Class",               //4
      "2nd Class U",             //5
      "2nd Class L",             //6
      "Pass",                      //7

      "DGPVA &lt; 2.0",            //8

      "ENH1001 NC",               //9
      "SCS3026 GPV &lt; 2.0",      //10
      "ICT3015 GPV &lt; 2.0",      //11
      "ICT1007=='AB'|| ICT1007=='MC'|| ICT1008=='AB'|| ICT1008=='MC'|| ICT1016=='AB'|| ICT1016=='MC'", //12
   );


   /*
   Return true or false according to the student's performance
   return: true/false
   */
   public function get_eligibility(){
      $state=true;
      $state_info=array();
      if(strtoupper(PROGRAM) == 'BCSC'){
         if(strtoupper($this->student->getGrade($this->student->getRepeatMax("ENH1001")))!='CM'){
            $state=false;
            $state_info[]=$this->states[9];
         }
         if(getGradeGpv($this->student->getGrade($this->student->getRepeatMax("SCS3026")))<2.0){
            $state=false;
            $state_info[]=$this->states[10];
         }
      }else{
         $ict1007=strtoupper($this->student->getGrade($this->student->getRepeatMax("ICT1007")));
         $ict1008=strtoupper($this->student->getGrade($this->student->getRepeatMax("ICT1008")));
         $ict1016=strtoupper($this->student->getGrade($this->student->getRepeatMax("ICT1016")));
         if(
         getGradeGpv($this->student->getGrade($this->student->getRepeatMax("ICT3015")))<2.0 &&
         ($ict1007=='AB'|| $ict1007=='MC'||$ict1008=='AB'||$ict1008=='MC'||$ict1016=='AB'||$ict1016=='MC')){
            $state=false;
            $state_info[]=$this->states[12];
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
            $state_info[]=$this->states[8];
         }
      }

      return array(
         'state'   =>$state,
         'detail'   =>implode($state_info,','),
         'cgpa'   =>round($cgpa,2)
      );
   }
}
?>
