<?php
session_start();
include_once 'config.php';
include_once 'common.php';

/*
 * Create pdf from xml
 */

require('fpdf/fpdf.php');
class xml_to_pdf extends FPDF
{
   //Load data
   function LoadData($file)
   {
      $data=array();
      $cols=array();
      //Read file lines
      $xml = simplexml_load_file($file);
      if($xml){
         $rows=sizeof($xml->student);
         for ($i=0; $i<$rows; $i++){
            /*Reading data from xml*/
            $j=0;
            foreach($xml->student[$i]->attributes() as $attribute => $value) {
               $cols[$j++]=$value;
            }
            $data[$i]=$cols;
         }
      }
      return $data;
   }
   //Heading table
   function HeadingTable($header)
   {
      $this->SetDrawColor(256);
      $this->SetFont('Arial','',13);
      foreach($header as $row)
      {
         foreach($row as $col)
         $this->Cell(60,6,$col,1);
         $this->Ln();
      }
      $this->Ln();
   }

   //Simple table
   function BasicTable($header,$data)
   {
      //Header
      $this->SetDrawColor(0);
      $this->SetFont('Arial','',12);
      foreach($header as $col)
      $this->Cell(32,7,$col,1);
      $this->Ln();
      //Data
      foreach($data as $row)
      {
         foreach($row as $col)
         $this->Cell(32,6,$col,1);
         $this->Ln();
      }
   }
   function Header()
   {
      $pdf_title1="University of Colombo School of Computing";
      $pdf_title2="Final Mark Sheet";
      $this->Image('ucsc-logo.jpg',28,8,23);
      //Arial bold 15
      $this->SetFont('Arial','B',18);
      $this->SetDrawColor(256);
      $this->SetFillColor(256);
      $this->SetTextColor(0);
      //Thickness of frame (1 mm)
      $this->SetLineWidth(1);
      //Calculate width of title and position
      $w1=$this->GetStringWidth($pdf_title1)+6;
      $this->SetX(((210-$w1)/2)+10);
      $this->Cell($w1,9,$pdf_title1,1,1,'C',1);

      $this->SetFont('Arial','B',14);
      $w2=$this->GetStringWidth($pdf_title2)+6;
      $this->SetX((210-$w2)/2);
      $this->Cell($w2,9,$pdf_title2,1,1,'C',1);
      //Title
      //Line break
      $this->Ln(10);
   }

   function Footer()
   {
      //Position at 1.5 cm from bottom
      $this->SetY(-15);
      //Arial italic 8
      $this->SetFont('Arial','I',8);
      //Text color in gray
      $this->SetTextColor(128);
      //Page number
      $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
   }
}




$examiner="Mr GKA Dias";
$courseid=$_GET['courseid'];
$coursename=$_GET['coursename'];
$exid=$_GET['exid'];
$examid=$_GET['examid'];
$exam=exam_detail($examid);

$pdf_heading=array(
array("Name of the examination",$exam['ac_year']." Year Examination ".$exam['ex_year']),
array("Batch","2006/2007"),
array("Year of the Examination",$exam['ex_year']),
array("Semester",$exam['semester']),
array("Paper Name",$papername),
array("Paper Code",$courseid),
array("First Examiner",$examiner),
array("Second Examiner",""),
array("Assignment/Paper","0/100")
);

if(file_exists(xml_marks())){
   $pdf=new xml_to_pdf();
   $header=$GLOBALS['header'];
   $data=$pdf->LoadData(xml_marks());
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->HeadingTable($pdf_heading);
   $pdf->BasicTable($header,$data);
   $pdf->Output();
}else{
   echo "XML DB not found!";
}

?>
