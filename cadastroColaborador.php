<?php
session_start();
require 'conexao.php';

$iOffset = empty($_GET['pagina']) ? 0 : ($_GET['pagina'] * 10) - 10;
$sQuery  = "SELECT * FROM COLABORADOR WHERE 1 = 1 %s ORDER BY ID ASC LIMIT 15 OFFSET $iOffset";

$sQuery  = sprintf($sQuery
  , (isset($_POST['NOME']) && $_POST['NOME']) ? ' AND NOME LIKE \'%' . addslashes($_POST['NOME']) . '%\'' : ''
);
$aResult = mysqli_query($conn, $sQuery);
$aKeys   = array_keys($_GET);
if (in_array('pagina', $aKeys)) {
  $iPagina = $_GET['pagina'];
} else {
  $iPagina = 1;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Cadastro Colaborador</title>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php require 'menu.php'; ?>
    <br>
    <div class="container" style="width:400px;">
      <div align="right">
        <button align="left" type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-lg btn-success"><i class="fas fa-user-plus"></i></button>
      </div>
      <br>
      <div id="employee_table">
        <table class="table table-striped table-hover">
          <tr>
            <th width="5%">ID</th>
            <th width="50%">Nome</th>
            <th width="30%" ></th>
          </tr>
          <?php
          while ($aRow = mysqli_fetch_array($aResult)) {
            ?>
            <tr >
              <td><?php echo $aRow['ID']; ?></td>
              <td><?php echo $aRow['NOME']; ?></td>
              <td align="right">
                <button type="button" name="delete" value="delete" codigo="<?php echo $aRow['ID']; ?>" class="excluirReg btn btn-danger"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <?php
          }
          ?>
        </table>
      </div>
    </div>

    <!--Paginação -->
    <div align="center">
      <a href="cadastroColaborador.php" class="btn btn-default <?= ($iPagina == 1) ? 'btn-lg btn-primary' : '' ?>"> 1</a>
      <!--<a href="cadastroColaborador.php?pagina=2" class="btn btn-default  <?= ($iPagina == 2) ? 'btn-lg btn-primary' : '' ?>"> 2 </a>
      <a href="cadastroColaborador.php?pagina=3" class="btn btn-default <?= ($iPagina == 3) ? 'btn-lg btn-primary' : '' ?>"> 3 </a>
   -->
    </div>

    <!--Modal Adicionar -->
    <div id="add_data_Modal" class="modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Adicionar novo colaborador</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="container">
              <form name="form1" id="form1" class="form-horizontal">
                <div class="form-group">
                  <label for="nome-add"> Nome: *</label>
                  <input type="text" name="nome-add" id="nome-add" class="form-control" placeholder="Ex.: Fulano de Tal" />
                </div>
                <div class="form-group">
                  <div align="right" style="margin-right: 15px">
                    <input type="button" id="enviar" value="Adicionar" class="btn btn-primary" />
                  </div>
                  <div id="resultado"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Modal Excluir -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" role="document"></div>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Excluir Colaborador</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p class="sucess-message">Tem certeza de que quer excluir o Colaborador?</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success delete-confirm" type="button">Sim</button>
            <button class="btn btn-default" type="button" data-dismiss="modal">Não</button>
          </div>
          <div id="result"></div>
        </div>
      </div>
    </div>
    <script>
      /* Script Adicionar */
      $(document).ready(function () {
        $('#enviar').click(function () {
          if ($('#nome-add').val() === '') {
            alert('Ops! Esqueceu de preencher o nome do Colaborador... ');
          } else
          {
            $.ajax({
              url: 'inserir_func.php',
              type: 'POST',
              data: 'nome-add=' + $('#nome-add').val(),
              success: function (data) {
                $('#resultado').html(data);
                alert('Dados inseridos');
                location.href = 'cadastroColaborador.php';
                window.close();
              }
            });
          }
        });
      });

      /* Script Excluir */
      var codigo;
      $('.excluirReg').click(function () {
        codigo = $(this).attr('codigo');
        $('.deleteID').val(codigo)
        $("#myModal").modal('show');
      });
      $('.delete-confirm').click(function () {
        if (codigo != '') {
          $.ajax({
            url: 'excluirColaborador.php',
            data: {'codigo': codigo},
            method: "post",
            success: function (data) {
              $('#result').html(data);
              alert("Dados Excluidos");
              location.href = "cadastroColaborador.php";
              window.close();
            }
          });
        }
      });
    </script>
  </body>
</html>
