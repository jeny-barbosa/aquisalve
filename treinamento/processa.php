<?php

require 'conexao.php';

$aArquivoTangerino = isset($_FILES['tangerino']) ? $_FILES['tangerino'] : FALSE;
$aArquivoMovidesk  = isset($_FILES['movidesk']) ? $_FILES['movidesk'] : FALSE;

$sIdFuncionario = $_POST['func_nome_incluir'];

if (!empty($_FILES['tangerino'])) {
  require_once './PHPExcel/Classes/PHPExcel.php';
  $sArquivoTang  = $_FILES['tangerino']['tmp_name'];
  $inputFileType = PHPExcel_IOFactory::identify($sArquivoTang);
  $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
  $objPHPExcel   = $objReader->load($sArquivoTang);
  $sheet         = $objPHPExcel->getSheet(0);
  $highestRow    = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  $aArquivoTangerino = $_FILES['tangerino'];

  for ($row = 1; $row <= $highestRow; $row++) {
    $sDataPonto = $sheet->getCell("A" . $row)->getValue();
    $sHoraPonto = $sheet->getCell("B" . $row)->getValue();
    $sSqlInsert = "
      INSERT INTO TANGERINO (
        DATA_PONTO,
        HORA_PONTO,
        ID_COLABORADOR
       ) VALUES(
          '$sDataPonto',
          '$sHoraPonto',
          '$sIdFuncionario'
      )";
    mysqli_query($conn, $sSqlInsert);
  }

  $sSqlUpdate = "
      UPDATE TANGERINO
       SET
        HORA_PONTO = CONVERT(HORA_PONTO, TIME),
        DATA_PONTO = DATE_FORMAT(STR_TO_DATE(DATA_PONTO, '%d/%m/%Y'), '%Y-%m-%d')
    ";
  mysqli_query($conn, $sSqlUpdate);
}
if (!empty($_FILES['movidesk'])) {
  require_once './PHPExcel/Classes/PHPExcel.php';
  $sArquivoMovi  = $_FILES['movidesk']['tmp_name'];
  $inputFileType = PHPExcel_IOFactory::identify($sArquivoMovi);
  $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
  $objPHPExcel   = $objReader->load($sArquivoMovi);
  $sheet         = $objPHPExcel->getSheet(0);
  $highestRow    = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  $aArquivoMovidesk = $_FILES['movidesk'];

  for ($row = 2; $row <= $highestRow; $row++) {
    $sTicket         = $sheet->getCell("E" . $row)->getValue();
    $sDescricao = $sheet->getCell("G" . $row)->getValue();
    $sData           = $sheet->getCell("N" . $row)->getValue();
    $sHoraInicio     = $sheet->getCell("O" . $row)->getValue();
    $sHoraFim        = $sheet->getCell("P" . $row)->getValue();
    $sHoraApontada   = $sheet->getCell("Q" . $row)->getValue();
    $sHoraTrabalhada = $sheet->getCell("R" . $row)->getValue();
    $sSqlMovi        = "
      INSERT INTO MOVIDESK (
        TICKET,
        DESCRICAO,
        DATA_PONTO,
        HORA_INICIO,
        HORA_FIM,
        HORA_APONTADA,
        HORA_TRABALHADA,
        ID_COLABORADOR
      ) VALUES (
        '$sTicket',
        '$sDescricao',
        '$sData',
        '$sHoraInicio',
        '$sHoraFim',
        '$sHoraApontada',
        '$sHoraTrabalhada',
        '$sIdFuncionario'
      )";

    mysqli_query($conn, $sSqlMovi);
  }

   $sSqlUpdateMovi = "
      UPDATE MOVIDESK
       SET
        HORA_INICIO = CONVERT(HORA_INICIO, TIME),
        HORA_FIM = CONVERT(HORA_FIM, TIME),
        HORA_APONTADA = CONVERT(HORA_APONTADA, TIME),
        HORA_TRABALHADA = CONVERT(HORA_TRABALHADA, TIME),
        DATA_PONTO = DATE_FORMAT(STR_TO_DATE(DATA_PONTO, '%d/%m/%Y'), '%Y-%m-%d')
    ";
  mysqli_query($conn, $sSqlUpdateMovi);
}
echo "<script>
  window.location = './tela_pontos.php';
  </script>
  ";



