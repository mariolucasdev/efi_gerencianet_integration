<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$chargeId = '';
$email = 'client@gmail.com';

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);
$efi->sendBilletEmail($chargeId, $email);
