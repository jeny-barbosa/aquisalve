<?php
require 'querys.php';
require './estilos.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TangDesk - Chamados</title>
    <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body>
    <br>
    <?php
    $sData              = $_GET['data'];
    $sColaborador       = $_GET['colaborador'];
    $sConsulta          = "
                      SELECT
                            TICKET,
                            DESCRICAO,
                            DATA_PONTO,
                            HORA_INICIO,
                            HORA_FIM,
                            HORA_APONTADA,
                            HORA_TRABALHADA,
                            ID_COLABORADOR,
                            CONVERT((TIMEDIFF(HORA_APONTADA,HORA_TRABALHADA)), TIME) AS DIFERENCA
                        FROM MOVIDESK
                          WHERE DATA_PONTO = '%s'
                          AND ID_COLABORADOR = %s
                      ";
    $sQueryConsulta     = sprintf($sConsulta
      , $sData
      , $sColaborador
    );
    $sResultadoConsulta = mysqli_query($sConn, $sQueryConsulta);
    ?>
    <div id="table-chamados">
      <table class="table table-hover">
        <thead>
          <tr>
            <th width="10%">Nº CHAMADO</th>
            <th width="30%">DESCRIÇÃO</th>
            <th width="8%">DATA</th>
            <th width="8%">HORA INÍCIO</th>
            <th width="8%">HORA FIM</th>
            <th width="10%">HORA APONTADA</th>
            <th width="15%">HORA TRABALHADA</th>
            <th width="8%">DIFERENÇA</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($count = mysqli_fetch_array($sResultadoConsulta)) {
            ?>
            <tr>
              <td><?php echo $count['TICKET']; ?></td>
              <td><?php echo $count['DESCRICAO']; ?></td>
              <td><?php echo $count['DATA_PONTO']; ?></td>
              <td><?php echo $count['HORA_INICIO']; ?></td>
              <td><?php echo $count['HORA_FIM']; ?></td>
              <td><?php echo $count['HORA_APONTADA']; ?></td>
              <td><?php echo $count['HORA_TRABALHADA']; ?></td>

              <?php
              if ($count['HORA_APONTADA'] == $count['HORA_TRABALHADA']) {
                ?>
                <td style="background-color: #a2ded0;"><?php echo "<b><font color='#019875'>" . $count['DIFERENCA'] . "</font></b>"; ?></td>
              <?php } else { ?>
                <td style="background-color: #f1a9a0;"><?php echo "<b><font color='#d43a2c'>" . $count['DIFERENCA'] . "</font></b>"; ?></td>

              <?php } ?>
            <?php } ?>
          </tr>
          <tr id="tr-total-horas">
            <th style="background-color: #c8f7c5;">Total Horas/Dia</th>
            <th style="background-color: #c8f7c5;">
              <?php
              $sDiferencaHora = "
                        SELECT
                              SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
                          FROM MOVIDESK
                            WHERE DATA_PONTO = '%s'
                            AND ID_COLABORADOR = %s";

              $sTotalHoras = sprintf($sDiferencaHora
                , $sData
                , $sColaborador
              );

              $sListHoraDiferenca = mysqli_query($sConn, $sTotalHoras);

              while ($aHoraDifererenca = mysqli_fetch_array($sListHoraDiferenca)) {
                echo $aHoraDifererenca['TOTAL_HORAS'];
              }
              ?>
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tbody>
      </table>
    </div>
    <a href="javascript:history.back()" class="btn btn-primary" id="btn-voltar" align="left">Voltar</a>
  </body>
</html>