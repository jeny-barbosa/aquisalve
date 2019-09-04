<?php
require 'conexao.php';
require 'funcoes.php';
require 'estilos.php';
require 'menu.php';
require 'paginacao.php'
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TangDesk - MÊS</title>
  </head>
  <body>
    <!-- PAGINAÇÃO -->
    <ul class="list-group">
      <li class="list-group-item">
        <?php
        while ($aMesTrabalhado = mysqli_fetch_array($sMes)) {
          $aColaborador = mysqli_fetch_array($sListColaborador);
          echo '<a href="pagina.php?colaborador='.$aColaborador['ID'].'&mes='.$aMesTrabalhado['MES'].'">'.$aMesTrabalhado['MES'].'</a><br>';
        }
        ?>
      </li>
    </ul>

    <div style="float:left" width="50%">
      <table class="table table-hover">
        <thead>
          <tr width="50%">
            <th widht="15%">Colaborador </th>
            <th style="color: #f27121" widht="15%">Data Ponto </th>
            <th style="color: #f27121" widht="15%">Hora Ponto </th>
            <th style="color: #f27121" widht="15%">Hora Total </th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($aRow = mysqli_fetch_array($sListTangerino)) {
            ?>
            <tr>
              <td><?php echo $aRow['DATA_PONTO']; ?></td>
              <td><?php echo $aRow['HORA_PONTO']; ?></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>

