<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);

$chargeId = '';
$newCustomId = '';
$newNotificationUrl = '';

$metadata = array(
    "custom_id" => $newCustomId,
    "notification_url" => $newNotificationUrl
);

$efi->updateChargeMetada($chargeId, $metadata);
