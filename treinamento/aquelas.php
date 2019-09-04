<?php

require 'conexao.php';
require 'estilos.php';
$sOutput       = '';
$iDataAnterior = 0;
$iControlador  = 0;
$sQuery        = "
      SELECT
        ID_COLABORADOR,
        HORA_PONTO,
        DATA_PONTO
       FROM TANGERINO
";
$sConsulta     = mysqli_query($conn, $sQuery);

$sOutput .= '<table class="table table-bordered table-hover"> ';
$sOutput .= '<thead>
              <tr>
                <th>Data</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Entrada</th>
                <th>Saída</th>
              </tr>
            </thead>

    ';

while ($aRow = mysqli_fetch_array($sConsulta)) {
  $sData = $aRow ['DATA_PONTO'];
  $sHora = $aRow['HORA_PONTO'];

  if ($sData != $iDataAnterior) {
    $sOutput       .= ' <tbody>
                  <tr><td><a href="chamados.php?colaborador=' . $aRow['ID_COLABORADOR'] . '&data=' . $sData . '">' . $sData . '</a></td>
                 <td>' . $sHora . '</td>
    ';

    $iDataAnterior = $sData;
    $sEntrada1     = $sHora;
    $iControlador++;
  } else {
    $sOutput       .= '<td>' . $sHora . '</td>';
    $iDataAnterior = $sData;

    if ($iControlador == 1) {
      $iControlador++;
      $sSaida1 = $sHora;
    } elseif ($iControlador == 2) {
      $sEntrada2 = $sHora;
      $iControlador++;
    } elseif ($iControlador == 3) {
      $iControlador++;
      $sSaida2 = $sHora;
    } elseif ($iControlador == 4) {
      $iControlador    = 0;
      $sHoraTrabalhada = (($sSaida1 - $sEntrada1) + ($sSaida2 - $sEntrada2));
      echo $sHoraTrabalhada;
    }
  }
}
$sOutput .= '</tr>';
$sOutput .= '<tbody>';
$sOutput .= '</table> ';

echo $sOutput;

$string1 = strtotime("12:04:32");
$string2 = strtotime("18:07:34");

$intervalo  = abs($string2 - $string1);
var_dump('Diferença em segundos: ' . $intervalo);

$minutos   = round($intervalo / 60, 2);
var_dump('Diferença em minutos: ' . $minutos);

$horas   = round($minutos / 60, 2);
var_dump('Diferença em horas: ' . $horas);