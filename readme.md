# Emissão de Boleto com Efí - Gerencianet

Faça o donwload do pacote ou instale via composer:

```
composer require mariolucasdev/efi_gerencianet_integration
```

Instale as dependências:

```
composer install
```

## Credenciais, Certificado e Autorização

Para ter acesso as suas chaves de identificação de Produção e Homologação, basta seguir as intruções no site da do próprio Gerencianet:

https://dev.gerencianet.com.br/docs/api-pix-autenticacao-e-seguranca

Com sua credenciais geradas crie um arquivo chamado _contants.php_ com as seguintes configurações.

```php
// Credenciais para ambiente de produção
define('CLIENT_ID', '');
define('CLIENT_SECRET', '');

// Credenciais para ambiente de homologação
define('SANDBOX_CLIENT_ID', '');
define('SANDBOX_CLIENT_SECRET', '');
```

## Utilização

Carregue o autoload e seu arquivo _contants.php_ que contém suas credenciais.

Obs.: Para ambiente de Homologação utilize o 3º parâmetro como true ou false, para produção.

```php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);
```

# Gerando o Boleto

```php
$metadata = array(
    "custom_id" => "", // Identificação personalizada da cobrança
    "notification_url" => "" //Url para recebimento de notificação sobre alteração na cobrança
);

$items = array(
    array(
        "name" => "", // Descrição do Produto ou Serviço
        "amount" => 1, // Quantidade
        "value" => 9990 // Valor Obs.: 9999 é o equivalente à R$ 90,90
    )
);

// Apenas Nome e CPF são obrigatórios, para ver os demais parâmetros disponíveis veja a documentação oficial https://dev.gerencianet.com.br/docs/gerar-boleto-bancario
$customer = array(
    "name" => "Mário Lucas",
    "cpf" => "09102295466",
    // "email" => "seucliente@email.com"
);

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);
$efi->setMetadata($metadata);
$efi->setItems($items);
$efi->setCustomer($customer);
$efi->setConfigurations(200, 33) //Multa 2% e Juros 0,33%/dia;

// A data deve ser no formato Ano-mês-dia Ex: 2023-04-21
$chargeData = $efi->createOneStepCharge($data, $mensagem);
```

Se correr tudo bem com o envio, você terá dados de resposta semelhante ao exemplo a baixo:

```json
{
  "code": 200, // retorno HTTP "200" informando que o pedido foi bem sucedido
  "data": {
    "barcode": "00000.00000 00000.000000 00000.000000 0 00000000000000", // linha digitável do boleto
    "pix":{
      "qrcode":"00020101021226990014BR.GOV.BCB.PIX2577qrcodes-pix.gerencianet.com.br/bolix/v2/cobv/0000000000000000000000000000GERENCIANET SA6010OURO PRETO62070503***63047CB1", // BRCode ou copia e cola
      "qrcode_image":"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmc vMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NSA0NSIgc2hhcGUtcmVuZGVyaW5nPSJjcmlzcEVkZ2VzIj48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNMCAwaDQ1djQ1SD..." // QR Code imagem
    },
    "link": "link_https_para_acesso_o_bolix", // link responsivo do Bolix gerado
    "billet_link":"link_https_para_acesso_o_bolix", // link do Bolix gerado
    "pdf": {
      "charge": "link_https_do_pdf_da_cobranca" // link do PDF do Bolix
    },
    "expire_at": "2022-12-15", // data de vencimento do boleto no seguinte formato: 2022-12-15 (ou seja, equivale a 15/12/2022)
    "charge_id": numero_charge_id, // número da ID referente à transação gerada
    "status": "waiting", // forma de pagamento selecionada, aguardando a confirmação do pagamento ("waiting" equivale a "aguardando")
    "total": 5990, // valor, em centavos. Por exemplo: 5990 (equivale a R$ 59,90)
    "payment": "banking_billet" // forma de pagamento associada à esta transação ("banking_billet" equivale a "boleto bancário")
  }
}
```

# Editando Metadados do Boleto

```php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../constants.php";

$efi = new App\EfiBankBillet(SANDBOX_CLIENT_ID, SANDBOX_CLIENT_SECRET, true);

// Você precisará do charge_id da cobrança.
$chargeId = '';

// Os metados poderão ser alterados aqui
$metadata = array(
    "custom_id" => "new_custom_id_8387",
    "notification_url" => "https://new-domain.com.br/notification/"
);

// retornará true ou mensagem de excessão.
$efi->updateChargeMetada($chargeId, $metadata);
```
