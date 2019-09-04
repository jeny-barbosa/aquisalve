<?php
require 'fontes.php';
require 'menu.php';
require 'querys.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TangDesk - Chamados</title>
    <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body>
    <br>
    <?php
    $sData              = $_GET['data'];
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
          WHERE DATA_PONTO = '%s'";
    $sQueryConsulta     = sprintf($sConsulta
      , $sData
    );
    $sResultadoConsulta = mysqli_query($conn, $sQueryConsulta);
    ?>
    <div style="width:70%; margin-left: 15%;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th width="10%">Nº Chamado</th>
            <th width="35%">Descrição</th>
            <th width="8%">Data</th>
            <th width="8%">Hora Início</th>
            <th width="10%">Hora Fim</th>
            <th width="10%">Hora Apontada</th>
            <th width="10%">Hora Trabalhada</th>
            <th width="10%">Diferença</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($count              = mysqli_fetch_array($sResultadoConsulta)) {
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
          <tr>
            <th style="background-color: #c8f7c5;">Total Horas/Dia</th>
            <th style="background-color: #c8f7c5;">
              <?php
              $sDiferencaHora = "
                SELECT
                    SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
                 FROM MOVIDESK
                 WHERE DATA_PONTO = '%s'";

              $sTotalHoras = sprintf($sDiferencaHora
                , $sData
              );

              $sListHoraDiferenca = mysqli_query($conn, $sTotalHoras);

              while ($aHoraDifererenca = mysqli_fetch_array($sListHoraDiferenca)) {
                echo $aHoraDifererenca['TOTAL_HORAS'];
              }
              ?>
            </th>
            <th style="background-color: #c8f7c5;"></th>
            <th style="background-color: #c8f7c5;"></th>
            <th style="background-color: #c8f7c5;"></th>
            <th style="background-color: #c8f7c5;"></th>
            <th style="background-color: #c8f7c5;"></th>
            <th style="background-color: #c8f7c5;"></th>
          </tr>
        </tbody>
      </table>
    </div>
    <a href="javascript:history.back()" class="btn btn-primary" style="margin-left: 82%;  ">Voltar</a>
  </body>
</html>

