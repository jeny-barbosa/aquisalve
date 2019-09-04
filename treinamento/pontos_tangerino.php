<?php
require 'conexao.php';
require 'querys.php';
require 'estilos.php';
require 'menu.php';

$sOutput       = '';
$iDataAnterior = 0;
$iControlador  = 0;

$sSql = "
      SELECT
        COLABORADOR.ID AS ID_COLABORADOR,
        COLABORADOR.NOME,
        TANGERINO.ID,
        TANGERINO.DATA_PONTO,
        TANGERINO.HORA_PONTO,
        TANGERINO.ID_COLABORADOR
       FROM
          COLABORADOR
       INNER JOIN
          TANGERINO ON COLABORADOR.ID = TANGERINO.ID_COLABORADOR
       WHERE COLABORADOR.ID = %s
      ";
$sSelecionado = sprintf(
  $sSql
  , $_POST['func_id']
);
$sConsulta   = mysqli_query($conn, $sSelecionado);

$sOutput .= '<table class="table table-bordered table-hover"> ';
$sOutput .= '<thead>
              <tr>
                <th>Data</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Total de Hora-Ponto</th>
                <th>Total do Movidesk</th>
                <th>Diferença Pontos x Movidesk</th>
              </tr>
            </thead>
';

while ($aRow = mysqli_fetch_array($sConsulta)) {
  $sData = $aRow ['DATA_PONTO'];
  $sHora = $aRow['HORA_PONTO'];
  if ($sData != $iDataAnterior) {
    $sOutput .= '
                <tbody>
                  <tr>
                    <td><a href="chamados.php?colaborador=' . $aRow['ID_COLABORADOR'] . '&data=' . $sData . '">' . $sData . '</a></td>
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
?>

 <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>

