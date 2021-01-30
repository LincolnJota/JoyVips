<?php
//header('Content-Type: application/json');

$unsafeId = $_GET['id'] ?? null;
if ($unsafeId == null) {
  exit('missing id');
}

//Config section
$config = include('config.php');

$receivedId = intval(preg_replace("/[^0-9]/", "", $unsafeId));
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($config->host, $config->user, $config->pass, $config->database);
$obj->results[0]->status

if ($mysqli->connect_errno) {
   exit('Falha ao conectar.');
}

$stmt = $mysqli->prepare("SELECT * FROM payments WHERE id >= ?");
$stmt->bind_param('i', $receivedId);
$stmt->execute();

$result = $stmt->get_result();

$payments = [];
$index = 0;
while ($fetch = $result->fetch_assoc()) {
  $id = $fetch['id'];
  $player = $fetch['player'];
  $product = $fetch['product'];
  $payments[$index] = array('id'=>$id, 'player'=>$player, 'product'=>$product);
  $index++;
}

$response = array('payments'=>$payments); 
echo json_encode($response);


echo '<br />Total:'. count($payments);


$stmt->close();
$mysqli->close(); 
?>