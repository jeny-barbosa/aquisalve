<?php
header('Content-type: text/html; charset=ISO-8859-1');
require 'conexao.php';

$sNome = $_POST['nome-add'];

$sNovoNome = utf8_encode($sNome);
mysqli_query($sConn, "
                      INSERT INTO
                       COLABORADOR(nome)
                       VALUES ('$sNovoNome')
                      ");





