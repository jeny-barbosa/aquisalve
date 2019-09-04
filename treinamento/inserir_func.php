<?php

require 'conexao.php';

$sNome = $_POST['nome-add'];

mysqli_query($conn, "
    INSERT INTO
     COLABORADOR(nome)
     VALUES ('$sNome')
    ");





