<?php

/**
 * CoinPayments Payment Model
 */
class Modelpaymentcoinpayments extends Model
{

    /** @var CoinPaymentsLibrary $coinpayments */
    private $coinpayments;

    /**
     * CoinPayments Payment Model Construct
     * @param Registry $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->library('coinpayments');
        $this->coinpayments = new Coinpayments($registry);
    }


    /**
     * @param $client_id
     * @return bool
     * @throws Exception
     */
    public function validateInvoice($client_id)
    {
        $invoice_params=array(
            'invoice_id' => 'Validate invoice',
            'currency_id' => 5057,
            'amount' => 1,
            'display_value' => '0.01',
            'notes_link' => 'Validate invoice'
        );
        $invoice = $this->coinpayments->createSimpleInvoice($client_id, $invoice_params);
        return !empty($invoice['id']);
    }

    /**
     * @param $client_id
     * @param $client_secret
     * @return bool
     * @throws Exception
     */
    public function validateWebhook($client_id, $client_secret)
    {

        $valid = false;

        $webhooks_list = $this->coinpayments->getWebhooksList($client_id, $client_secret);
        if (!empty($webhooks_list)) {

            $webhooks_urls_list = array();
            if (!empty($webhooks_list['items'])) {
                $webhooks_urls_list = array_map(function ($webHook) {
                    return $webHook['notificationsUrl'];
                }, $webhooks_list['items']);
            }
            $notificationUrlCancelled = $this->coinpayments->getNotificationUrl($client_id, Coinpayments::CANCELLED_EVENT);
            $notificationUrlPaid = $this->coinpayments->getNotificationUrl($client_id, Coinpayments::PAID_EVENT);
            if (!in_array($notificationUrlCancelled, $webhooks_urls_list) || !in_array($notificationUrlPaid, $webhooks_urls_list)) {
                if (!empty($this->coinpayments->createWebHook($client_id, $client_secret,$notificationUrlCancelled,Coinpayments::CANCELLED_EVENT)) && !empty( $this->coinpayments->createWebHook($client_id, $client_secret,$notificationUrlPaid,Coinpayments::PAID_EVENT))) {
                    $valid = true;
                }
            } else {
                $valid = true;
            }
        }

        return $valid;
    }
}
