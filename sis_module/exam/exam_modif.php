<?php
/*Auto generated by form_gen.php*/

$semester_inner="
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
";

$student_year_inner="
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
";


$fields=array(
"exam_id"=>array(
      "length"=>"42",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "type"=>"hidden",
      "label"=>"Exam id",
      "value"=>""),   
"student_year"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "inner"=>$student_year_inner,
      "label"=>"Student year",
      "value"=>""),   
"semester"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "inner"=>$semester_inner,
      "label"=>"Semester",
      "value"=>""),   

/*
"academic_year"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Academic year",
      "value"=>""),   
 */
"exam_date"=>array(
      "length"=>"100",
      "dojoType"=>"dijit.form.DateTextBox",
      "required"=>"false",
      "label"=>"Exam date",
      "value"=>""),   
"exam_hid"=>array(
      "length"=>"200",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Exam id HR [date:year:semester]",
      "value"=>""),
"exam_time"=>array(
      "length"=>"105",
      "dojoType"=>"dijit.form.TimeTextBox",
      "required"=>"false",
      "label"=>"Time",
      "value"=>""),   
"venue"=>array(
      "length"=>"200",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Venue",
      "value"=>""),   
/*
"deleted"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.NumberTextBox",
      "required"=>"false",
      "label"=>"Deleted",
      "value"=>""),   
 */
"note"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.SimpleTextarea",
      "required"=>"false",
      "label"=>"Note",
      "value"=>"")   
);
?>
