<?php

/**
 * @package        Arastta eCommerce
 * @license        GNU General Public License version 3; see LICENSE.txt
 */
class ControllerPaymentCoinPayments extends Controller
{

    /** @var array $error Validation errors */
    protected $error = array();

    /**
     * CoinPayments Payment Admin Controller Constructor
     * @param Registry $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->language('payment/coinpayments');
    }

    /**
     * Primary settings page
     * @return void
     */
    public function index()
    {

        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('coinpayments', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['button']) and $this->request->post['button'] == 'save') {
                $route = $this->request->get['route'];
                $module_id = '';
                if (isset($this->request->get['module_id'])) {
                    $module_id = '&module_id=' . $this->request->get['module_id'];
                } elseif ($this->db->getLastId()) {
                    $module_id = '&module_id=' . $this->db->getLastId();
                }
                $this->response->redirect($this->url->link($route, 'token=' . $this->session->data['token'] . $module_id, 'SSL'));
            }

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_client_id'] = $this->language->get('entry_client_id');
        $data['entry_webhooks'] = $this->language->get('entry_webhooks');
        $data['entry_client_secret'] = $this->language->get('entry_client_secret');

        $data['entry_cancelled_status'] = $this->language->get('entry_cancelled_status');
        $data['entry_completed_status'] = $this->language->get('entry_completed_status');
        $data['entry_pending_status'] = $this->language->get('entry_pending_status');

        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_total'] = $this->language->get('entry_total');

        $data['help_client_id'] = $this->language->get('help_client_id');
        $data['help_client_secret'] = $this->language->get('help_client_secret');
        $data['help_webhooks'] = $this->language->get('help_webhooks');
        $data['help_total'] = $this->language->get('help_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_saveclose'] = $this->language->get('button_saveclose');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/coinpayments', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('payment/coinpayments', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'] . '&filter_type=payment', 'SSL');

        if (isset($this->request->post['coinpayments_client_id'])) {
            $data['coinpayments_client_id'] = $this->request->post['coinpayments_client_id'];
        } else {
            $data['coinpayments_client_id'] = $this->config->get('coinpayments_client_id');
        }
        if (isset($this->request->post['coinpayments_client_secret'])) {
            $data['coinpayments_client_secret'] = $this->request->post['coinpayments_client_secret'];
        } else {
            $data['coinpayments_client_secret'] = $this->config->get('coinpayments_client_secret');
        }
        if (isset($this->request->post['coinpayments_webhooks'])) {
            $data['coinpayments_webhooks'] = $this->request->post['coinpayments_webhooks'];
        } else {
            $data['coinpayments_webhooks'] = $this->config->get('coinpayments_webhooks');
        }

        if (isset($this->request->post['coinpayments_cancelled_status'])) {
            $data['coinpayments_cancelled_status'] = $this->request->post['coinpayments_cancelled_status'];
        } else {
            $data['coinpayments_cancelled_status'] = $this->config->get('coinpayments_cancelled_status');
        }
        if (isset($this->request->post['coinpayments_completed_status'])) {
            $data['coinpayments_completed_status'] = $this->request->post['coinpayments_completed_status'];
        } else {
            $data['coinpayments_completed_status'] = $this->config->get('coinpayments_completed_status');
        }
        if (isset($this->request->post['coinpayments_pending_status'])) {
            $data['coinpayments_pending_status'] = $this->request->post['coinpayments_pending_status'];
        } else {
            $data['coinpayments_pending_status'] = $this->config->get('coinpayments_pending_status');
        }

        if (isset($this->request->post['coinpayments_geo_zone_id'])) {
            $data['coinpayments_geo_zone_id'] = $this->request->post['coinpayments_geo_zone_id'];
        } else {
            $data['coinpayments_geo_zone_id'] = $this->config->get('coinpayments_geo_zone_id');
        }

        if (isset($this->request->post['coinpayments_status'])) {
            $data['coinpayments_status'] = $this->request->post['coinpayments_status'];
        } else {
            $data['coinpayments_status'] = $this->config->get('coinpayments_status');
        }
        if (isset($this->request->post['coinpayments_sort_order'])) {
            $data['coinpayments_sort_order'] = $this->request->post['coinpayments_sort_order'];
        } else {
            $data['coinpayments_sort_order'] = $this->config->get('coinpayments_sort_order');
        }
        if (isset($this->request->post['coinpayments_total'])) {
            $data['coinpayments_total'] = $this->request->post['coinpayments_total'];
        } else {
            $data['coinpayments_total'] = $this->config->get('coinpayments_total');
        }

        $this->load->model('localisation/order_status');
        $this->load->model('localisation/geo_zone');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();


        $data['error_warning'] = '';
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } elseif (isset($this->session->data['warning'])) {
            $data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        } else {
            $data['error_warning'] = '';
        }

        $data['success'] = '';
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

        $data['error_status'] = '';
        if (isset($this->error['status'])) {
            $data['error_status'] = $this->error['status'];
        }

        $data['error_client_id'] = '';
        if (isset($this->error['client_id'])) {
            $data['error_client_id'] = $this->error['client_id'];
        }

        $data['error_client_secret'] = '';
        if (isset($this->error['client_secret'])) {
            $data['error_client_secret'] = $this->error['client_secret'];
        }

        $data['error_invalid_credentials'] = '';
        if (isset($this->error['invalid_credentials'])) {
            $data['error_invalid_credentials'] = $this->error['invalid_credentials'];
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/coinpayments.tpl', $data));
    }

    /**
     * Install the extension by setting up some smart defaults
     * @return void
     */
    public function install()
    {
        $this->load->model('localisation/order_status');
        $order_statuses = $this->model_localisation_order_status->getOrderStatuses();
        foreach ($order_statuses as $order_status) {
            if ($order_status['name'] == 'Complete') {
                $default_completed = $order_status['order_status_id'];
            }
            if ($order_status['name'] == 'Canceled') {
                $default_cancelled = $order_status['order_status_id'];
            }
            if ($order_status['name'] == 'Pending') {
                $default_pending = $order_status['order_status_id'];
            }
        }

        $this->load->model('setting/setting');
        $default_settings = array(
            'coinpayments_client_id' => '',
            'coinpayments_client_secret' => '',
            'coinpayments_webhooks' => 0,
            'coinpayments_cancelled_status' => $default_cancelled,
            'coinpayments_completed_status' => $default_completed,
            'coinpayments_pending_status' => $default_pending,
            'coinpayments_geo_zone_id' => '0',
            'coinpayments_sort_order' => null,
        );
        $this->model_setting_setting->editSetting('coinpayments', $default_settings);
    }

    /**
     * Uninstall the extension by removing the settings
     * @return void
     */
    public function uninstall()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('coinpayments');
    }

    /**
     * Validate the primary settings for the CoinPayments extension
     * @return boolean True if the settings provided are valid
     */
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/coinpayments')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['coinpayments_client_id'])) {
            $this->error['client_id'] = $this->language->get('error_client_id');
        }

        if (!empty($this->request->post['coinpayments_webhooks']) && empty($this->request->post['coinpayments_client_secret'])) {
            $this->error['client_secret'] = $this->language->get('error_client_secret');
        }

        if (empty($this->error)) {

            $this->load->model('payment/coinpayments');

            if (empty($this->request->post['coinpayments_webhooks']) &&
                !$this->model_payment_coinpayments->validateInvoice($this->request->post['coinpayments_client_id'])
            ) {

                $this->error['invalid_credentials'] = $this->language->get('error_invalid_credentials');

            } elseif (!empty($this->request->post['coinpayments_webhooks']) &&
                !$this->model_payment_coinpayments->validateWebhook(
                    $this->request->post['coinpayments_client_id'],
                    $this->request->post['coinpayments_client_secret']
                )
            ) {

                $this->error['invalid_credentials'] = $this->language->get('error_invalid_credentials');

            }
        }

        return empty($this->error);

        return !$this->error;
    }
}