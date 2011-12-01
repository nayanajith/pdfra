<?php
define('FPDF_FONTPATH',A_LIB.'/ufpdf/font/');
require(A_LIB.'/ufpdf/ufpdf.php');


class Degree_cert{

   public function __construct($page_format=null,$page_orientation=null){
      $pdf = new UFPDF();
$pdf->Open();
$pdf->SetTitle("UFPDF is Cool.\nŨƑƤĐƒ ıš ČŏōĹ");
$pdf->SetAuthor('Steven Wittens');
$pdf->AddFont('LucidaSansUnicode', '', 'lsansuni.php');
$pdf->AddPage();
$pdf->SetFont('LucidaSansUnicode', '', 32);
$pdf->Write(12, "UFPDF is Cool.\n");
$pdf->Write(12, "ŨƑƤĐƒ");
$pdf->Write(12, "ıš ČŏōĹ.\n");
$pdf->Close();
$pdf->Output('unicode.pdf', 'F');

   }

   public function include_content($name_in_en,$date_in_ta,$name_in_si,$date_in_si,$name_in_ta,$date_in_ta){
   }
}
?>
