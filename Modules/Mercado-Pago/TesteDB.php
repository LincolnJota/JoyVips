<!--

 * This file is part of a JoyGDR project
 *
 * Copyright (c) JoyGDR
 * https://github.com/lincolnjota
 */
 
 * It is not necessary to modify this file, consider editing only products.php and config.php

-->

<?php
  //Config section
  $config = include('config.php');

  // Criando a conexão
  $conn = new mysqli($config->host, $config->user, $config->pass, $config->database);

  // Verificar conexão
  if ($conn->connect_error) {
    die("Erro: <br />" . $conn->connect_error);
  }
  echo "Conexão bem sucedida com o banco de dados!";
  $conn->close();
?>