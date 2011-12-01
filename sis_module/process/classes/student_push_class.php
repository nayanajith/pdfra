<?php 
include_once(A_CLASSES."/student_class.php");
class Student_push extends Student{
   protected $max_cycles=131072;

   protected $info_arr=array(
      'degree_push'=>false,
      'gpa'            =>null,
      'next_gpa'      =>null,
      'gpv'            =>null,
      'next_gpv'      =>null,
      'max_push'      =>null
   );

   public function get_info(){
      return $this->info_arr;
   }
  /*
   * Suggesting the students who can be pushed to a higher class  or push to
   * be eligible to pass
   */
   public function push($year=null){
      //The next GPA which the student should be pushed
      $next_GPA         =0;

      //The GPA which the student should obtained just to pass the Degree
      $min_degree_GPA   =2;

      //Maximum push for a class
      $class_push         =5;

      //Maximus Push for a degree
      $degree_push      =10;
      $is_degree_push   =false;

      //initialize  max_push
      $max_push         =$degree_push;

      //My GPV can either be my CGPV or my DGPV
      $my_GPV            =0;



      //The grades which gives higher jump whiel changing the grade (0.5)
      $max_jumps      =array("D+","C+","B+");

      $my_CGPV         =$this->getCGPV($year);
      $my_CGPA         =$this->getCGPA($year);
      $my_DGPV         =$this->getDGPV($year);
      $my_DGPA         =$this->getDGPA($year);

      /*
       * Finding next closed GPA and suitable GPV for calculations (to just pass
       * or to upgrade in class)
       */
      if($min_degree_GPA > $my_DGPA){
         $next_GPA   =$min_degree_GPA;
         $my_GPV      =$my_DGPV;
         $my_GPA      =$my_DGPA;
         $max_push   =$degree_push;
         $is_degree_push   =true;
      }else{
         $max_push   =$class_push;
         $my_GPV      =$my_CGPV;
         $my_GPA      =$my_CGPA;
         foreach ($this->classes as $class => $gpa){
            if($gpa-$my_CGPA > 0){
               $next_GPA   =$gpa;
               break;
            }
         }
      }

      //Collect information to be return for the users request
      $this->info_arr['degree_push']=$is_degree_push;
      $this->info_arr['gpa']         =round($my_GPA,2);
      $this->info_arr['next_gpa']   =$next_GPA;
      $this->info_arr['gpv']         =$my_GPV;
      $this->info_arr['max_push']   =$max_push;

      log_msg("Degree push",$is_degree_push);
      log_msg("Max GPV Push",$max_push );
      log_msg("GPA",$my_GPA);
      log_msg("Next GPA",$next_GPA);

      //Finding total credits available from the courses done
      $credits=0;
      for($i=1;$i<5;$i++){
         $credits+=$this->getYearCredits($i);
      }

      log_msg("Total Credits",$credits);
      //Total GPV that should obtain to get next closed GPA
      $next_GPV   =$credits*$next_GPA;

      //GPV difference
      $GPV_diff   =$next_GPV-$my_GPV;
      if($GPV_diff<0){
         //GPA could not push
         log_msg("FIRST CLASS",$my_GPA );
         return;
      }

      if($GPV_diff > $max_push){
         //Not possible to push
         log_msg("Cannot try GPVDIFF",$GPV_diff);
         return false;
      }

      log_msg("Can try GPVDIFF",$GPV_diff);


      //Array to hold the adjustment marks to raech next grade
      $push_marks_courses   =array(
      /*'SCS1001'=>mark_push*/
      );

      $push_GPV_courses   =array(
      /*'SCS1001'=>GPV_push*/
      );

      /*
       * Calculating the marks whch can be pushed for each subject and their out
       * come grade incriments to be selected afterword
       */
      foreach($this->courses as $course_id => $course){

         //Non-grade courses can not be pushed
         if(isNonGrade($course_id)){
            continue; 
         }

         //Students actual marks for the particular course
         $course_exam_arr=$this->getRepeatMax($course_id);
         $exam_id        = $course_exam_arr['exam_hid'];  
         $my_mark=$this->getMark($course_id,$exam_id);

         //Reduce previous push from max push
         $my_previouse_push=$my_mark[1];
         if($my_previouse_push>0){
            $max_push-=$my_previouse_push;
            log_msg("Previous push:".$course_id,$my_previouse_push );
         }

         //Selecting 3rd year subjects if this is class push and not noneGrade and not nonCredit and not previousely pushed
         //Selecting all year subjects if this is degree push and not noneGrade and not nonCredit and not previousely pushed

         if(( $is_degree_push || courseYear($course_id)==3 )&& strtoupper($this->getGrade(array('course_id'=>$course_id, 'exam_hid'=>$exam_id)))!= 'AB' && !isNonGrade($course_id) && !isNonCredit($course_id) && $my_previouse_push==0){
            $minGradeMark=array(
               'D-'=>20,'D'=>30,'D+'=>40,
               'C-'=>45,'C'=>50,'C+'=>55,
               'B-'=>60,'B'=>65,'B+'=>70,
               'A-'=>75,'A'=>80,'A+'=>90
            );
            $min_grade_mark=$minGradeMark;
            $next_mark=0;

            //Finding the adjesent next mark of the particular course which can be pushed
            foreach ($min_grade_mark as $grade => $mark){
               if(($mark-$my_mark[0]) > 0 && ($mark-$my_mark[0])<=$max_push){
                  $next_mark=$mark;
                  break;
               }
            }

            if($next_mark!=0){ //Ignore courses which can not be pushed with max_push
               $mark_push=$next_mark-$my_mark[0]; // Possible push of marks for particular course
               //Ammont of GPV push coucl be obtained after pushing the course by above marks
               $GPV_push   =(getGradeGpv(getGradeC($next_mark,$course_id))-getGradeGpv(getGradeC($my_mark[0],$course_id)))*getCredits($course_id);

               if(!($mark_push==5 && $GPV_push < $GPV_diff)){//Ignore pushes which can not obtain required GPV push wiht pushing maxMarks
                  $push_marks_courses[$course_id."@".$exam_id]   =$mark_push; //Filling mark Push Array
                  $push_GPV_courses[$course_id."@".$exam_id]      =$GPV_push;   //Filling GPV push Array
               }
            }
         }
      }

      // Sort GPV Push array and Mark Push array  to choose the most efficient one
      asort($push_marks_courses);
      asort($push_GPV_courses);

      //Generate all possible combinations of courses which can be used to push the student
      $combinations = array(array( ));
      foreach ($push_GPV_courses as $element => $mark){
         $cycles=0;
         foreach ($combinations as $combination){
            $cycles++;
            array_push($combinations, array_merge(array($element), $combination));
            if($cycles>=$this->max_cycles){
               break;
            }
         }
      }

      //Soltion candidate array.. This will filled after calculating marks for each combinations and filtering
      $sol_candidates=array();

      //Filtering the valid candidate combinations
      foreach ($combinations as  $combination){
         $push_sum=0;
         $mark_sum=0;
         foreach ($combination as $course_s){
            $push_sum+=$push_GPV_courses[$course_s];
            $mark_sum+=$push_marks_courses[$course_s];
         }
         if($push_sum >= $GPV_diff && $mark_sum <= $max_push){
            //log_msg(implode(",", $combination),$push_sum );
            $sol_candidates[implode(",", $combination)]=$push_sum;
         }
      }

      //Sort the candidate combinations to get the most efficient one
      if(sizeof($sol_candidates)>0){
         asort($sol_candidates);
      }else{
         log_msg("No candidate combinations found", "0");
         return ;
      }
      //Choose the best solution from the candidate solutions, whcih to be returned
      $min_push=-1;
      $min_mark=5;
      $solution=null;
      foreach ($sol_candidates as  $candidate => $mark){
         $tmp_solution=null;
         $mark_courses=explode(",",$candidate);
         $mark_sum=0;
         $sol_string="";
         foreach ($mark_courses as $course_s ){
            $course = explode('@', $course_s);
            $mark_sum+=$push_marks_courses[$course_s];
            $course_id   =$course[0];
            $exam_id      =$course[1];
            $mark_p      =$push_marks_courses[$course_s];
            $gradeP      =$push_GPV_courses[$course_s];
            $tmp_mark   =$this->getMark($course_id, $exam_id);
            $my_mark      =$tmp_mark[0];
            $next_mark   =$my_mark+$mark_p;
            //$my_grade   =$this->getGrade($course_id,$exam_id);
            $my_grade   =getGradeC($my_mark,$course_id);
            $next_grade   =getGradeC($next_mark,$course_id);

            $sol_string.=$course_id.";".$exam_id.";".$mark_p.";".$gradeP.";".$my_mark.";".$next_mark.";".$my_grade.";".$next_grade.",";
         }

         if($min_push==-1){
            $min_push=$mark;
            $min_mark=$mark_sum;
            $solution=explode(",",substr($sol_string,0,-1));
         }elseif($min_push==$mark && $mark_sum < $min_mark){
            $min_mark=$mark_sum;
            $solution=explode(",",substr($sol_string,0,-1));
         }
      }

      $info=array(
         'solution'   =>$solution,
         'gpv_push'   =>$my_GPV.";".$next_GPV,
         'gpa_push'   =>round($my_GPA,2).";".$next_GPA,
         'class_push'=>$this->getClass($my_GPA).";".$this->getClass($next_GPA)
      );

      return $info;
   }
}

?>
