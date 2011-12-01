<?php
if(!isset($_POST['MName']) and !isset($_POST['MDetails']) and !isset($_POST['MTime']) ){
  getMName();
} else {
   $MName = $_POST['MName'];
   $MDetails  = $_POST['MDetails']; 
   $MTime  = $_POST['MTime']; 
   $date = $_POST['date'];
   $no = $_POST['no'];
     
   require_once('tcpdf/config/lang/eng.php');
   require_once('tcpdf/tcpdf.php');
   include_once("database.php");
   
   
   $conn = openDB();
 
   global $DIssue;
   $_POST['DIssue']=date("d/m/Y");
   
class Attendance extends TCPDF {
   function __construct() {
   
       parent::__construct("P", "mm", "A4", true);
      $this->SetAutoPageBreak(TRUE,15);
      $this->SetFont("vera", "B",12);
      $this->SetFooterMargin(5);
      }
   
function AddPage($DIssue){
     global $pdf;
    global $DIssue;
    global $MDetails;
    parent::AddPage($DIssue);
   
   
    //$this->Ln(5);
    $txt = "STAFF ATTENDANCE";
    $this->SetFont("vera", "B",10);
     $this->Write(5,$txt);
    $this->SetFont("vera", "B",10);
    
    $this->Ln(5);
    
    $this->Cell(0, 0, '', 'T', 0, 'C');
    $cPos = $this->GetY() + 5;
    $this->SetY($cPos); 
    //printRowTitles();
    $pdf->SetFont("freemono", "",11);
    
    ///
    //$pdf->Ln(5);
    //$base = 0;
    //for($i=0; $i<1; $i++,$base+= 140){
       //$pdf->WriteT($base + 10,"Name");
       //$pdf->WriteT($base+ 150,"Signature");
    //}
    //$pdf->Line();
    //PrintLables();
    
    
    //
   }
    ////////////////////////////




/////////////////////   
function Footer() {
   global $pdf;
   $pdf->SetFont("vera", "B",8);
       $this->SetY(-15);
      $text = 'Page '.$pdf->PageNo().' of {nb}';
        $pdf->WriteT(240,$text);
      
    }

     
   function Line(){
     $this->Ln(5);
    $this->Cell(0, 0, '', 'T', 0, 'C');
   }
   
   function WriteR($text){
     $pos = $this->getPageWidth() - $this->GetStringWidth($text) - 15;
     $this->SetX($pos);
    $this->Write(5,$text);
    }
   
   function WriteC($text){
     $pos = ($this->getPageWidth() - $this->GetStringWidth($text) - 15)/2;
     $this->SetX($pos);
    $this->Write(5,$text);
    }
   
   function WriteT($pos,$text){
      $this->SetX($pos);
     $this->Write(5,$text);
   }
}
   

   
   $pdf = new Attendance(); 
   $pdf->AliasNbPages();
   $pdf->AddPage($_POST['DIssue']);
   //Front page only
   printRowTitles();
   PrintLables();
   printStaffInfor($result_new,$conn);
   //$pdf->AddPage($_POST['DIssue']);

   printStaffLeave ($result_new1,$conn);
   $pdf->Output();

}

function printStaffInfor($result_new,$conn){
     global $pdf;
    global $MName;
   $pdf->SetFont("freemono", "",12);
    if ($MName==1 or $MName==2 or $MName==3){
    
    $result_new = mysql_query("SELECT distinct e.Name,e.Designation,d.other FROM employee e, mettings m, designation_other d,rank r where e.EmpNo = d.EmpNo and m.Mid=d.Mid and m.Mid='".$MName."' and e.Designation=r.Designation and e.Leave_State not like 'Overseas' ORDER BY r.rank,e.EmpNo");
    
    while($database = mysql_fetch_row($result_new)) {
                        
                        $text_name = $database[0] ;
                        $text_Designation = $database[1] ;
                        $text_Other = $database[2] ;
                        $pdf->SetFont("freemono", "",12);
                        $pdf->Write(5, $text_name);
                        $pdf->SetFont("freemono", "",10);
                        $text_sep = ",";
                        $pdf->Write(6, $text_sep);
                        $pdf->SetFont("freemono", "",11);
                        if ($database[2]==null){
                        $pdf->Write(5, $text_Designation);
                        }else{
                        $pdf->Write(5,$text_Other);
                           }
                        $pdf->Line();
                     }
                     
                     
   //
   }else {
       $text = "Wrong Meeting Selection: " . $MName;
      $pdf->Write(5, $text);
      $pdf->Ln(5);
         }
   
}

   
   //$pdf->Ln(5);
   //$pdf->Ln(5);
   
   
function printStaffLeave($result_new1,$conn){
     global $pdf;
    global $MName;
       //$pdf->Line();
   
   //$pdf->Line();
   //$pdf->Ln(5);
   $result_new1 = mysql_query("SELECT distinct e.Name,e.Designation FROM employee e, mettings m, designation_other d,rank r where e.EmpNo = d.EmpNo and m.Mid=d.Mid and m.Mid='".$MName."' and e.Designation=r.Designation and e.Leave_State like 'Overseas' ORDER BY r.rank,e.EmpNo");
   $database2 = mysql_fetch_row($result_new1);
   
      if ($database2==null){
                  //$pdf->SetFont("freemono", "",12);
                  //$text = "ssssssss" ;
                  //$pdf->Write(5, $text);
                  
      }else{
                  $pdf->SetFont("freemono", "",12);
                  // if ($MName==1 or $MName==2 or $MName==3){
                   if ($MName==1 or $MName==2 or $MName==3){
                  $pdf->SetFont("freemono","B","U",12);
                  $text = "Staff on Leave:" ;
                  $pdf->Write(5, $text);
                  $pdf->SetFont("freemono", "",12);
   
         $result_new1 = mysql_query("SELECT distinct e.Name,e.Designation FROM employee e, mettings m, designation_other d,rank r where e.EmpNo = d.EmpNo and m.Mid=d.Mid and m.Mid='".$MName."' and e.Designation=r.Designation and e.Leave_State like 'Overseas' ORDER BY r.rank,e.EmpNo");
                while($database = mysql_fetch_row($result_new1)) {
                        $text_name = $database[0] ;
                        $text_Designation = $database[1] ;
                        //$text_Other = $database[2] ;
                        $pdf->SetFont("freemono", "",12);
                        $pdf->Write(5, $text_name);
                        $pdf->SetFont("freemono", "",10);
                        $text_sep = "-";
                        $pdf->Write(5, $text_sep);
                        //if ($database[2]==null){
                        $pdf->SetFont("freemono", "",10);
                        $pdf->Write(5, $text_Designation);
                        if (end($database))
                        {
                        $text_sep = ".";
                        $pdf->Write(5, $text_sep);
                        } else {
                        $text_sep = ",";
                        $pdf->Write(5, $text_sep);
                        }
                        
                                    
                                 }
            }
   }   
}   
function printRowTitles(){
     global $pdf;
    global $MName;
    global $MDetails;
    global $MTime;
    global $DIssue;
    $pdf->SetFont("freemono","B",12);
    $Date=$_POST['date'];
    //$Date=$_POST['DIssue']=date("d/m/Y");
    $MName = $_POST['MName'];
    $MDetails  = $_POST['MDetails']; 
    $MTime  = $_POST['MTime'];
    
    if ($MName==1){
    
    $result = mysql_query("select id from mhistory_iud where id IN (select max(id) From mhistory_iud)");
    $database = mysql_fetch_row($result);
    $text_id0 = $database[0] ;
    //$text_id=$text_id0+1;
    $text_id=$_POST['no'];
    $pdf->Write(5,$text_id);

          if ($text_id%10==1) {
          $text = "st";
          $pdf->Write(3,$text);
          }else if ($text_id%10==2){
          $text = "nd";
          $pdf->Write(3,$text);
          }else if ($text_id%10==3){
          $text = "rd";
          $pdf->Write(3,$text);
          }else{
          $text = "th";
          $pdf->Write(3,$text);
          }
    
    $text = "MEETING OF THE BOARD OF STUDY FOR INTERNAL UNDERGRADUATE DEGREES OF UNIVERSITY OF COLOMBO SCHOOL OF COMPUTING HELD ON ";
    $pdf->Write(5, $text);
     
    
    } else if ($MName==2){
    
    $result = mysql_query("select id from mhistory_rhd where id IN (select max(id) From mhistory_rhd)");
    $database = mysql_fetch_row($result);
    $text_id0 = $database[0] ;
    //$text_id=$text_id0+1;
    $text_id=$_POST['no'];
    $pdf->Write(5,$text_id);

          if ($text_id%10==1) {
          $text = "st";
          $pdf->Write(3,$text);
          }else if ($text_id%10==2){
          $text = "nd";
          $pdf->Write(3,$text);
          }else if ($text_id%10==3){
          $text = "rd";
          $pdf->Write(3,$text);
          }else{
          $text = "th";
          $pdf->Write(3,$text);
          }
    
    $text = "MEETING OF THE BOARD OF STUDY FOR FOR RESEARCH AND HIGHER DEGREES OF UNIVERSITY OF COLOMBO SCHOOL OF COMPUTING HELD ON" ;
    $pdf->Write(5, $text);
    
    } else if ($MName==3){
    
    $result = mysql_query("select id from mhistory_eep where id IN (select max(id) From mhistory_eep)");
    $database = mysql_fetch_row($result);
    $text_id0 = $database[0] ;
    //$text_id=$text_id0+1;
    $text_id=$_POST['no'];
    $pdf->Write(5,$text_id);

          if ($text_id%10==1) {
          $text = "st";
          $pdf->Write(3,$text);
          }else if ($text_id%10==2){
          $text = "nd";
          $pdf->Write(3,$text);
          }else if ($text_id%10==3){
          $text = "rd";
          $pdf->Write(3,$text);
          }else{
          $text = "th";
          $pdf->Write(3,$text);
          }
          
    $text = "MEETING OF THE BOARD OF STUDY EXTERNAL & EXTENSION PROGRAMMES HELD ON";
    $pdf->Write(5, $text);
    
    
    
    
    }else{
    $text = "Sellect the meeting";
    $pdf->Write(5, $text);
    }
     
    $text_Date=$Date ;
    $pdf->Write(5, $text_Date);
    $text = "AT ".$MTime." IN THE";
    $pdf->Write(5, $text);
    $text_Venue=$MDetails;
    $pdf->Write(5, $text_Venue);
    $text = "OF UCSC BUILDING COMPLEX";
    $pdf->Write(5, $text);
   
    /* 
    $pdf->Ln(5);
    $base = 0;
    for($i=0; $i<1; $i++,$base+= 140){
       $pdf->WriteT($base + 10,"Name");
       $pdf->WriteT($base+ 150,"Signature");
    }
    $pdf->Line();*/
    
    
    
}
/////////////
function PrintLables(){
     global $pdf;
    //global $DIssue;
    //global $MDetails;
    //parent::AddPage($DIssue);
   
   
    //$this->Ln(5);
    //$txt = "STAFF ATTENDANCE";
    //$this->SetFont("vera", "B",10);
     //$this->Write(5,$txt);
    //$this->SetFont("vera", "B",10);
    //$this->Ln(5);
    //$this->Cell(0, 0, '', 'T', 0, 'C');
    //$cPos = $this->GetY() + 3;
    //$this->SetY($cPos); 
    //printRowTitles();
    $pdf->SetFont("vera", "B",10);
    
    ///
    $pdf->Ln(5);
    $base = 0;
    for($i=0; $i<1; $i++,$base+= 140){
       $pdf->WriteT($base + 10,"Name");
       $pdf->WriteT($base+ 170,"Signature");
    }
    $pdf->Line();
    //
   }



/////
function getMName(){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UCSC Staff List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<!--
<a href="http://www.findmorepro.de/" target="blank" >
<img alt="Website counter" hspace="0" vspace="0" border="0" src="http://countermad.com/1252598-4803308DFF1AD98C429DF46CD2ADEE55/counter.img?theme=0&digits=4"/>
</a>
<noscript><br/><a href="http://www.findmorepro.de/">Free Counter</a>
<br>The following text will not be seen after you upload your website, please keep it in order to retain your counter functionality <br> 
<a href="http://www.blackjack-deluxe.com/notplay.html" target="_blank">blackjack betting strategies</a></noscript>

-->


<form action="list_l.php" method="post">

<p> <FONT color="red" size="5">UCSC Staff Attendance List</FONT></p>
<p> <FONT color="blue" size="4">Metings of UCSC</FONT></p>


<p><FONT color="green" size="3">BOARD OF STUDY FOR INTERNAL UNDERGRADUATE DEGREES-</FONT><FONT color="black" size="4">IUD</FONT></p>
<p><FONT color="green" size="3">BOARD OF STUDY FOR RESEARCH AND HIGHER DEGREES-</FONT><FONT color="black" size="4">RHD</FONT></p>
<p><FONT color="green" size="3">BOARD OF STUDY FOR EXTERNAL & EXTENSION PROGRAMMES-</FONT><FONT color="black" size="4">EEP</FONT></p>

<table>
<FONT color="black" size="3">
<tr>
<td>Enter the Meeting Type</td>
<td>   <select name="MName">
         <option value="0"selected>(please select:)</option>
         <option value="1">IUD</option>
         <option value="2">RHD</option>
         <option value="3">EEP</option>
         
   </select></td>
</tr>
<tr>
<td>Allocate location</td>

<td>   <select name="MDetails">
         <option value="0"selected>(please select:)</option>
         <option value="Board Room of the 3rd Floor">Board Room</option>
         <option value="ADMTC Lab-A">ADMTC Lab-A</option>
         <option value="MIni-Auditorium">Mini-Auditorium</option>
         <option value="W004">W004</option>
         <option value="W005">W005</option>
         <option value="Master's Lab">MSC Lab</option>
         
      </select></td>
</tr>
<tr>
<td>Time</td>

<td>   <select name="MTime">
         <option value="0"selected>(please select:)</option>
         <option value="8.00AM">8.00AM</option>
         <option value="8.30AM">8.30AM</option>
         <option value="9.00AM">9.00AM</option>
         <option value="9.30AM">9.30AM</option>
         <option value="10.00AM">10.00AM</option>
         <option value="10.30AM">10.30AM</option>
         <option value="11.00AM">11.00AM</option>
         <option value="11.30AM">11.30AM</option>
         <option value="12.00 Noon">12.00 Noon</option>
         <option value="12.30 PM">12.30 PM</option>
         <option value="1.00PM">1.00PM</option>
         <option value="1.30PM">1.30PM</option>
         <option value="2.00PM">2.00PM</option>
         <option value="2.30PM">2.30PM</option>
         <option value="3.00PM">3.00PM</option>
         <option value="3.30PM">3.30PM</option>
         <option value="4.00PM">4.00PM</option>
         <option value="4.30PM">4.30PM</option>
         <option value="5.00PM">5.00PM</option>
         
      </select></td>
</tr>
<tr><td>Date</td><td><input type=text name=date></td></tr>
<tr><td>No</td><td><input type=text name=no></td></tr>

<tr>
<td><input name="Button" type="submit" value="Submit"></td>
</tr>
</FONT>
</table>
</form>
</body>
</html>

<?php
}
?>
