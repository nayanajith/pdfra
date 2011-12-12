<?php
$sex_inner="
<option value='M'>M</option>
<option value='F'>F</option>
";


$corresp_addr_inner="
<option value='PERMANENT'>PERMANENT</option>
<option value='OFFICE'>OFFICE</option>
";

$title_inner="";
//foreach(array("PROF","DR","MR","MS","MRS","REV") as $value){
foreach(array("REV","DR","MR","MS","MRS","MISS") as $value){
	$title_inner.="<option value='$value'>$value</option>";
}

$program_inner="";
//foreach(array("PROF","DR","MR","MS","MRS","REV") as $value){
foreach(array_keys($GLOBALS['PROGRAMS']) as $value){
	$program_inner.="<option value='$value'>$value</option>";
}

	 	
$edu_prof_custom_data="
		 <tr><th>Qualification/Certificate</th><th>Institute/Organization</th><th>Date of Award</th><th>Duration</th></tr>
";
for($i=1;$i<=6;$i++){
	$edu_prof_custom_data.=" <tr><td><input type='text' id='qual$i' name='qual$i' size='30'></td><td><input size='30'size='30' type='text' id='inst$i' name='inst$i'></td><td><input type='text' id='doa$i' name='doa$i' style='width:80px' dojoType='dijit.form.DateTextBox' constraints=\"{datePattern:'yyyy-MM-dd'}\" promptMessage='yyyy-MM-dd' ></td><td><input type='text' style='width:80px' name='dur$i' id='dur$i' ></td></tr>";
}

d_r("dijit.form.DropDownButton");
$edu_prof_custom='
<div dojoType="dijit.form.DropDownButton">
	<span>
     Click to Add  Education/Professional Qualifications 
   </span>
  	<script type="dojo/method" event="onClick" args="evt">
		var seperator="#";
      for(i = 1; i <= 6; i++){
			var record=document.getElementById("edu_prof_qual"+i).value;
			if(record){
				var record_arr=record.split(seperator);
      		document.getElementById("qual"+i).value=record_arr[0];
            document.getElementById("inst"+i).value=record_arr[1];
            document.getElementById("doa"+i).value=record_arr[2];
            document.getElementById("dur"+i).value=record_arr[3];
			}
		}
	</script>
   <div dojoType="dijit.TooltipDialog" id="edu_prof_div">
		<table>
		'.$edu_prof_custom_data.'
		</table>
		<br/>
      <button dojoType="dijit.form.Button" type="submit">
         OK
  			<script type="dojo/method" event="onClick" args="evt">
				var seperator="#";
            var i;
            for(i = 1; i <= 6; i++){
            	var qual=document.getElementById("qual"+i).value;
            	var inst=document.getElementById("inst"+i).value;
            	var doa=document.getElementById("doa"+i).value;
            	var dur=document.getElementById("dur"+i).value;
					document.getElementById("edu_prof_qual"+i).value=qual+seperator+inst+seperator+doa+seperator+dur;
				}
			</script>
      </button>
   </div>
</div>
<br/>
';

$employment_record_custom_data="
		 <tr><th>Designation</th><th>Work Place/Employer</th><th>From Date</th><th>To Date</th></tr>
";
for($i=1;$i<=5;$i++){
	$employment_record_custom_data.=" <tr><td><input type='text' id='desig$i' name='desig$i' size='30'></td><td><input size='30'size='30' type='text' id='work_p$i' name='work_p$i'></td><td><input type='text' id='from_d$i' name='from_d$i' style='width:80px' dojoType='dijit.form.DateTextBox'constraints=\"{datePattern:'yyyy-MM-dd'}\" promptMessage='yyyy-MM-dd'  ></td><td><input type='text' style='width:80px' name='to_d$i' id='to_d$i' dojoType='dijit.form.DateTextBox' constraints=\"{datePattern:'yyyy-MM-dd'}\" promptMessage='yyyy-MM-dd' ></td></tr>";
}

$employment_record_custom='
<div dojoType="dijit.form.DropDownButton">
	<span>
      Click to Add Employment Records
   </span>
  	<script type="dojo/method" event="onClick" args="evt">
		var seperator="#";
      for(i = 1; i <= 5; i++){
			var record=document.getElementById("emp_rec"+i).value;
			if(record){
				var record_arr=record.split(seperator);
      		document.getElementById("desig"+i).value=record_arr[0];
            document.getElementById("work_p"+i).value=record_arr[1];
            document.getElementById("from_d"+i).value=record_arr[2];
            document.getElementById("to_d"+i).value=record_arr[3];
			}
		}
	</script>
   <div dojoType="dijit.TooltipDialog" id="emp_records_div">
		<table>
		'.$employment_record_custom_data.'
		</table>
		<br/>
      <button dojoType="dijit.form.Button" type="submit">
         OK
  			<script type="dojo/method" event="onClick" args="evt">
				var seperator="#";
            var i;
            for(i = 1; i <= 5; i++){
            	var desig=document.getElementById("desig"+i).value;
            	var work_p=document.getElementById("work_p"+i).value;
            	var from_d=document.getElementById("from_d"+i).value;
            	var to_d=document.getElementById("to_d"+i).value;
					document.getElementById("emp_rec"+i).value=desig+seperator+work_p+seperator+from_d+seperator+to_d;
				}
			</script>
      </button>
   </div>
</div>
<br/>
';
 


/*Auto generated by form_gen.php*/
$fields=array(

"received"=>array(
		"length"=>"77",
		"dojoType"=>"dijit.form.NumberTextBox",
		"type"=>"hidden",
		"required"=>"false",
		"label"=>"Received",
		"value"=>""),	

"status"=>array(
		"length"=>"77",
		"dojoType"=>"dijit.form.NumberTextBox",
		"type"=>"hidden",
		"required"=>"false",
		"label"=>"Payment Status",
		"value"=>""),	

"downloaded"=>array(
		"length"=>"77",
		"dojoType"=>"dijit.form.NumberTextBox",
		"type"=>"hidden",
		"required"=>"false",
		"label"=>"Payment Status",
		"value"=>""),	

"rec_id"=>array(
		"length"=>"77",
		"dojoType"=>"dijit.form.NumberTextBox",
		"type"=>"hidden",
		"required"=>"false",
		"label"=>"Rec id",
		"value"=>""),	

/*
"registration_no"=>array(
		"length"=>"56",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Registration no",
		"value"=>""),	
"index_no"=>array(
		"length"=>"56",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Index no",
		"value"=>""),	
"registration_type"=>array(
		"length"=>"140",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Registration type",
		"value"=>""),	
 */
"program"=>array(
		"length"=>"255",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"true",
		"section"=>"The course which you going to apply",
		"inner"=>$program_inner,
		"label"=>"Program",
		"value"=>""),	

"first_name"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"section"=>"Tell us about you",
		"autocomplete"=>"on",
		"label"=>"First Name",
		"value"=>""),	
"middle_names"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Middle Names",
		"value"=>""),	
"last_name"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Last Name",
		"value"=>""),	
"title"=>array(
		"length"=>"55",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"true",
		"inner"=>$title_inner,
		"label"=>"Title",
		"value"=>"MR"),	
"NIC"=>array(
		"length"=>"150",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"regExp"=>"\b[0-9]{9}[vV]{1}\b",
		"label"=>"NIC Number",
		"value"=>""),	
"DOB"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.DateTextBox",
		"required"=>"true",
		"label"=>"Date of Birth",
		"value"=>""),	
"gender"=>array(
		"length"=>"40",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"true",
		"inner"=>$sex_inner,
		"label"=>"Gender",
		"value"=>"M"),	
/*
"confirm"=>array(
		"length"=>"280",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Confirm",
		"value"=>""),	
 */
/*
"degree_title_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"section"=>"University Education (Degree 1)",
		"label"=>"Degree Title",
		"value"=>""),	
"university_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"University",
		"value"=>""),	
"year_of_award_1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Year of award",
		"value"=>""),	
"class_1"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Class/GPA",
		"value"=>""),	
"date_entered_1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.DateTextBox",
		"required"=>"true",
		"label"=>"Date Entered",
		"value"=>""),	
"date_left_1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.DateTextBox",
		"required"=>"true",
		"label"=>"Date Left",
		"value"=>""),	
"subject1_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Subject 1",
		"value"=>""),	
"subject2_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Subject 2",
		"value"=>""),	
"subject3_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Subject 3",
		"value"=>""),	
"subject4_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Subject 4",
		"value"=>""),	
	
"degree_title_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"section"=>"University Education (Degree 2)",
		"label"=>"Degree Title",
		"value"=>""),	
"university_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"University",
		"value"=>""),	
"year_of_award_2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Year of Award",
		"value"=>""),	
"class_2"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Class/GPA",
		"value"=>""),	

"date_entered_2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.DateTextBox",
		"required"=>"false",
		"label"=>"Date Entered",
		"value"=>""),	

"date_left_2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.DateTextBox",
		"required"=>"false",
		"label"=>"Date left",
		"value"=>""),	
"subject1_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Subject 1",
		"value"=>""),	
"subject2_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Subject 2",
		"value"=>""),	
"subject3_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Subject 3",
		"value"=>""),	
"subject4_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Subject 4",
		"value"=>""),	
	
"edu_prof_qual1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"section"=>"Other Education/Professional Qualifications",
		"label"=>"Education/Professional Qualification 1",
		"value"=>""),	
"edu_prof_custom"=>array(
		"custom"=>"true",
		"inner"=>$edu_prof_custom,
		"label"=>"",
		),	
"edu_prof_qual2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Education/Professional Qualification 2",
		"value"=>""),	
"edu_prof_qual3"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Education/Professional Qualification 3",
		"value"=>""),	
"edu_prof_qual4"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Education/Professional Qualification 4",
		"value"=>""),	
"edu_prof_qual5"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Education/Professional Qualification 5",
		"value"=>""),	
"edu_prof_qual6"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Education/Professional Qualification 6",
		"value"=>""),	
"emp_rec1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"section"=>"Employee Records",
		"label"=>"Employment Record 1",
		"value"=>""),	
"employee_custom"=>array(
		"custom"=>"true",
		"inner"=>$employment_record_custom,
		"label"=>"",
		),	
"emp_rec2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Employment Record 2",
		"value"=>""),	
"emp_rec3"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Employment Record 3",
		"value"=>""),	
"emp_rec4"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Employment Record 4",
		"value"=>""),	
"emp_rec5"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"type"=>"hidden",
		"label"=>"Employment Record 5",
		"value"=>""),	

"designation"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"section"=>"Information About Your Job",
		"label"=>"Designation",
		"value"=>""),	
"affiliation"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Work Place",
		"value"=>""),	
"job_description"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Job Description",
		"maxLength"=>"300",
		"value"=>""),	
 */	
"address1_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"section"=>"Permanent Address and Contact Information",
		"label"=>"Address line 1",
		"value"=>""),	
"address2_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Address line 2",
		"value"=>""),	
"address3_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Address line 3",
		"value"=>""),	
"email_1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"regExp"=>"\b[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b",
		"invalidMessage"=>"Please enter a valid email address",
		"label"=>"Email Address",
		"value"=>""),	
"mobile_1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid phone number",
		"label"=>"Mobile Phone Number",
		"value"=>""),	
"telephone_1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid phone number",
		"label"=>"Telephone Number",
		"value"=>""),
/*
"address1_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"section"=>"Office Address and Contact Information",
		"label"=>"Address line 1",
		"value"=>""),	
"address2_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Address line 2",
		"value"=>""),	
"address3_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Address line 3",
		"value"=>""),	
"email_2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"\b[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b",
		"invalidMessage"=>"Please enter a valid email address",
		"label"=>"Email Address",
		"value"=>""),	
"mobile_2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid NIC number",
		"invalidMessage"=>"Please enter a valid phone number",
		"label"=>"Mobile Phone Number",
		"value"=>""),	
"telephone_2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid phone number",
		"label"=>"Telephone Number",
		"value"=>""),	
"corresp_addr"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"true",
		"inner"=>$corresp_addr_inner,
		"label"=>"Correspondent Address",
		"value"=>"PERMANENT"),	
 */
/*
"city"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"City",
		"value"=>""),	
"state"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"State",
		"value"=>""),	
"zip"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Zip",
		"value"=>""),	
"country"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Country",
		"value"=>""),	
 */
/*
"referee_name1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"section"=>"Referee (On University Education)",
		"label"=>"Referee Name",
		"value"=>""),	
"referee_designation1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Referee Designation",
		"value"=>""),	
"referee_work_place1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Referee Work Place",
		"value"=>""),	
"referee_address1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"true",
		"label"=>"Referee Address",
		"value"=>""),	
"referee_phone1"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid phone number",
		"label"=>"Referee Phone Number",
		"value"=>""),	
"referee_email1"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"regExp"=>"\b[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b",
		"invalidMessage"=>"Please enter a valid email address",
		"label"=>"Referee Email Address",
		"value"=>""),	
"referee_name2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"section"=>"Referee (On Employment)",
		"required"=>"false",
		"label"=>"Referee Name",
		"value"=>""),	
"referee_designation2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Referee Designation",
		"value"=>""),	
"referee_work_place2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Referee Work Place",
		"value"=>""),	
"referee_address2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Referee Address",
		"value"=>""),	
"referee_phone2"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"^0[0-9]{9}$",
		"invalidMessage"=>"Please enter a valid phone number",

		"label"=>"Referee Phone Number",
		"value"=>""),	
"referee_email2"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"regExp"=>"\b[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b",
		"invalidMessage"=>"Please enter a valid email address",
		"label"=>"Referee Email Address",
		"value"=>"")
 */
/*
"password"=>array(
		"length"=>"350",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Password",
		"value"=>""),	
"functions"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.SimpleTextarea",
		"required"=>"false",
		"label"=>"Functions",
		"value"=>""),	
"last_login"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Last login",
		"value"=>""),	
"status"=>array(
		"length"=>"70",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Status",
		"value"=>""),	
"updated_time"=>array(
		"length"=>"100",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"Updated time",
		"value"=>"")	
 */
	);
if(isset($_SESSION['loged_module']) && $_SESSION['loged_module'] == 'home'){
$received_inner="
<option value='0'>0</option>
<option value='1'>1</option>
";

$fields["received"]=array(
		"length"=>"50",
		"dojoType"=>"dijit.form.ComboBox",
		"required"=>"false",
		"section"=>"Vefiry and pass the application [moderator]",
		"label"=>"Received and OK",
		"inner"=>$received_inner,
		"value"=>"");	

//Add to front of the array
//array_unshift($fields, $received);

$fields["status"]=array(
		"length"=>"150",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"false",
		"label"=>"Payment Status",
		"value"=>"");

$fields["downloaded"]=array(
		"length"=>"50",
		"dojoType"=>"dijit.form.ComboBox",
		"inner"=>$received_inner,
		"required"=>"false",
		"label"=>"Downloaded(0/1)",
		"value"=>"");	

$fields["NIC"]=array(
		"length"=>"150",
		"dojoType"=>"dijit.form.ValidationTextBox",
		"required"=>"true",
		"label"=>"NIC Number",
		"value"=>"");

}



?>
