<?php
echo "<h3>Postgraduate Application form</h3>";
include A_CLASSES."/xhr_combobox_class.php";
$xhr_combobox=new XHR_Combobox();

d_r('dojox.data.QueryReadStore');
d_r('dijit.form.Button');
d_r('dijit.form.Form');
d_r('dijit.form.ComboBox');

$table_of_id=array(
	'short_name'=>$GLOBALS['MOD_S_TABLES']['program']
);

$filter_map=array(
);

if(isset($_REQUEST['form'])){
	switch($_REQUEST['form']){
		case 'store':
				$filter="";
				$xhr_combobox->json_data($table_of_id[$_REQUEST['id']],$_REQUEST['id'],$filter);
		break;
		case 'param':
			$_SESSION[PAGE][$_REQUEST['param']]=$_REQUEST[$_REQUEST['param']];
			switch($_REQUEST['param']){
				case 'short_name':
					$admission_year=exec_query("SELECT short_name FROM ".$GLOBALS['MOD_S_TABLES']['program']." WHERE short_name='".$_SESSION[PAGE][$_REQUEST['param']]."'",Q_RET_ARRAY);
				break;
			}
		break;
	}
}else{
	echo "<div id='program_frm' jsId='program_frm' dojoType='dijit.form.Form' >";
	echo "</div>";
	echo "<script type='text/javascript'>";
	echo "dojo.addOnLoad(function() {";

	$xhr_combobox->gen_xhr_combobox('short_name',"Donation",$xhr_combobox->get_val('short_name'),80,20,null,null);
	$xhr_combobox->param_setter();$xhr_combobox->html_requester();
	echo "});";
	$xhr_combobox->form_submitter('program_frm');
	echo "</script>";
}
?>
