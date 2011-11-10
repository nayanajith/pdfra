<?php
include(MOD_CLASSES."/offline_voucher_class.php");

//Change offline payment status to PENDING
exec_query("UPDATE ".$GLOBALS['MOD_S_TABLES']['convocation_reg']." SET pay_offline_status='PENDING'  WHERE reg_no='".strtoupper($_SESSION['username'])."'",Q_RET_MYSQL_RES);

//Acquire payer information
$reg_arr	=exec_query("SELECT * FROM ".$GLOBALS['MOD_S_TABLES']['convocation_reg']." WHERE reg_no='".strtoupper($_SESSION['username'])."'",Q_RET_ARRAY);
$reg_arr	=$reg_arr[0];

//Build the array which is a parameter of the voucher generator
$payment_info=array(
   "RS ".$payment_category[$reg_arr['category']][0].".00",
   $payment_category[$reg_arr['category']][1],
   $reg_arr['name_in_english'],
   $reg_arr['index_no'],
	$reg_arr['nic']
);

//Generic information of the convocation payment voucher
$acc_no		="086-1001-511-89665";
$inv_title	="POSTGRADUATE CONVOCATION 2011";
$purpose		="CONVOCATION REGISTRATION FEE";
	
//Generate the voucher 
//__construct($payer_info,$acc_no,$inv_title)
$voucher=new Voucher($payment_info,$acc_no,$inv_title,$purpose);

//Acquire pdf document
$pdf=$voucher->getPdf();

$pdf->Output('payment_voucher.pdf', 'I');
//$pdf->Output("/tmp/tt.pdf", 'F');
//return $pdf_file;

?>
