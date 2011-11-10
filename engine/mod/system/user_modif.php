<?php
/*Auto generated by form_gen.php*/
$syear_inner="";
$curr_year=date("Y");
for($i=($curr_year-2); $i < ($curr_year+2); $i++ ){
	$syear_inner.="<option value='$i'>$i</option>";
}

$school_id_inner="";
$res=exec_query("SELECT short_name FROM ".$GLOBALS['S_TABLES']['program'],Q_RET_MYSQL_RES);
if(is_resource($res)){
	while($row=mysql_fetch_assoc($res)){
		$school_id_inner.="<option value='".$row['short_name']."'>".$row['short_name']."</option>";
	}
}

$title_inner="";
foreach(array('MR',"MS","DR","PROF") as $value){
	$title_inner.="<option value='$value'>$value</option>";
}

$password_custom='
<input type="hidden" name="password" id="password" jsId="password" dojoType="dijit.form.ValidationTextBox" style="border:0px;width:0px;" value="" ></input>
<div dojoType="dijit.form.DropDownButton">
	<span>
       Change Password 
   </span>
   <div dojoType="dijit.TooltipDialog">
		<div dojoType="dojox.form.PasswordValidator" name="password_val" id="password_val" jsId="password_val">
			<table>
				<tr><td>Password</td><td>:<input type="password" pwType="new" /></td></tr>
            <tr><td>Validate</td><td>:<input type="password" pwType="verify" /></td></tr>
			</table>
      </div>
      <button dojoType="dijit.form.Button" type="submit">
         OK
  			<script type="dojo/method" event="onClick" args="evt">
				var pval=dijit.byId("password_val").value;
				var pset=dijit.byId("password");
				pset.attr("value",pval);
				alert(pset.value);
			</script>
      </button>
   </div>
</div>
';

$permission_inner="";
foreach(array("ADMIN","STAFF","STUDENT","GUEST") as $value ){
	$permission_inner.="<option value='$value'>$value</option>";
}

$fields=array(
"user_id"=>array(
		"length"=>"",
		"dojoType"=>"dijit.form.NumberTextBox",
		"type"=>"hidden",
		"required"=>"false",
		"style"=>"width:0px;",
		"label"=>"",
		"value"=>""),	

"syear"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Syear",
		"inner"=>$syear_inner,
		"section"=>"School",
		"value"=>""),	
"current_school_id"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Current school id",
		"inner"=>$school_id_inner,
		"value"=>""),	
"programs"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Programs",
		"value"=>""),	

"title"=>array(
		"length"=>"35",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Title",
		"section"=>"Personal",
		"inner"=>$title_inner,
		"value"=>""),	
"first_name"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"First name",
		"value"=>""),	
"last_name"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Last name",
		"value"=>""),	
"middle_name"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Middle name",
		"value"=>""),	
"username"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Username",
		"value"=>""),	
/*
"password"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Password",
		"value"=>""),	
*/
"password"=>array(
		"label"=>"Password",
		"custom"=>"true",
		"inner"=>$password_custom),	
"phone"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"section"=>"Contact",
		"label"=>"Phone",
		"value"=>""),	
"email"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Email",
		"value"=>""),	

"permission"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"label"=>"Permission",
		"inner"=>$permission_inner,
		"value"=>""),	
"homeroom"=>array(
		"length"=>"35",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Homeroom",
		"value"=>""),	
"profile_id"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Profile id",
		"value"=>""),	
"rollover_id"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Rollover id",
		"value"=>"")	
);
?>
