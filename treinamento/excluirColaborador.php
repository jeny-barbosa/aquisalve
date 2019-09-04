<?php

require 'conexao.php';

$id = $_POST['codigo'];

$sSql = "
  DELETE
    FROM COLABORADOR
   WHERE
    ID = '".$id. "'";

$sResult = $conn->query($sSql);

?>