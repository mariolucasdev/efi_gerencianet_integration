<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$chargeId = '';

$efi = new App\EfiBankBillet(HOMO_CLIENT_ID, HOMO_CLIENT_SECRET, true);
$efi->cancelCharge($chargeId);
