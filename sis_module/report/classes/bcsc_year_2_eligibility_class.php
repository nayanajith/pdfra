<?php
/*
Student should get at least acquire C passes for subjects worth of 10 credits to eligible to fallow year-2
*/
$RULE= "The sum of the credits of the courses which have 'C' or greater grades in YEAR-1 should be grater than or equal to 10 to eligible YEAR-2";
$KEYS=array('state','credits','detail');

include(MOD_CLASSES."/student_eligibility_interface.php");
class Eligibility implements eligibility_interface{
   //Override these constants to reflect the relevence
   const program              = 'bcsc';
   const eligibility_name     = 'year_2_eligible';
   const student_year         = '1';
   const pass_credit_limit    = '10';
   
   protected $index_no        = '';
   protected $info_arr        = '';
   protected $year_pass_grade ='C'; //Students should get at least a given number of C grades  for each year

   public function __construct($index_no){
      $this->index_no=$index_no;
      $student       = new Student($index_no);
      $year_pass_mark=getMinMarkC($this->year_pass_grade);

      $creditss=0;
      $info      =array(
         "credits"=>0,
         "pass"=>array(),
         "fail"=>array(),
      );
      foreach($student->getCourses() as $course_id => $course){
         if(courseYear($course_id)==$this::student_year && !isNonGrade($course_id) && !isNonCredit($course_id)){
            $exam_hid_arr  =$student->getRepeatMax($course_id);
            $marks_arr     =$student->getMark($exam_hid_arr['course_id'],$exam_hid_arr['exam_hid']);
            if(is_null($marks_arr)){log_msg('kk',$course_id.":".$this->index_no);continue;}
            if(array_sum($marks_arr) >= $year_pass_mark){
               $info['pass'][$course_id]=getCredits($course_id);
               $info['credits']+=getCredits($course_id);
            }else{
               $info['fail'][$course_id]=getCredits($course_id);
            }
         }
      }
      $this->info_arr=$info;
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
   return: true/false
   */
   public function get_eligibility(){
      return array(
         'state'      =>($this->info_arr['credits']<$this::pass_credit_limit)?false:true,
         'credits'   =>$this->info_arr['credits'],
         'detail'    =>implode(array_values($this->info_arr['pass']),',')
      );
   }

   /*
   Regurn an array of information 
   array(
      'rule'=>'A discription of the rule which checked',
      'stat'=>'true/false',
      'reason'=>'Reason to be false'
   )
   */
   public function get_eligibility_info(){
      return $this->info_arr;
   }

/*
    * Return Total credits for the given year
DOING
    */
   public function getYearPass($year){
   }
}
?>
