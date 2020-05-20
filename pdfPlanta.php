<?php
    session_start();

    require_once "config/bd.php";
    require('fpdf/fpdf.php');
    //require('fpdf/makefont/makefont.php');
    //MakeFont('c:\\Windows\\Fonts\\Times.ttf','ISO-8859-1');


    $id = $_GET['pdf'];	
    $record = mysqli_query($db, "SELECT * FROM plantas WHERE id = $id");
    $planta = mysqli_fetch_array($record);
    

    class PDF extends FPDF
    {
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    }
    
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddFont('Times','','Times.php');
    $pdf->AddPage();
    $pdf->SetFont('Times','',9);

    $pdf->Cell(40,10,);
    $pdf->Cell(100,10,$planta['nombreComun'],1,0,'C');
    $pdf->Ln(20);
    $pdf->Cell(40,10, 'Luz:');
    $pdf->Cell(40,10,$planta['luz']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Riego:');
    $pdf->Cell(40,10,$planta['riego']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Nombre científico:');
    $pdf->Cell(40,10,$planta['nombreCientifico']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Hojas:');
    $pdf->Cell(40,10,$planta['hojas']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Tamaño Planta:');
    $pdf->Cell(40,10,$planta['tamañoPlanta']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Floración:');
    $pdf->Cell(40,10,$planta['floracion']);
    $pdf->Ln(10);
    $pdf->Cell(40,10, 'Color Flor:');
    $pdf->Cell(40,10,$planta['colorFlor']);
    $pdf->Ln(20);
    $pdf->Cell(40,10,);
    $pdf->Cell(100,10,'Estilo jardín:',1,0,'C');
    $pdf->Ln(20);
    $pdf->Cell(10,5,$planta['estiloJardin']);
    $pdf->Ln(10);


    $pdf->Output();
    ?>