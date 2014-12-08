<?php
class ControllerPaymentWhite extends Controller
{
    public function index()
    {

        $this->load->model('checkout/order');

        $this->load->language('payment/white');

        $data['text_credit_card'] = $this->language->get('text_credit_card');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['entry_cc_number'] = $this->language->get('entry_cc_number');
        $data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
        $data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');

        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['months'] = array();

        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array(
                'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
                'value' => sprintf('%02d', $i)
            );
        }

        $today = getdate();

        $data['year_expire'] = array();

        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array(
                'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }

        $data['white_public_api'] = $this->config->get('white_public_api');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['currency'] = $order_info['currency_code'];

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/white.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/white.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/white.tpl', $data);
        }
    }

    public function send()
    {

        require_once './vendor/autoload.php';

        $this->load->model('checkout/order');

        $error = null;

        try {

            White::setApiKey($this->config->get('white_secret_api'));

            $result = White_Charge::create(array(
                "amount"      => $this->request->post['amount'],
                "currency"    => $this->request->post['currency'],
                "card"        => $this->request->post['card'],
                "description" => "Charge for order: " . $this->session->data['order_id']
            ));

        } catch (White_Error $e) {

            $error = $e->getMessage();

        }

        $json = array();

        if (!$error) {

            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('white_order_status_id'), 'Charge added: ' . $result['tag'], false);
            $json['redirect'] = $this->url->link('checkout/success', '', 'SSL');

        } else {

            $json['error'] = $error;
            $this->log->write('WHITE ERROR: ' . $error);

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

    }

}
