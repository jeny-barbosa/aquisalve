<?php
require './querys.php';
require 'menu.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Colaborador</title>
    <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body>
    <br>
    <!--BOTÃO PARA ADICIONAR NOVO COLABORADOR -->
    <div class="container">
      <div align="right">
        <button align="left" type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-lg btn-success"><i class="fas fa-user-plus"></i></button>
      </div>
      <br>
      <!-- TABELA COM A LISTA DOS COLABORADORES -->
      <div id="employee_table">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%">ID</th>
              <th width="50%">Nome</th>
              <th width="30%" ></th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($aRow = mysqli_fetch_array($sListColaborador)) {
              ?>
              <tr>
                <td><?php echo $aRow['ID']; ?></td>
                <td><?php echo $aRow['NOME']; ?></td>
                <td align="right">
                  <button type="button" name="delete" value="delete" codigo="<?php echo $aRow['ID']; ?>" class="excluirReg btn btn-danger"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!--Modal Adicionar -->
    <div id="add_data_Modal" class="modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Adicionar novo colaborador</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="container">
              <form name="form1" id="form1" class="form-horizontal">
                <div class="form-group">
                  <label for="nome-add"> Nome: *</label>
                  <input type="text" name="nome-add" id="nome-add" class="form-control" placeholder="Ex.: Fulano de Tal" />
                </div>
                <div class="form-group">
                  <div align="right">
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
    <div class="modal fade" id="myModal">
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
            alert('Ops! Esqueceu de preencher o nome do Colaborador...');
          } else {
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
      /*Script para plugin de tabela */
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
  </body>
</html>
