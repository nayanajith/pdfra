<?php
/*
Student should get at least acquire C passes for subjects worth of 10 credits to eligible to fallow year-2
*/

$RULE= "The sum of the credits of the courses which have 'C' or greater grades in YEAR-1 should be grater than or equal to 10 to eligible YEAR-2";
$KEYS=array('state','cgpa','info');



include(MOD_CLASSES."/student_eligibility_interface.php");
class Eligibility implements eligibility_interface{
   //Override these constants to reflect the relevence
   const program             = 'bcsc';
   const eligibility_name    = 'degree-4-eligible';
   const student_year        = '4';
   const rule                = 'bla bla degree 4';

   
   protected $index_no      = '';
   protected $info_arr      = '';
   protected $student      = null;

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
   Return true or false according to the student's performance
   Regurn an array of information 
   array(
      'rule'=>'A discription of the rule which checked',
      'stat'=>'true/false',
      'reason'=>'Reason to be false'
   )

   */
   public function get_eligibility(){
      global $minGradeMark;
      $min_gpa    =2.5;
      $course     ='SCS3017';
      $min_mark   =$minGradeMark['B-'];

      $state_info =array();
      $state      =true;
      if($this->student->getCGPA() < $min_gpa){
         $state         =false;
         $state_info[]  ="GPA < $min_gpa";
      } 
      $repeat_max_arr=$this->student->getRepeatMax($course);
      $mark_arr      =$this->student->getMark($repeat_max_arr['course_id'],$repeat_max_arr['exam_hid']);
      if(isset($mark_arr['final_mark'])&&($mark_arr['final_mark']+$mark_arr['push']) < $min_mark){
         $state      =false;
         $state_info[]="$course marks < $min_mark";
      }

      return array(
         'state'  =>$state,
         'cgpa'   =>round($this->student->getCGPA(),2),
         'info'   =>implode($state_info,',')
      );
   }
}
?>
