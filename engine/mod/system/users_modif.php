<?php
/*Auto generated by form_gen.php*/
$syear_inner="";
$curr_year=date("Y");
for($i=($curr_year-2); $i < ($curr_year+2); $i++ ){
   $syear_inner.="<option value='$i'>$i</option>";
}

$school_id_inner="";
$res=exec_query("SELECT short_name FROM ".$GLOBALS['S_TABLES']['program'],Q_RET_MYSQL_RES);
while($row=mysql_fetch_assoc($res)){
   $school_id_inner.="<option value='".$row['short_name']."'>".$row['short_name']."</option>";
}

$title_inner="";
foreach(array('MR',"MS","DR","PROF") as $value){
   $title_inner.="<option value='$value'>$value</option>";
}
d_r("dojox.form.PasswordValidator");
$password_custom='
<input type="hidden" name="password" id="password" jsId="password" dojoType="dijit.form.ValidationTextBox" style="border:0px;width:0px;" value="" ></input>
<div dojoType="dijit.form.DropDownButton">
   <span>
       Change Password 
   </span>
   <div dojoType="dijit.TooltipDialog">
      <div dojoType="dojox.form.PasswordValidator" name="password_val" id="password_val" jsId="password_val">
         <table>
            <tr><td>Password</td><td>:<input type="password" pwType="new" ></td></tr>
            <tr><td>Validate</td><td>:<input type="password" pwType="verify" ></td></tr>
         </table>
      </div>
      <button dojoType="dijit.form.Button" type="submit">
         OK
           <script type="dojo/method" event="onClick" args="evt">
            var pval=dijit.byId("password_val").value;
            var pset=dijit.byId("password");
            pset.attr("value",pval);
            //alert(pset.value);
         </script>
      </button>
   </div>
</div>
';

$permission_inner="";
foreach(array("ADMIN","STAFF","STUDENT","GUEST") as $value ){
   $permission_inner.="<option value=\"$value\">$value</option>";
}

$theme_inner="";
foreach(array('claro','nihilo','soria','tundra') as $value ){
   $theme_inner.="<option value=\"$value\">$value</option>";
}

$layout_inner="";
foreach(array('web','app','pub') as $value ){
   $layout_inner.="<option value=\"$value\">$value</option>";
}

$fields=array(
   
"user_id"=>array(
      "length"=>"77",
      "dojoType"=>"dijit.form.NumberTextBox",
      "type"=>"hidden",
      "required"=>"false",
      "label"=>"User id",
      "value"=>""),   
"syear"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "inner"=>$syear_inner,
      "label"=>"Syear",
      "value"=>""),   
"current_school_id"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "inner"=>$school_id_inner,
      "label"=>"Current school id",
      "value"=>""),   
"title"=>array(
      "length"=>"35",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "label"=>"Title",
      "inner"=>$title_inner,
      "value"=>""),   
"first_name"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"First name",
      "value"=>""),   
"last_name"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Last name",
      "value"=>""),   
"middle_name"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Middle name",
      "value"=>""),   
"username"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Username",
      "value"=>""),   
"password"=>array(
      "label"=>"Password",
      "custom"=>"true",
      "inner"=>$password_custom),   
/*
"password"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Password",
      "value"=>""),   
*/
"phone"=>array(

      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Phone",
      "value"=>""),   
"email"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Email",
      "value"=>""),   
"ldap_user_id"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"LDAP User ID",
      "value"=>""),   

      /*
"permission"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.SimpleTextarea",
      "required"=>"false",
      "inner"=>$permission_inner,
      "label"=>"Permission",
      "value"=>""),   
      */
"theme"=>array(
      "length"=>"140",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "label"=>"Theme",
      "inner"=>$theme_inner,
      "value"=>""),   
"layout"=>array(
      "length"=>"140",
      "dojoType"=>"dijit.form.ComboBox",
      "required"=>"false",
      "inner"=>$layout_inner,
      "label"=>"Layout",
      "value"=>""),   
"homeroom"=>array(
      "length"=>"35",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Homeroom",
      "value"=>""),   
"programs"=>array(
      "length"=>"350",
      "dojoType"=>"dijit.form.SimpleTextarea",
      "required"=>"false",
      "label"=>"Programs",
      "value"=>""),   
      /*
"last_login"=>array(
      "length"=>"100",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"true",
      "label"=>"Last login",
      "value"=>""),   
"failed_login"=>array(
      "length"=>"70",
      "dojoType"=>"dijit.form.ValidationTextBox",
      "required"=>"false",
      "label"=>"Failed login",
      "value"=>""),   
      */
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
