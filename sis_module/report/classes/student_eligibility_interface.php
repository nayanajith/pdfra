<?php
/*
This eligibility interface should be implemented by any eligibility class
*/

include_once(A_CLASSES."/student_class.php");
interface eligibility_interface
{
	//Override these constants to reflect the relevence
	/*
	const program 				= 'bcsc';
	const eligibility_name 	= 'year-1-pass';
	const student_year 		= '1';
	const	rule					= 'A discription of the rule which checked';
	*/

	/*
	This should return the effective program of the class 
	return: program
	*/
   public function get_program();

	/*
	Return the effective year of the eligibility
	return: year
	*/
   public function get_year();

	/*
	Return the name of the eligibility
	return: name
	*/
   public function get_name();

	/*
	Return the rule for the eligibility
	return: rule
	*/
   public function get_rule();

	/*
	Set the stuent index number to test with
	set: index_no
	*/
   public function set_index_no($index_no);

	/*
	Return true or false according to the student's performance
	array(
		'stat'=>'true/false',
		'reason'=>'Reason to be false'
	)
	*/
   public function get_eligibility();

}
?>
