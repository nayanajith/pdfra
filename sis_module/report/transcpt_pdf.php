<?php
if(isset($_REQUEST['index_no']) ){
include(MOD_CLASSES."/transcript1_pdf_class.php");
//Generate the transcript
$transcript=new Transcript($_REQUEST['index_no']);

//Acquire pdf document
$pdf=$transcript->getPdf();

$pdf->Output('transcript.pdf', 'I');
//$pdf->Output("/tmp/tt.pdf", 'F');
//return $pdf_file;
}
?>
