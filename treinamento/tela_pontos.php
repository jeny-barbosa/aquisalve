<?php
require 'conexao.php';
require 'querys.php';
require 'estilos.php';
require 'menu.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TangDesk - PONTOS</title>
    <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body>
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
              <select id="func_nome_incluir" name="func_nome_incluir" class="form-control" >
                <option >Selecione...</option>
                <?php while ($aColaborador = mysqli_fetch_array($sListColaborador)) { ?>
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

    <fieldset id="fieldset-colaborador">
      <legend id="legenda-colaborador">Selecione o colaborador para buscar as informações sobre os pontos</legend>
      <form method="post" action="pontos_tangerino.php" name="frmColaborador">
        <div>
          <?php
          $sSql              = "
          SELECT
            *
           FROM
              colaborador
           WHERE 1 = 1 %s
          ";
          $sSelecionado      = sprintf($sSql
            , (isset($_POST['func_nome']) && $_POST['func_nome']) ? 'AND NOME LIKE \'%' . addslashes($_POST['func_nome']) . '%\'' : ''
          );
          $sResultado        = mysqli_query($conn, $sSelecionado);
          ?>
          Colaborador: <select id="func_id" name="func_id">
            <option >Selecione...</option>
            <?php
            while ($aColaboradorBusca = mysqli_fetch_array($sResultado)) {
              $selected = ''
              ?>
              <option value="<?php echo $aColaboradorBusca['ID'] ?> <?php echo $selected; ?>" name="idFunc"><?php echo $aColaboradorBusca['NOME'] ?></option>
            <?php } ?>
          </select>
          <button type="submit" value="Buscar" class="btn btn-primary"/><i class="fas fa-search"></i></button>
        </div>
      </form>
    </fieldset>
  </body>
</html>

