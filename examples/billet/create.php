<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);

$metadata = array(
    "custom_id" => "Order_00001",
    "notification_url" => "https://your-domain.com.br/notification/"
);

$items = array(
    array(

        "name" => "Product 1",
        "amount" => 1,
        "value" => 9990 // 9990 é o equivalente a R$ 99,90
    )
);

$customer = array(
    "name" => "Mário Lucas",
    "cpf" => "", // CPF sem pontos e traço
    "email" => "client@email.com" // E-mail não obrigatório
);

$efi->setMetadata($metadata);
$efi->setItems($items);
$efi->setCustomer($customer);
$efi->setConfigurations(200, 33);

$expireAt = '2023-04-21'; // Data no formato YYYY-MM-DD
$message = 'Your message here.';
$chargeData = $efi->createOneStepCharge($expireAt, $message);
