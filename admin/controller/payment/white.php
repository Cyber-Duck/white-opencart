<?php
class ControllerPaymentWhite extends Controller
{
    private $error = array();

    public function index()
    {

        $this->load->language('payment/white');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('white', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_secret_api'] = $this->language->get('entry_secret_api');
        $data['entry_public_api'] = $this->language->get('entry_public_api');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['help_total'] = $this->language->get('help_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['secret_api'])) {
            $data['error_secret_api'] = $this->error['secret_api'];
        } else {
            $data['error_secret_api'] = '';
        }

        if (isset($this->error['public_api'])) {
            $data['error_public_api'] = $this->error['public_api'];
        } else {
            $data['error_public_api'] = '';
        }

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
            'href' => $this->url->link('payment/white', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('payment/white', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['white_secret_api'])) {
            $data['white_secret_api'] = $this->request->post['white_secret_api'];
        } else {
            $data['white_secret_api'] = $this->config->get('white_secret_api');
        }

        if (isset($this->request->post['white_api'])) {
            $data['white_public_api'] = $this->request->post['white_public_api'];
        } else {
            $data['white_public_api'] = $this->config->get('white_public_api');
        }

        if (isset($this->request->post['white_total'])) {
            $data['white_total'] = $this->request->post['white_total'];
        } else {
            $data['white_total'] = $this->config->get('white_total');
        }

        if (isset($this->request->post['white_order_status_id'])) {
            $data['white_order_status_id'] = $this->request->post['white_order_status_id'];
        } else {
            $data['white_order_status_id'] = $this->config->get('white_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['white_geo_zone_id'])) {
            $data['white_geo_zone_id'] = $this->request->post['white_geo_zone_id'];
        } else {
            $data['white_geo_zone_id'] = $this->config->get('white_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['white_status'])) {
            $data['white_status'] = $this->request->post['white_status'];
        } else {
            $data['white_status'] = $this->config->get('white_status');
        }

        if (isset($this->request->post['white_sort_order'])) {
            $data['white_sort_order'] = $this->request->post['white_sort_order'];
        } else {
            $data['white_sort_order'] = $this->config->get('white_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/white.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/white')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['white_secret_api']) {
            $this->error['secret_api'] = $this->language->get('error_secret_api');
        }

        if (!$this->request->post['white_public_api']) {
            $this->error['public_api'] = $this->language->get('error_public_api');
        }

        return !$this->error;
    }
}
