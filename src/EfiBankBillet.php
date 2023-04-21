<?php

namespace App;

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class EfiBankBillet
{
    /**
     * Client Id Api
     *
     * @var string
     */
    private string $clientId;

    /**
     * Secret Key Api
     *
     * @var string
     */
    private string $clientSecret;

    /**
     * Set Sandbox Environment
     *
     * @var boolean
     */
    protected bool $sandbox;

    /**
     * Custom Identification [custom_id] and
     * Url Notification to Webhook [notification_url]
     *
     * @var array
     */
    protected array $metadata;

    /**
     * Items to Bank Billet
     *
     * @var array
     */
    private array $items;

    /**
     * Customer to Generate Bank Billet
     *
     * @var array
     */
    private array $customer;

    /**
     * Tax Configurations
     *
     * @var array
     */
    private array $configurations;

    /**
     * Construct Object
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param boolean $sandbox
     */
    public function __construct(string $clientId, string $clientSecret, bool $sandbox = true)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->sandbox = $sandbox;
    }

    /**
     * Get url Notification to Webhook [notification_url]
     *
     * @return  array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set url Notification to Webhook [notification_url]
     *
     * @param  array  $metadata Array With Custom_id and Url Notification to Webhook [notification_url]
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Set Items to Billet
     *
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Get Items to Billet
     *
     * @return array $items
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get customer to Generate Bank Billet
     *
     * @return  array
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set customer to Generate Bank Billet
     *
     * @param  array  $customer  Customer to Generate Bank Billet
     */
    public function setCustomer(array $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get tax Configurations
     *
     * @return  array
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }

    /**
     * Set tax Configurations
     *
     */
    public function setConfigurations(int $fine = 200, int $interest = 33)
    {
        $this->configurations = array(
            "fine" => $fine,
            "interest" => $interest
        );
    }

    /**
     * Create Billet With Bolix
     */
    public function createOneStepCharge(string $expireAt, string $message)
    {
        $options = $this->setOptions();

        $bankingBillet = [
            "expire_at" => $expireAt,
            "message" => $message,
            "customer" => $this->getCustomer(),
            "configurations" => $this->getConfigurations()
        ];

        $payment = [
            "banking_billet" => $bankingBillet
        ];

        $body = [
            "items" => $this->getItems(),
            "metadata" => $this->getMetadata(),
            "payment" => $payment
        ];

        try {
            $api = new Gerencianet($options);
            $response = $api->createOneStepCharge($params = [], $body);
            $response['success'] = ($response['code'] == 200);
        } catch (GerencianetException $e) {
            $response = array(
                'success' => false,
                'code' => $e->code,
                'error' => $e->error,
                'description' => $e->errorDescription
            );
        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'error' => $e->getMessage(),
            );
        }

        return $response;
    }

    /**
     * Cancel Charge
     *
     * @param integer $chargeId
     * @return void
     */
    public function cancelCharge(int $chargeId)
    {
        $options = $this->setOptions();

        $params = [
            'id' => $chargeId
        ];

        try {
            $api = new Gerencianet($options);
            $charge = $api->cancelCharge($params, []);

            return $charge['code'] == 200;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Update Metada Charge
     *
     * @param integer $chargeId
     * @param array $metadata
     * @return void
     */
    public function updateChargeMetada(int $chargeId, array $metadata)
    {
        $options = $this->setOptions();

        $params = [
            'id' => $chargeId
        ];

        try {
            $api = new Gerencianet($options);
            $charge = $api->updateChargeMetadata($params, $metadata);

            return $charge['code'] == 200;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Resend Email to Client
     *
     * @param integer $chargeId
     * @param string $email
     * @return void
     */
    public function sendBilletEmail(int $chargeId, string $email)
    {
        $options = $this->setOptions();

        $params = [
            'id' => $chargeId
        ];

        $body = [
            'email' => $email
        ];

        try {
            $api = new Gerencianet($options);
            $charge = $api->sendBilletEmail($params, $body);

            return $charge['code'] == 200;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Set Options to Api Opperations
     *
     * @return array
     */
    private function setOptions(): array
    {
        return array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'sandbox' => $this->sandbox
        );
    }
}
