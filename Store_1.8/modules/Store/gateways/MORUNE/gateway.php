<?php
/**
 * MORUNE_Gateway class
 *
 * @package Modules\Store
 * @author AMGewka
 * @version 1.8
 * @license MIT
 */
class MORUNE_Gateway extends GatewayBase {

    public function __construct() {
        $name = 'MORUNE';
        $author = '<a href="https://github.com/AMGewka" target="_blank" rel="nofollow noopener">AMGewka</a>';
        $gateway_version = '1.8';
        $store_version = '1.7.1';
        $settings = ROOT_PATH . '/modules/Store/gateways/MORUNE/gateway_settings/settings.php';

        parent::__construct($name, $author, $gateway_version, $store_version, $settings);
    }

    public function onCheckoutPageLoad(TemplateBase $template, Customer $customer): void {}

    public function processOrder(Order $order): void {
        $shopId = StoreConfig::get('MORUNE.shopuuid_key');
        $apiKey = StoreConfig::get('MORUNE.secret1_key');
        $callba = StoreConfig::get('MORUNE.enot_callb');
        $apiurl = StoreConfig::get('MORUNE.enot_apiurl');
        
        if ($shopId == null || empty($shopId)) {
            $this->addError('The administration has not completed the configuration of this gateway!');
            return;
        }

        $payment_id = $order->data()->id;
        $order_amount = $order->getAmount()->getTotalCents() / 100;
        $currency = $order->getAmount()->getCurrency();

        $data = [
            "amount" => $order_amount,
            "order_id" => (string) $payment_id,
            "currency" => $currency,
            "shop_id" => $shopId,
            "hook_url" => $callba,
        ];

        $url = $apiurl;

        $headers = [
          "accept: application/json",
          "content-type: application/json",
          "x-api-key: {$apiKey}"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($responseData['status'] == 200) {
            header('Location: ' . $responseData['data']['url']);
        }
    }

    public function handleReturn(): bool {
        if (isset($_GET['do']) && $_GET['do'] == 'success') {
            header("Location: " . URL::getSelfURL(), '/') . URL::build('/store/');
        }

        return false;
    }

    public function handleListener(): void {
        $shopId = StoreConfig::get('MORUNE.shopuuid_key');
        $apiKey = StoreConfig::get('MORUNE.secret1_key');
        $extraApiKey = StoreConfig::get('MORUNE.secret2_key');

        $data = json_decode(file_get_contents('php://input'), true);

        ksort($data);
        $signature = hash_hmac('sha256', json_encode($data), $extraApiKey);
        if ($_SERVER['HTTP_X_API_SHA256_SIGNATURE'] !== $signature) {
            http_response_code(401);
            exit();
        }

        $payment = new Payment($data['order_id'], 'transaction');
        switch ($data['status']) {
            case 'success':
                $paymentData = [
                    'transaction' => $data['order_id'],
                    'amount_cents' => Store::toCents($data['amount']),
                    'currency' => $data['currency'],
                    'fee_cents' => '0'
                ];
                $payment->handlePaymentEvent(Payment::COMPLETED, $paymentData);
                break;

            case 'expired':
            case 'fail':
                $paymentData = [
                    'transaction' => $data['order_id'],
                    'amount_cents' => Store::toCents($data['amount']),
                    'currency' => $data['currency'],
                    'fee_cents' => '0'
                ];
                $payment->handlePaymentEvent(Payment::DENIED, $paymentData);
                break;

            case 'refund':
                $paymentData = [
                    'transaction' => $data['order_id'],
                    'amount_cents' => Store::toCents($data['refund_amount']),
                    'currency' => $data['currency'],
                    'fee_cents' => '0'
                ];
                $payment->handlePaymentEvent(Payment::REFUNDED, $paymentData);
                break;
        }
    }

}

$gateway = new ENOT_Gateway();