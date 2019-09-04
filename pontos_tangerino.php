<?php
require 'conexao.php';
require 'querys.php';
require 'estilos.php';
require 'menu.php';

$sOutput       = '';
$iDataAnterior = 0;
$iControlador  = 0;

$sSql         = "
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
$sConsulta    = mysqli_query($conn, $sSelecionado);

$sOutput .= '<div style="width:70%; margin-left: 15%;  "> ';
$sOutput .= '<table class="table table-bordered table-hover "> ';
$sOutput .= '<thead>
              <tr>
                <th style="background-color: #f1e7fe;">Data</th>
                <th></th>
                <th title="Início do Expediente " style="background-color: #ff9478;">Entrada</th>
                <th title="Início do intervalo" style="background-color: #ff9478;">Saída</th>

                <th title="Fim do intervalo"style="background-color: #ff9478;">Entrada</th>
                <th title="Fim do Expediente"style="background-color: #ff9478;">Saída</th>
                <th title="Total de horas-pontos batidos no tangerino" style="background-color: ;">Total de Hora-Ponto</th>
                <th title="Total de horas trabalhadas calculada pelo Movidesk" style="background-color: #e4f1fe;">Total do Movidesk</th>
              </tr>
            </thead>
';

while ($aRow = mysqli_fetch_array($sConsulta)) {
  $sData = $aRow ['DATA_PONTO'];
  $sHora = $aRow['HORA_PONTO'];

  /* ---PARA FAZER O CÁLCULO DE HORAS TRABALHADAS --- */
  $sDiferencaHora = "
                   SELECT
                      SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
                     FROM MOVIDESK
                    WHERE DATA_PONTO = '%s'";

  $sTotalHoras = sprintf($sDiferencaHora
    , $aRow ['DATA_PONTO']
  );

  $sListHoraDiferenca = mysqli_query($conn, $sTotalHoras);
  /* ---                                      --- */
  if ($sData != $iDataAnterior) {
    $sOutput .= '
                <tbody>
                  <tr>
                    <td style="background-color: #f1e7fe;"><a href="chamados.php?colaborador=' . $aRow['ID_COLABORADOR'] . '&data=' . $sData . '">' . $sData . '</a></td>
                    <td ></td>
    ';
    $sOutput .= '<td >' . $sHora . '</td>';
    $sOutput .= '<td></td>';
    while ($aHoraDifererenca = mysqli_fetch_array($sListHoraDiferenca)) {
      $sOutput .= '<td >' . $aHoraDifererenca['TOTAL_HORAS'] . '</td>';
    }
    //  $sOutput .= '<td >' . $sHora . '</td>';

    $iDataAnterior = $sData;
    $sEntrada1     = strtotime($sHora);
    $iControlador++;
  } else {

    $sOutput .= '<td >' . $sHora . '</td>';

    $iDataAnterior = $sData;

    switch ($iControlador) {
      case 1:
        $sSaida1   = strtotime($sHora);
        $iControlador++;
        break;
      case 2:
        $sEntrada2 = strtotime($sHora);
        $iControlador++;
        break;
      case 3:
        $sSaida2   = strtotime($sHora);
        $iControlador++;
        break;
    }
  }
}

$sOutput .= '</tr>';
$sOutput .= '<tbody>';
$sOutput .= '</table> ';
$sOutput .= '</div> ';

echo $sOutput;
?>
<a href="javascript:history.back()" class="btn btn-primary" style="margin-left: 82%;  ">Voltar</a>

