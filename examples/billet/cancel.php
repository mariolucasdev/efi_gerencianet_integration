<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$chargeId = '';

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);
$efi->cancelCharge($chargeId);
