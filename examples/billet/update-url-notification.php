<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(HOMO_CLIENT_ID, HOMO_CLIENT_SECRET, true);

$chargeId = '';
$newCustomId = '';
$newNotificationUrl = '';

$metadata = array(
    "custom_id" => $newCustomId,
    "notification_url" => $newNotificationUrl
);

$efi->updateChargeMetada($chargeId, $metadata);
