<?php

function push(){
	include_once(MOD_CLASSES."/student_push_class.php");
	$student_push = new Student_push($_REQUEST['index_no']);
	echo "<pre>";
	if($student_push->push() != null){
		print_r($student_push->push());
	}else{
		echo "Cannot push";	
	}
	echo "</pre>";
}

?>
