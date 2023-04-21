<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(HOMO_CLIENT_ID, HOMO_CLIENT_SECRET, true);

$metadata = array(
    "custom_id" => "Order_00001",
    "notification_url" => "https://your-domain.com.br/notification/"
);

$efi->updateChargeMetada($chargeData['data']['charge_id'], $metadata);
