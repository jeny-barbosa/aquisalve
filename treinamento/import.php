<?php

$con = new mysqli("localhost","root","","projetobd");
include "class.upload.php";

if (isset($_FILES["name"])) {
  $up = new Upload($_FILES["name"]);
  if ($up->uploaded) {
    $up->Process("./uploads/");
    if ($up->processed) {

      require_once 'PHPExcel/Classes/PHPExcel.php';
      $archivo       = "uploads/".$up->file_dst_name;
      $inputFileType = PHPExcel_IOFactory::identify($archivo);
      $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel   = $objReader->load($archivo);
      $sheet         = $objPHPExcel->getSheet(0);
      $highestRow    = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();
      for ($row = 2; $row <= $highestRow; $row++) {
        $x_data       = $sheet->getCell("N" . $row)->getValue();
        $x_hora_apontada= $sheet->getCell("Q" . $row)->getValue();
        $x_hora_trabalhada= $sheet->getCell("R" . $row)->getValue();
        $sql        = "INSERT INTO movidesk(DATA, HORA_APONTADA, HORA_TRABALHADA, ID_USUARIO) VALUES";
        $sql        .= " (\"$x_data\",\"$x_hora_apontada\",\"$x_hora_trabalhada\")";
        $con->query($sql);
      }
      unlink($archivo);
    }
  }
}
/*echo "<script>
window.location = './movidesk.php';
</script>
";*/
?>