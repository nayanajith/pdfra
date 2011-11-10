<?php
include(A_MODULES."/".A_MODULE."/Student_class.php");
include(A_MODULES."/registration/data_entry_class.php");
$formgen = new Formgenerator('csstudent','IndexNo');

if($data==true){
	$formgen->xhr_filtering_select_data('fill_form');
	return;
}
echo $formgen->gen_xhr_filtering_select('fill_form');
?>
<script>
function fill_form(a,b){
	alert(a.b);
}
</script>
<?php 

if(isset($_REQUEST['IndexNo'])){
	opendb();
	$student = new Student($_REQUEST['IndexNo']);
	echo "<pre>";
	print_r($student->getTranscript());
	echo "</pre>";
	closedb();
}
?>
