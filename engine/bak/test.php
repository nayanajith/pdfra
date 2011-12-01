<?php
$row=array();
echo '
<style>
   th{
      text-align:left;   
   }
</style>
<table border="1" style="border-collapse:collapse;width:800px" cellpadding="10">
<tr>
 <td colspan="2" align="center" >
    <h1>University of Colombo School of Computing</h1>
    <h3>University of Colombo – Sri Lanka</h3>
</td>
</tr>
<tr>
   <td align="center" colspan="2">
      <h3>MASTER OF COMPUTER SCIENCE – '.$year.'</h3>
      <h4>APPLICATION FORM</h4>
   </td>
</tr>
<tr>
   <td colspan="2">
      <b >Name in Full:</b>'.$row['first_name'].' '.$row['first_name'].' '.$row['first_name'].'
   </td>
</tr>
<tr>
   <td width="50%">
   <h4>Permanent Address:</h4>   
'.$row['address1_1'].'<br/>'.$row['address2_1'].'<br/>'.$row['address3_1'].'
   <table width="100%">
      <tr><th>Mobile Phone</th><td>'.$row['mobile_1'].'</td></tr>   
      <tr><th>Fixed Phone</th><td>'.$row['telephone_1'].'</td></tr>   
      <tr><th>E-mail</th><td>'.$row['email_1'].'</td></tr>   
   </table>
   </td>
   <td width="50%">
   <h4>Office Address:</h4>   
'.$row['address1_2'].'<br/>'.$row['address2_2'].'<br/>'.$row['address3_2'].'
   <table width="100%">
      <tr><th>Mobile Phone</th><td>'.$row['mobile_2'].'</td></tr>   
      <tr><th>Fixed Phone</th><td>'.$row['telephone_2'].'</td></tr>   
      <tr><th>E-mail</th><td>'.$row['email_2'].'</td></tr>   
   </table>
   </td>
</tr>
   <td>
      <b>Address for Correspondence :</b> Permanent / Office <br/> 
         (Note :- All correspondence will be sent to this address.)
   </td>
   <td>
      <table width="100%">
         <tr><th>National ID / Passport</th><td>'.$row['nic'].'</td></tr>   
         <tr><th>Date of Birth</th><td>'.$row['DOB'].'</td></tr>   
         <tr><th>Gender</th><td>'.$row['sex'].'</td></tr>   
      </table>
   </td>
<tr>
   <td colspan="2">
      <b>Designation :</b>'.$row['designation'].'
   </td>
</tr>
<tr>
   <td colspan="2">
      <b>Work Place :</b>'.$row['affiliation'].'
   </td>
</tr>
<tr>
   <td colspan="2">
      <b>Job Description :</b>'.$row['job_description'].'
   </td>
</tr>
<tr>
   <td>
   <h4>University Education:</h4>   
      <table width="100%">
         <tr><th>Degree Title:</th><td>'.$row['degree_title_1'].'</td></tr>   
         <tr><th>Year of Award</th><td>'.$row['year_of_award_1'].'</td></tr>   
         <tr><th>Class/GPA</th><td>'.$row['class_1'].'</td></tr>   
         <tr><th>Date Entered</th><td>'.$row['date_entered_1'].'</td></tr>   
         <tr><th>Date Left</th><td>'.$row['date_left_1'].'</td></tr>   
         <tr><th colspan="2">Degree Subjects:</th></tr>   
         <tr><td colspan="2">
               <ol>
                  <li>'.$row['subject1_1'].'</li>
                  <li>'.$row['subject2_1'].'</li>
                  <li>'.$row['subject3_1'].'</li>
                  <li>'.$row['subject4_1'].'</li>
               </ol>
         </td></tr>
      </table>
   </td>
   <td>
   <h4>University Education:</h4>   
         <tr><th>Degree Title:</th><td>'.$row['degree_title_2'].'</td></tr>   
         <tr><th>Year of Award</th><td>'.$row['year_of_award_2'].'</td></tr>   
         <tr><th>Class/GPA</th><td>'.$row['class_2'].'</td></tr>   
         <tr><th>Date Entered</th><td>'.$row['date_entered_2'].'</td></tr>   
         <tr><th>Date Left</th><td>'.$row['date_left_2'].'</td></tr>   
         <tr><th colspan="2">Degree Subjects:</th></tr>   
         <tr><td colspan="2">
               <ol>
                  <li>'.$row['subject1_2'].'</li>
                  <li>'.$row['subject2_2'].'</li>
                  <li>'.$row['subject3_2'].'</li>
                  <li>'.$row['subject4_2'].'</li>
               </ol>
         </td></tr>
      </table>
   </td>
</tr>
<tr>
   <td colspan="2">
      <h4>Other Educational / Professional Qualifications :</h4>
      <table width="100%">
         <tr><th></th><th>Qualification/Certificate</th><th>Institution/Organization</th><th>Date of Award</th><th>Duration</th></tr>
         <tr><td>1.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual1']).'</td></tr>
         <tr><td>2.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual2']).'</td></tr>
         <tr><td>3.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual3']).'</td></tr>
         <tr><td>4.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual4']).'</td></tr>
         <tr><td>5.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual5']).'</td></tr>
         <tr><td>6.</td><td>'.str_replace("#","</td><td>",$row['edu_prof_qual6']).'</td></tr>
      </table>
   </td>
</tr>
<tr>
   <td colspan="2">
      <h4>Employment Record :</h4>
      <table width="100%">
         <tr><th></th><th>Designation</th><th>Work Place/Employer</th><th>From Date</th><th>To Date</th></tr>
         <tr><td>1.</td><td>'.str_replace('#','</td><td>',$row['emp_rec1']).'</td></tr>
         <tr><td>2.</td><td>'.str_replace('#','</td><td>',$row['emp_rec2']).'</td></tr>
         <tr><td>3.</td><td>'.str_replace('#','</td><td>',$row['emp_rec3']).'</td></tr>
         <tr><td>4.</td><td>'.str_replace('#','</td><td>',$row['emp_rec4']).'</td></tr>
         <tr><td>5.</td><td>'.str_replace('#','</td><td>',$row['emp_rec5']).'</td></tr>
      </table>
   </td>
</tr>
<tr>
   <td>
   <h4>Referee (On University Education):</h4>   
      <table width="100%">
         <tr><th>Name:</th><td>'.$row['refree_name1'].'</td></tr>   
         <tr><th>Designation</th><td>'.$row['refree_designation1'].'</td></tr>   
         <tr><th>Work Place</th><td>'.$row['refree_work_place1'].'</td></tr>   
         <tr><th>Address</th><td>'.$row['referee_address1'].'</td></tr>   
         <tr><th>Phone</th><td>'.$row['referee_phone1'].'</td></tr>   
         <tr><th>E-mail</th><td>'.$row['referee_email1'].'</td></tr>   
      </table>
   </td>
   <td>
   <h4>Referee (On Employment):</h4>   
      <table width="100%">
         <tr><th>Name:</th><td>'.$row['refree_name2'].'</td></tr>   
         <tr><th>Designation</th><td>'.$row['refree_designation2'].'</td></tr>   
         <tr><th>Work Place</th><td>'.$row['refree_work_place2'].'</td></tr>   
         <tr><th>Address</th><td>'.$row['referee_address2'].'</td></tr>   
         <tr><th>Phone</th><td>'.$row['referee_phone2'].'</td></tr>   
         <tr><th>E-mail</th><td>'.$row['referee_email2'].'</td></tr>   
      </table>
   </td>
</tr>
<tr>
   <td  align="center" style="border:0px;" colspan="2">
      <h4>For Office Use Only</h4>
   </td>
</tr>
<tr>
   <td>
      <table width="100%">
         <tr><td>Reference No :</td><td>&nbsp;</td></tr>  
         <tr><td>Attended Interview :</td><td>&nbsp;</td></tr>
         <tr><td>Aptitude Test: </td><td>Pass / Fail</td></tr>
      </table>
   </td>
   <td>
      <table width="100%">
         <tr><td>Called for Interview :</td><td>&nbsp;</td></tr>
         <tr><td>Selected For ( MIT / MCS / MSc. IS ):</td><td>&nbsp;</td></tr>
         <tr><td>Receipt No :</td><td>&nbsp;</td></tr>
      </table>
   </td>
</tr>
<tr>
   <td colspan="2">
      <h4>Remarks :</h4>
   </td>
</tr>
</table>
';
