<?php
set_time_limit(200);
require_once(A_LIB.'/tcpdf/config/lang/eng.php');
require_once(A_LIB.'/tcpdf/tcpdf.php');

/* Extend tcpdf to go for further customization of header and footer and more  */
class MYPDF extends TCPDF {

	/*Array to store header info*/
	protected $header_info=array();

	public function Header() {
        // full background image
        // store current auto-page-break status
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
		  //bit_cert_bak.jpg	bit_cert_front.jpg
        $img_file = MOD_RESOURCE.'/bit_cert_front.jpg';
        $this->Image($img_file, 0, 0, 297, 420, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
    }

	public function degree_cert_config(){
		/*set document information*/ 
		$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('University of Colombo School of Computing');
		$this->SetTitle('Selection tesst admission');
		$this->SetSubject('Year 2011');
		$this->SetKeywords('UCSC');

		/*set default header data*/ 
		$PDF_HEADER_LOGO_WIDTH=20;
		$PDF_HEADER_TITLE			='Markbook\naa';

      /*set header and footer fonts*/ 
		$PDF_FONT_NAME_MAIN		='helvetica';
		$PDF_FONT_SIZE_MAIN		=10;
		$PDF_FONT_NAME_DATA		='helvetica';
		$PDF_FONT_SIZE_DATA		=8;
		$this->setHeaderFont(Array($PDF_FONT_NAME_MAIN, '', $PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array($PDF_FONT_NAME_DATA, '', $PDF_FONT_SIZE_DATA));

		/*set default monospaced font*/ 
		$PDF_FONT_MONOSPACED		='courier';
		$this->SetDefaultMonospacedFont($PDF_FONT_MONOSPACED);

		/*set margins*/
		$PDF_MARGIN_LEFT			=15;
		$PDF_MARGIN_TOP			=25; 
		$PDF_MARGIN_RIGHT			=10;
		$this->SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT);
		
		$PDF_MARGIN_HEADER		=5;
		$PDF_MARGIN_FOOTER		=5;
		$this->SetHeaderMargin($PDF_MARGIN_HEADER);
		$this->SetFooterMargin($PDF_MARGIN_FOOTER);
		
		/*set auto page breaks*/
		$PDF_MARGIN_BOTTOM		=10;
		$this->SetAutoPageBreak(TRUE, $PDF_MARGIN_BOTTOM);
		
    /*set image scale factor*/
		$PDF_IMAGE_SCALE_RATIO	=1.25;
		$this->setImageScale($PDF_IMAGE_SCALE_RATIO);
		
		/*set some language-dependent strings*/
		//$this->setLanguageArray($l);
		
		/* set font*/
		$this->SetFont('helvetica', '', 20);
	  $this->AddPage();
	}
}


class Degree_cert{

	/*date of the examination*/
	protected $date		='25-04-2010';


	/*admission issued date by the AR/Exam*/
	protected $pdf;

	/*
	 * @param page_format		: A4,A5,B4
	 * @param page_orientation	: P,L 
	 */
	public function __construct($page_format=null,$page_orientation=null){

		$this->date			=date('d-m-Y');

		/*Pdf generator page setup*/
		$PDF_PAGE_ORIENTATION	='P';//(L,P)
		$PDF_PAGE_FORMAT			='A3';
    
    if($page_format != null){
		  $PDF_PAGE_FORMAT	=$page_format;
    }
    if( $page_orientation != null){
		  $PDF_PAGE_ORIENTATION	= $page_orientation;
    }

		$PDF_UNIT				='mm';//mm,in,pt,cm
		$UNICODE					=true; 
		$ENCODING				='iso-8859-1'; 
		$DISKCACHE				=false;//if TRUE reduce the RAM memory

		/*return pdf generation object*/
		$this->pdf = new MYPDF($PDF_PAGE_ORIENTATION, $PDF_UNIT, $PDF_PAGE_FORMAT, $UNICODE, $ENCODING, $DISKCACHE);
		$this->pdf->degree_cert_config();

	}

	public function getPdf(){
		return $this->pdf;	
	}


	public function include_content($name_in_en,$date_in_ta,$name_in_si,$date_in_si,$name_in_ta,$date_in_ta){
		/*Add a page to the sheet*/
		$this->pdf->SetFont('lklug', 'B', 20);
		$this->pdf->SetFont('iskpota', 'B', 20);
		$this->pdf->SetFont('fmmalithi', 'B', 20);
		//$this->pdf->SetFont('helvetica', '', 9);
		/*write table to the sheet*/
		//$content='<meta content="text/html; charset=utf-8" http-equiv="Content-Type">'.$name_in_si;
		//$this->pdf->writeHTML($content, true, false, false, false, 'L');
		$this->pdf->Cell(0, 170, $name_in_si, 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
}
?>
