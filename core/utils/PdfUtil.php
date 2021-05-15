<?php

namespace core\utils;

use core\libs\TCPDF\Pdf;

class PdfUtil {
	public static function generatePDF($htmlFilePath, $pdfFilePath) {
		$pdf = new Pdf ( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );
		$pdf->AddPage ();
		$html = file_get_contents ( $htmlFilePath );
		$pdf->writeHTML ( $html, true, false, true, false, '' );
		$pdf->Output ( $pdfFilePath, 'F' );
	}
}