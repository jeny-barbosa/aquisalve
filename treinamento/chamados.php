<?php
require 'fontes.php';
require 'menu.php';
require 'querys.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TangDesk - Chamados</title>
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

    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nº Chamado</th>
          <th>Descrição</th>
          <th>Data</th>
          <th>Hora Início</th>
          <th>Hora Fim</th>
          <th>Hora Apontada</th>
          <th>Hora Trabalhada</th>
          <th>Diferença</th>
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
              <td><?php echo "<b><font color='#73c97d'>" . $count['DIFERENCA'] . "</font></b>"; ?></td>
            <?php } else { ?>
              <td><?php echo "<b><font color='#d43a2c'>" . $count['DIFERENCA'] . "</font></b>"; ?></td>

            <?php } ?>
          <?php } ?>
        </tr>
        <tr>
          <th>Total de Horas do Dia:</th>
          <th>
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
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>

        </tr>
      </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
  </body>
</html>

