<?php
//PAGINAÇÃO
require 'conexao.php';
$iOffset = empty($_GET['pagina']) ? 0 : ($_GET['pagina'] * 14) - 14;
//$query   = "SELECT * FROM tangerino WHERE 1 = 1 ORDER BY ID ASC LIMIT 12 OFFSET $iOffset";
$sQueryTang   = "SELECT ID_COLABORADOR, HORA_PONTO, DATA_PONTO FROM tangerino ORDER BY ID ASC LIMIT 14 OFFSET $iOffset";
$sQueryMovi   = "SELECT DATA_PONTO, HORA_INICIO, HORA_FIM, HORA_APONTADA, HORA_TRABALHADA FROM MOVIDESK ORDER BY ID ASC LIMIT 14 OFFSET $iOffset";

/*$query  = sprintf($query
  , (isset($_POST['colaborador']) && $_POST['colaborador']) ? ' AND COLABORADOR LIKE \'%' . addslashes($_POST['colaborador']) . '%\'' : ''
  , (isset($_POST['data_ponto']) && $_POST['data_ponto']) ? ' AND DATA_PONTO LIKE \'%' . addslashes($_POST['data_ponto']) . '%\'' : ''
  , (isset($_POST['hora_ponto']) && $_POST['hora_ponto']) ? ' AND HORA_PONTO = ' . $_POST['hora_ponto'] : ''
  );*/
$sResult    = mysqli_query($conn, $sQueryTang);
$sResultado = mysqli_query($conn, $sQueryMovi);
$aKeys     = array_keys($_GET);
if (in_array('pagina', $aKeys)) {
  $iPagina = $_GET['pagina'];
} else {
  $iPagina = 1;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TangDesk</title>
  </head>
  <body>
    <?php require 'menu.php'; ?>
    <br>
    <form action="processa.php" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
      <div class="container-fluid">
        <div class="row">
          <div class="col" >
            <h3>Importar Excel Tangerino</h3>
            <div class="input-group mb-3">
              <div class="custom-file">
                <label class="custom-file-label-hover" for="file">
                  <input type="file" name="tangerino" id="tangerino" accept=".xls,.xlsx" class="form-control-file " >
                </label>
              </div>
            </div>
          </div>
          <div class="col">
            <h3>Importar Excel MoviDesk</h3>
            <div class="input-group mb-3">
              <div class="custom-file-hover">
                <label class="custom-file-label-hover" for="file">
                  <input type="file" name="movidesk" id="movidesk" accept=".xls,.xlsx"  class="form-control-file ">
                </label>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <h3>Selecione o colaborador:</h3>
              <?php
              $sQuery = mysqli_query($conn, "
              SELECT ID, NOME
               FROM COLABORADOR
               ORDER BY NOME
              ");
              ?>
              <select id="func_nome_incluir" name="func_nome_incluir" class="form-control" >
                <option >Selecione...</option>
                <?php while ($aColaborador = mysqli_fetch_array($sQuery)) { ?>
                  <option value="<?php echo $aColaborador['ID'] ?>" name="idFunc"><?php echo $aColaborador['NOME'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col">
            <br>
            <button type="submit" id="submit" name="import" class="btn btn-success btn-lg">Importar <i class="fas fa-file-import"></i></button>
            <button type="reset" class="btn btn-outline-danger btn-lg" value="Limpar">Limpar <i class="fas fa-broom"></i></button>
          </div>
        </div>
      </diV>
    </form>

    <!--Filtro não está funcionando ainda-->
    <div>
      <form>
        <fieldset>
        <div class="form-group" style="font-size:14pt;">
          <label class="col-2 col-form-label" >Filtrar Datas</label><br>
          &nbsp; &nbsp; De: <input type="date" /> &nbsp;
          Até: <input type="date" />
              <?php
              $sQuery = mysqli_query($conn, "
              SELECT ID, NOME
               FROM COLABORADOR
               ORDER BY NOME
              ");
              ?>
              Colaborador: <select id="func_nome_incluir" name="func_nome_incluir" >
                <option >Selecione...</option>
                <?php while ($aColaborador = mysqli_fetch_array($sQuery)) { ?>
                  <option value="<?php echo $aColaborador['ID'] ?>" name="idFunc"><?php echo $aColaborador['NOME'] ?></option>
                <?php } ?>
              </select>
          <button type="button" value="Buscar" class="btn btn-primary"/><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>
    <br>
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
          while ($aRow = mysqli_fetch_array($sResult)) {
            ?>
            <tr>
              <td><?php echo $aRow['COLABORADOR']; ?></td>
              <td><?php echo $aRow['DATA_PONTO']; ?></td>
              <td><?php echo $aRow['HORA_PONTO']; ?></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <div style="float:left">
      <table class="table table-hover">
        <thead>
          <tr width="50%">
            <th style="color: #bf1d23">Data Ponto Movidesk</th>
            <th style="color: #bf1d23">Hora Início Movidesk</th>
            <th style="color: #bf1d23">Hora Fim Movidesk</th>
            <th style="color: #bf1d23">Hora Apontada Movidesk</th>
            <th style="color: #bf1d23">Hora Trabalhada Movidesk</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($count = mysqli_fetch_array($sResultado)) {
            ?>
            <tr>
              <td><?php echo $count['DATA_PONTO']; ?></td>
              <td><?php echo $count['HORA_INICIO']; ?></td>
              <td><?php echo $count['HORA_FIM']; ?></td>
              <td><?php echo $count['HORA_APONTADA']; ?></td>
              <td><?php echo $count['HORA_TRABALHADA']; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>

    <div  style="clear:both; height:100px; padding-left: 25%;">
      <a href="principal.php" class="btn btn-default <?= ($iPagina == 1) ? 'btn-lg btn-primary' : '' ?>"> 1</a>
      <a href="principal.php?pagina=2" class="btn btn-default <?= ($iPagina == 2) ? 'btn-lg btn-primary' : '' ?>"> 2 </a>
      <a href="principal.php?pagina=3" class="btn btn-default <?= ($iPagina == 3) ? 'btn-lg btn-primary' : '' ?>"> 3 </a>
      <a href="principal.php?pagina=4" class="btn btn-default <?= ($iPagina == 4) ? 'btn-lg btn-primary' : '' ?>"> 4 </a>
     <!-- <a href="tangerino.php?pagina=5" class="btn btn-default <?= ($iPagina == 5) ? 'btn-lg btn-primary' : '' ?>"> 5 </a>
      <a href="tangerino.php?pagina=6" class="btn btn-default <?= ($iPagina == 6) ? 'btn-lg btn-primary' : '' ?>"> 6 </a>
      <a href="tangerino.php?pagina=7" class="btn btn-default <?= ($iPagina == 7) ? 'btn-lg btn-primary' : '' ?>"> 7 </a>-->
    </div>
  </body>
</html>