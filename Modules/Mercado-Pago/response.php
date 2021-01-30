<!--

 * This file is part of a JoyGDR project
 *
 * Copyright (c) JoyGDR
 * https://github.com/lincolnjota
 */
 
 * It is not necessary to modify this file, consider editing only products.php and config.php

-->

<?php

if(isset($_GET['id']) and isset($_GET['topic']) and $_GET['topic'] == "payment") {
  $id = $_GET['id'];


  $config = include('config.php');

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'. $id .'?access_token='. $config->acsstoken);
  $result = curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result);

  $status = isset($obj->status) ? "$obj->status" : "ERRO";

  $vip = isset($obj->description) ? "$obj->description" : "ERRO";
  $id = isset($obj->id) ? "$obj->id" : "ERRO" ;

  echo "Id: ". $id."<br />";
  echo "Status: ". $status. '<br />';
  echo "Vip: $vip <br />";

  if ($status == "approved") {
    validatorkey($id, $vip);
  } else {
    die("Pagamento não aprovado.");
  }
} else {
  die("ERROR");
}

function validatorkey($id, $vipname) {
  //Config section
  $config = include('config.php');
  
  $url = "https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&id=$id";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  $headers = array(
     "Authorization: Bearer $config->acsstoken",
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  
  $resp = curl_exec($curl);
  curl_close($curl);
  
  $obj = json_decode($resp);
  //var_dump($obj);
  $status = $obj->results[0]->status;
  if($status == "approved") {
    salvarMysql($id, $vipname);
  } else {
    die("ERROR");
  }
}

function salvarMysql($key, $vipn) {
  //Config section
  $config = include('config.php');

  // Criando a conexão
  $conn = new mysqli($config->host, $config->user, $config->pass, $config->database);

  // Verificar conexão
  if ($conn->connect_error) {
    die("Ocorreu um erro (Contactar administração): " . $conn->connect_error);
  }

  $sql = "INSERT INTO keylist (id, serials, vips) VALUES (NULL, '$key', '$vipn')";


  if ($conn->query($sql) === TRUE) {
    echo "Registro criado com sucesso";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>