<?php

namespace PaiementCB\Model;


class ReponseBancaire
{
    const PATH_BIN = "src/PaiementCB/Sherlocks/bin/static/response";
    const PATH_FILE = "src/PaiementCB/Sherlocks/param_demo/pathfile";
    const PATH_LOG_ACCEPTE = "logs/logs_valides.txt";
    const PATH_LOG_REFUSE = "logs/logs_refuses.txt";
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function analyseRequete($message)
    {
        $param = " message=" . $message;
        $param .= " pathfile=" . $this::PATH_FILE;
        $res = exec($this::PATH_BIN . $param);
        $tableau = explode("!", $res);
        return $tableau;
    }

    public function paiementAccepte($tableau)
    {

        $code = $tableau[1];
        $error = $tableau[2];
        $merchant_id = $tableau[3];
        $merchant_country = $tableau[4];
        $amount = $tableau[5];
        $transaction_id = $tableau[6];
        $payment_means = $tableau[7];
        $transmission_date = $tableau[8];
        $payment_time = $tableau[9];
        $payment_date = $tableau[10];
        $response_code = $tableau[11];
        $payment_certificate = $tableau[12];
        $authorisation_id = $tableau[13];
        $currency_code = $tableau[14];
        $card_number = $tableau[15];
        $cvv_flag = $tableau[16];
        $cvv_response_code = $tableau[17];
        $bank_response_code = $tableau[18];
        $complementary_code = $tableau[19];
        $complementary_info = $tableau[20];
        $return_context = $tableau[21];
        $caddie = $tableau[22];
        $receipt_complement = $tableau[23];
        $merchant_language = $tableau[24];
        $language = $tableau[25];
        $customer_id = $tableau[26];
        $order_id = $tableau[27];
        $customer_email = $tableau[28];
        $customer_ip_address = $tableau[29];
        $capture_day = $tableau[30];
        $capture_mode = $tableau[31];
        $data = $tableau[32];

        $fp = fopen($this::PATH_LOG_ACCEPTE, "a");

        fwrite($fp, "merchant_id : $merchant_id\n");
        fwrite($fp, "merchant_country : $merchant_country\n");
        fwrite($fp, "amount : $amount\n");
        fwrite($fp, "transaction_id : $transaction_id\n");
        fwrite($fp, "transmission_date: $transmission_date\n");
        fwrite($fp, "payment_means: $payment_means\n");
        fwrite($fp, "payment_time : $payment_time\n");
        fwrite($fp, "payment_date : $payment_date\n");
        fwrite($fp, "response_code : $response_code\n");
        fwrite($fp, "payment_certificate : $payment_certificate\n");
        fwrite($fp, "authorisation_id : $authorisation_id\n");
        fwrite($fp, "currency_code : $currency_code\n");
        fwrite($fp, "card_number : $card_number\n");
        fwrite($fp, "cvv_flag: $cvv_flag\n");
        fwrite($fp, "cvv_response_code: $cvv_response_code\n");
        fwrite($fp, "bank_response_code: $bank_response_code\n");
        fwrite($fp, "complementary_code: $complementary_code\n");
        fwrite($fp, "complementary_info: $complementary_info\n");
        fwrite($fp, "return_context: $return_context\n");
        fwrite($fp, "caddie : $caddie\n");
        fwrite($fp, "receipt_complement: $receipt_complement\n");
        fwrite($fp, "merchant_language: $merchant_language\n");
        fwrite($fp, "language: $language\n");
        fwrite($fp, "customer_id: $customer_id\n");
        fwrite($fp, "order_id: $order_id\n");
        fwrite($fp, "customer_email: $customer_email\n");
        fwrite($fp, "customer_ip_address: $customer_ip_address\n");
        fwrite($fp, "capture_day: $capture_day\n");
        fwrite($fp, "capture_mode: $capture_mode\n");
        fwrite($fp, "data: $data\n");
        fwrite($fp, "-------------------------------------------\n");
        fclose($fp);
        return $tableau;

    }

    public function paiementRefuse($tableau)
    {

        $code = $tableau[1];
        $error = $tableau[2];
        $merchant_id = $tableau[3];
        $merchant_country = $tableau[4];
        $amount = $tableau[5];
        $transaction_id = $tableau[6];
        $payment_means = $tableau[7];
        $transmission_date = $tableau[8];
        $payment_time = $tableau[9];
        $payment_date = $tableau[10];
        $response_code = $tableau[11];
        $payment_certificate = $tableau[12];
        $authorisation_id = $tableau[13];
        $currency_code = $tableau[14];
        $card_number = $tableau[15];
        $cvv_flag = $tableau[16];
        $cvv_response_code = $tableau[17];
        $bank_response_code = $tableau[18];
        $complementary_code = $tableau[19];
        $complementary_info = $tableau[20];
        $return_context = $tableau[21];
        $caddie = $tableau[22];
        $receipt_complement = $tableau[23];
        $merchant_language = $tableau[24];
        $language = $tableau[25];
        $customer_id = $tableau[26];
        $order_id = $tableau[27];
        $customer_email = $tableau[28];
        $customer_ip_address = $tableau[29];
        $capture_day = $tableau[30];
        $capture_mode = $tableau[31];
        $data = $tableau[32];

        $fp = fopen($this::PATH_LOG_REFUSE, "a");

        fwrite($fp, "merchant_id : $merchant_id\n");
        fwrite($fp, "merchant_country : $merchant_country\n");
        fwrite($fp, "amount : $amount\n");
        fwrite($fp, "transaction_id : $transaction_id\n");
        fwrite($fp, "transmission_date: $transmission_date\n");
        fwrite($fp, "payment_means: $payment_means\n");
        fwrite($fp, "payment_time : $payment_time\n");
        fwrite($fp, "payment_date : $payment_date\n");
        fwrite($fp, "response_code : $response_code\n");
        fwrite($fp, "payment_certificate : $payment_certificate\n");
        fwrite($fp, "authorisation_id : $authorisation_id\n");
        fwrite($fp, "currency_code : $currency_code\n");
        fwrite($fp, "card_number : $card_number\n");
        fwrite($fp, "cvv_flag: $cvv_flag\n");
        fwrite($fp, "cvv_response_code: $cvv_response_code\n");
        fwrite($fp, "bank_response_code: $bank_response_code\n");
        fwrite($fp, "complementary_code: $complementary_code\n");
        fwrite($fp, "complementary_info: $complementary_info\n");
        fwrite($fp, "return_context: $return_context\n");
        fwrite($fp, "caddie : $caddie\n");
        fwrite($fp, "receipt_complement: $receipt_complement\n");
        fwrite($fp, "merchant_language: $merchant_language\n");
        fwrite($fp, "language: $language\n");
        fwrite($fp, "customer_id: $customer_id\n");
        fwrite($fp, "order_id: $order_id\n");
        fwrite($fp, "customer_email: $customer_email\n");
        fwrite($fp, "customer_ip_address: $customer_ip_address\n");
        fwrite($fp, "capture_day: $capture_day\n");
        fwrite($fp, "capture_mode: $capture_mode\n");
        fwrite($fp, "data: $data\n");
        fwrite($fp, "-------------------------------------------\n");
        fclose($fp);

        return $tableau;
    }
}
