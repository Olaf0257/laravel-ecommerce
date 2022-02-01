<?php 

namespace App\Paytabs;

class Paytabs {
	private $merchant_email;
    private $secret_key;

    function __construct($merchant_email, $secret_key) {
        $this->merchant_email = $merchant_email;
        $this->secret_key = $secret_key;
    }
    
    function create_pay_page($values) {
        $values['merchant_email'] = $this->merchant_email;
        $values['secret_key'] = $this->secret_key;
        $values['ip_customer'] = $_SERVER['REMOTE_ADDR'];
        $values['ip_merchant'] = $_SERVER['SERVER_ADDR'] ?? $_SERVER['HTTP_HOST'];
        return json_decode($this->runPost(config('services.paytabs.paypage_url'), $values));
    }
    
    function verify_payment($payment_reference){
        $values['merchant_email'] = $this->merchant_email;
        $values['secret_key'] = $this->secret_key;
        $values['payment_reference'] = $payment_reference;
        return json_decode($this->runPost(config('services.paytabs.verify_url'), $values));
    }
    
    function runPost($url, $fields) {
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = rtrim($fields_string, '&');
        $ch = curl_init();
        $ip = $_SERVER['REMOTE_ADDR'];

        $ip_address = array(
            "REMOTE_ADDR" => $ip,
            "HTTP_X_FORWARDED_FOR" => $ip
        );
        
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
}