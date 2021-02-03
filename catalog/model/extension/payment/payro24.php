<?php
/**
 * payro24 payment gateway
 *
 * @developer JMDMahdi, vispa, mnbp1371
 * @publisher payro24
 * @copyright (C) 2018 payro24
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 *
 * http://payro24.ir
 */
class ModelExtensionPaymentpayro24 extends Model
{
    public function getMethod($address)
    {
        if ($this->config->get('payment_payro24_status')) {
            $status = true;
        } else {
            $status = false;
        }
        $method_data = array();
        if ($status) {
            $method_data = array(
                'code' => 'payro24',
                'title' => $this->config->get('payment_payro24_title'),
                'terms' => '',
                'sort_order' => $this->config->get('payment_payro24_sort_order')
            );
        }
        return $method_data;
    }
}

?>
