<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<?php
require 'conexao.php';
require 'querys.php';

function getHorasTrabalhadasDia($aHorasPonto) {
  $sHoraAnterior       = '';
  $iHorasTrabalhadas   = 0;
  $iMinutosTrabalhados = 0;
  foreach ($aHorasPonto as $sHora) {
    if (empty($sHoraAnterior)) {
      $sHoraAnterior = $sHora;
      continue;
    }
    $datetime1           = new DateTime(sprintf('2019-01-01 %s', $sHoraAnterior));
    $datetime2           = new DateTime(sprintf('2019-01-01 %s', $sHora));
    $interval            = $datetime1->diff($datetime2);
    $iHorasTrabalhadas   += $interval->h;
    $iMinutosTrabalhados += $interval->i;
    $sHoraAnterior       = '';
  }
  $iHorasTrabalhadas   = $iHorasTrabalhadas + floor($iMinutosTrabalhados / 60);
  $iMinutosTrabalhados = $iMinutosTrabalhados % 60;
  return [
    'HORAS'       => str_pad($iHorasTrabalhadas, 2, '0', STR_PAD_LEFT)
    , 'MINUTOS'     => str_pad($iMinutosTrabalhados, 2, '0', STR_PAD_LEFT)
    , 'HORA_MINUTO' => sprintf(
      '%s:%s'
      , str_pad($iHorasTrabalhadas, 2, '0', STR_PAD_LEFT)
      , str_pad($iMinutosTrabalhados, 2, '0', STR_PAD_LEFT)
    )
  ];
}

$sOutput       = '';
$iDataAnterior = 0;


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
$sConsulta    = mysqli_query($sConn, $sSelecionado);
$sOutput      .= '<div style="width:70%; margin-left: 15%; margin-top: 20px"> ';

$sOutput .= '<table class="table table-bordered table-hover "> ';
$sOutput .= '<thead>
              <tr>
                <th>Data</th>
                <th title="Início do Expediente">Entrada</th>
                <th title="Início do intervalo">Saída</th>
                <th title="Fim do intervalo">Entrada</th>
                <th title="Fim do Expediente">Saída</th>
                <th title="Total de horas-pontos batidos no tangerino" style="background-color: #f9690e; color:#FFF;">Total de Hora Tangerino</th>
                <th title="Total de horas trabalhadas calculada pelo Movidesk" style="background-color: #d91e18; color: #FFF;">Total do Movidesk</th>
                <th title="Total de horas trabalhadas calculada pelo Movidesk"><b style="color:#f9690e">Tangerino</b> X <b style="color: #d91e18;">Movidesk</b></th>
              </tr>
            </thead>
            <tbody>
';
$aHoras  = [];
while ($aRow    = mysqli_fetch_array($sConsulta)) {
  $sData = $aRow ['DATA_PONTO'];
  $sHora = $aRow['HORA_PONTO'];

  if ($sData != $iDataAnterior) {
    if ($iDataAnterior != 0) {
      /* ---PARA FAZER O CÁLCULO DE HORAS TRABALHADAS --- */
      $sDiferencaHora = "
                       SELECT
                          SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
                         FROM MOVIDESK
                        WHERE DATA_PONTO = '%s'
                          AND ID_COLABORADOR = %s
                        ";

      $sTotalHoras        = sprintf($sDiferencaHora
        , $iDataAnterior
        , $aRow['ID_COLABORADOR']
      );
      $sListHoraDiferenca = mysqli_query($sConn, $sTotalHoras);
      $aHoraDifererenca   = mysqli_fetch_array($sListHoraDiferenca);
      $sOutput            .= '<td >' . getHorasTrabalhadasDia($aHoras)['HORA_MINUTO'] . '</td>';
      $sOutput            .= '<td >' . $aHoraDifererenca['TOTAL_HORAS'] . '</td>';
      $aHorasDiferenca    = [
          getHorasTrabalhadasDia($aHoras)['HORA_MINUTO']
        , $aHoraDifererenca['TOTAL_HORAS']
      ];

      $sOutput .= '<td >' . getHorasTrabalhadasDia($aHorasDiferenca)['HORA_MINUTO'] . '</td>';
      $aHoras  = [];
    }
    $sOutput .= '
                  <tr>
                    <td><a href="chamados.php?colaborador=' . $aRow['ID_COLABORADOR'] . '&data=' . $sData . '">' . $sData . '</a></td>
    ';
    $sOutput .= '<td >' . $sHora . '</td>';
    $iDataAnterior = $sData;
    $sEntrada1     = strtotime($sHora);
  } else {
    $sOutput .= '<td >' . $sHora . '</td>';
  }
  $aHoras[] = $sHora;
}
$sDiferencaHora = "
                SELECT
                   SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
                  FROM MOVIDESK
                 WHERE DATA_PONTO = '%s'
                   AND ID_COLABORADOR = %s
                 ";

$sTotalHoras        = sprintf($sDiferencaHora
  , $iDataAnterior
  , $_POST['func_id']
);
$sListHoraDiferenca = mysqli_query($sConn, $sTotalHoras);
$aHoraDifererenca   = mysqli_fetch_array($sListHoraDiferenca);
$sOutput            .= '<td >' . getHorasTrabalhadasDia($aHoras)['HORA_MINUTO'] . '</td>';
$sOutput            .= '<td >' . $aHoraDifererenca['TOTAL_HORAS'] . '</td>';

$aHorasDiferenca = [
   getHorasTrabalhadasDia($aHoras)['HORA_MINUTO']
  , $aHoraDifererenca['TOTAL_HORAS']
];

$sOutput .= '<td >' . getHorasTrabalhadasDia($aHorasDiferenca)['HORA_MINUTO'] . '</td>';
$sOutput .= '</tr>';
$sOutput .= '</tbody>';
$sOutput .= '</table> ';
$sOutput .= '</div> ';

echo $sOutput;
?>
<script>
  $(function () {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js';
    document.head.appendChild(script);
    setTimeout(function () {
      $('table').DataTable();
    }, 10);

  });
</script>
