<?php

require 'conexao.php';

//COLABORADOR
$sQueryColaborador = "
      SELECT ID, NOME
        FROM COLABORADOR
        ORDER BY NOME
      ";
$sListColaborador  = mysqli_query($conn, $sQueryColaborador);

//HORAS APONTADAS
$sSomaHoraApontada = "
      SELECT ID_COLABORADOR,
        SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_APONTADA))) AS TOTAL_HORAS
       FROM MOVIDESK
       JOIN COLABORADOR
         ON COLABORADOR = MOVIDESK.ID_COLABORADOR
       WHERE MOVIDESK.ID = %d";

$sSomaHoraTrabalhada = "
      SELECT ID_COLABORADOR,
        SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
       FROM MOVIDESK
       JOIN COLABORADOR
         ON COLABORADOR = MOVIDESK.ID_COLABORADOR
       WHERE MOVIDESK.ID = %d";

$sListHoraTrabalhada = mysqli_query($conn, $sSomaHoraTrabalhada);

//DIFERENÇA ENTRE HORAS
$sHoraDiferenca  = "
      SELECT
        @tot1:= SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))),
        @tot2:= SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_APONTADA))),
        (TIMEDIFF(@tot2,@tot1)) AS DIFERENCA
       FROM MOVIDESK
      ";
$sTotalDiferenca = mysqli_query($conn, $sHoraDiferenca);

//TABELA TANGERINO
$sQueryTang = "
      SELECT
        HORA_PONTO,
        DATA_PONTO
       FROM TANGERINO
";
$sListTangerino = mysqli_query($conn, $sQueryTang);

//CHAMADOS MOVIDESK
$sQueryChamado = "
      SELECT
          TICKET,
          DESCRICAO,
          DATA_PONTO,
          HORA_INICIO,
          HORA_FIM,
          HORA_APONTADA,
          HORA_TRABALHADA,
         CONVERT((TIMEDIFF(HORA_APONTADA,HORA_TRABALHADA)), TIME) AS DIFERENCA
       FROM MOVIDESK";

$sResultado = mysqli_query($conn, $sQueryChamado);

