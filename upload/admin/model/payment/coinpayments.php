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
        $invoice = $this->coinpayments->createSimpleInvoice($client_id);
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
            $notificationUrlPending = $this->coinpayments->getNotificationUrl($client_id, Coinpayments::PENDING_EVENT);
            $notificationUrlPaid = $this->coinpayments->getNotificationUrl($client_id, Coinpayments::PAID_EVENT);
            if (!in_array($notificationUrlCancelled, $webhooks_urls_list) || !in_array($notificationUrlPending, $webhooks_urls_list) || !in_array($notificationUrlPaid, $webhooks_urls_list)) {
                $webHookCancelled = $this->coinpayments->createWebHook($client_id, $client_secret,$notificationUrlCancelled,Coinpayments::CANCELLED_EVENT);
                $webHookPending = $this->coinpayments->createWebHook($client_id, $client_secret,$notificationUrlPending,Coinpayments::PENDING_EVENT);
                $webHookPaid = $this->coinpayments->createWebHook($client_id, $client_secret,$notificationUrlPaid,Coinpayments::PAID_EVENT);
                if (!empty($webHookCancelled) && !empty($webHookPending) && !empty($webHookPaid)) {
                    $valid = true;
                }
            } else {
                $valid = true;
            }
        }

        return $valid;
    }
}
