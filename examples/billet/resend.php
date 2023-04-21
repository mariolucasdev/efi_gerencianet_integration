<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$chargeId = '';
$email = 'client@gmail.com';

$efi = new App\EfiBankBillet(HOMO_CLIENT_ID, HOMO_CLIENT_SECRET, true);
$efi->sendBilletEmail($chargeId, $email);
