<?php
/*Auto generated by form_gen.php*/

$absent_inner="";
foreach(array(0,1) as $value){
	$absent_inner.="<option value='$value'>$value</option>";
}

$unauthorized_inner="";
foreach(array(0,1) as $value){
	$unauthorized_inner.="<option value='$value'>$value</option>";
}

$question_no_50_inner="";
foreach(array('CORRECT'=>'1','INCORRECT'=>'2','NOT_ANSWERED'=>'3') as $key =>$value){
	$question_no_50_inner.="<option value='$value'>$key</option>";
}

$fields=array(
	
"exam_no"=>array(
		"length"=>"56",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"",
		"style"=>"border:0px;",
		"value"=>""),	
"absent"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Absetnt",
		"inner"=>$absent_inner,
		"value"=>""),	
"unauthorized"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Unauthorized",
		"inner"=>$unauthorized_inner,
		"value"=>""),	
"question_no_50"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"inner"=>$question_no_50_inner,
		"label"=>"Question no 50",
		"value"=>""),
"note"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Note",
		"value"=>"")	
);
?>
