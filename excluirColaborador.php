<?php

require 'conexao.php';

$iId = $_POST['codigo'];

$sSql = "
        DELETE
          FROM COLABORADOR
         WHERE
          ID = '" . $iId . "'";

$sResult = $sConn->query($sSql);
?>