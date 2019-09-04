<?php
require 'conexao.php';

$iDataAnterior = 0;
$iControlador  = 1;
$sQuery        = "
      SELECT
        HORA_PONTO,
        DATA_PONTO
       FROM TANGERINO
";
$sConsulta     = mysqli_query($conn, $sQuery);

$sOutput = '<table class="table table-bordered">';

while ($aRow = mysqli_fetch_array($sConsulta)) {


  if ($aRow['DATA_PONTO'] != $iDataAnterior) {

    $iDataAnterior = $aRow['DATA_PONTO'];
    $sEntrada1     = $aRow['HORA_PONTO'];
    $iControlador  = 1;
  } else {
    $iDataAnterior = $aRow['DATA_PONTO'];
  }

  if ($iControlador = 1) {
    $iControlador = 2;
    $sSaida1      = $aRow['HORA_PONTO'];

    echo $aRow['HORA_PONTO'];

    //echo '' . $aRow['HORA_PONTO'] . '<br><br>';
  } else {
    if ($iControlador = 2) {
      $sEntrada2    = $aRow['HORA_PONTO'];
      $iControlador = 3;
    } else {
      if ($iControlador = 3) {
        $iControlador = 4;
        $sSaida2      = $aRow['HORA_PONTO'];
      } else {
        if ($iControlador = 4) {
          $iControlador    = 0;
          $sHoraTrabalhada = (($sSaida1 - $sEntrada1) + ($sSaida2 - $sEntrada2));
          echo $sHoraTrabalhada;
        }
      }
    }
  }
}
$sOutput .= '</table>';
echo $sOutput;


$i     = 0;
echo '<table border="0">';
while ($linha = mysqli_fetch_assoc($sConsulta)) {
  if ($i === 0) {
    echo '<tr>';
    echo '<td>' . $linha["HORA_PONTO"] . '</td>';
    $i++;
    if ($i === 4) {
      echo '</tr>'; // A cada 4 colunas fecha uma linha
      $i = 0; // Zera o contador para abrir nova linha no início do loop
    }
  }
  if ($i > 0) {
    echo '</tr>'; // Caso a última linha tenha menos de 4 colunas, fecha a linha
    echo '</table>';
  }
}
?>

