<?php
require_once 'Classes/PHPExcel.php';
 
// 新增Excel物件
$objPHPExcel = new PHPExcel();
 
// 設定屬性
$objPHPExcel->getProperties()->setCreator("PHP")
        ->setLastModifiedBy("PHP")
        ->setTitle("Title")
        ->setSubject("Subject")
        ->setDescription("Description")
        ->setKeywords("Keywords")
        ->setCategory("Category");
 

$sheet = $objPHPExcel->getActiveSheet();

    //Start adding next sheets
    $i=0;
    while ($i < 10) {

      // Add new sheet
      $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

      //Write cells
      $objWorkSheet->setCellValue('A1', 'Hello'.$i)
                   ->setCellValue('B2', 'world!')
                   ->setCellValue('C1', 'Hello')
                   ->setCellValue('D2', 'world!');

      // Rename sheet
      $objWorkSheet->setTitle("$i");

      $i++;
    }

//Excel 2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"'); //匯出檔名
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//匯出
$objWriter->save('php://output');
exit;
?>