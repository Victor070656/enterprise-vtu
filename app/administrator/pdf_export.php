<?php
require_once("../db.php");


$db_handle = new DBController();
$result = $db_handle->runQuery("SELECT firstname,lastname,phone,email FROM users");
$header = $db_handle->runQuery("SELECT `COLUMN_NAME`  
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='recharge' 
    AND `TABLE_NAME`='users'");
    
   

require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);		
foreach($header as $heading) {
	foreach($heading as $column_heading)
		$pdf->Cell(35,11,$column_heading,0);
}
foreach($result as $row) {
	$pdf->SetFont('Arial','',11);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(35,11,$column,0);
}
$pdf->Output();


?>