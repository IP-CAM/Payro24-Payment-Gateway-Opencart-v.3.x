<?php

/**
 * payro24 payment gateway
 *
 * @developer JMDMahdi,vispa, mnbp1371
 * @publisher payro24
 * @copyright (C) 2018 payro24
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 *
 * http://payro24.ir
 */

class ControllerExtensionPaymentpayro24 extends Controller
{
    /**
     * @var array
     */
    private $error = array();

    /**
     *  payro24 setting for admin
     */
    public function index()
    {
        $this->load->language('extension/payment/payro24');

        $this->document->setTitle(strip_tags($this->language->get('heading_title')));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_payro24', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/payro24', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/payro24', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        if (isset($this->request->post['payment_payro24_api_key'])) {
            $data['payment_payro24_api_key'] = $this->request->post['payment_payro24_api_key'];
        } else {
            $data['payment_payro24_api_key'] = $this->config->get('payment_payro24_api_key');
        }


        if (isset($this->request->post['payment_payro24_order_status_id'])) {
            $data['payment_payro24_order_status_id'] = $this->request->post['payment_payro24_order_status_id'];
        } else {
            $data['payment_payro24_order_status_id'] = $this->config->get('payment_payro24_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['payment_payro24_status'])) {
            $data['payment_payro24_status'] = $this->request->post['payment_payro24_status'];
        } else {
            $data['payment_payro24_status'] = $this->config->get('payment_payro24_status');
        }

        if (isset($this->request->post['payment_payro24_sort_order'])) {
            $data['payment_payro24_sort_order'] = $this->request->post['payment_payro24_sort_order'];
        } else {
            $data['payment_payro24_sort_order'] = $this->config->get('payment_payro24_sort_order');
        }

        if (isset($this->request->post['payment_payro24_failed_massage'])) {
            $data['payment_payro24_failed_massage'] = $this->request->post['payment_payro24_failed_massage'];
        } else {
            $data['payment_payro24_failed_massage'] = $this->config->get('payment_payro24_failed_massage');
        }

        if (isset($this->request->post['payment_payro24_success_massage'])) {
            $data['payment_payro24_success_massage'] = $this->request->post['payment_payro24_success_massage'];
        } else {
            $data['payment_payro24_success_massage'] = $this->config->get('payment_payro24_success_massage');
        }

        if (isset($this->request->post['payment_payro24_sandbox'])) {
            $data['payment_payro24_sandbox'] = $this->request->post['payment_payro24_sandbox'];
        } else {
            $data['payment_payro24_sandbox'] = $this->config->get('payment_payro24_sandbox');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/payro24', $data));
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/payro24')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['payment_payro24_api_key']) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }

        return !$this->error;
    }

}

?>
