<?php
class Parcelpro {
    private $logger;
    private $config;
    private $registry;
    private static $instance;

    private $api_url     = 'https://login.parcelpro.nl';
    private $webhook_url = 'https://login.parcelpro.nl/api/opencart/order-created.php';

    /**
     * @param  object  $registry  Registry Object
     */
    public static function get_instance($registry) {
        if (is_null(static::$instance)) {
            static::$instance = new static($registry);
        }

        return static::$instance;
    }

    public function __get($name) {
        return $this->registry->get($name);
    }

    /**
     * @param  object  $registry  Registry Object
     *
     * You could load some useful libraries, few examples:
     *
     *   $registry->get('db');
     *   $registry->get('cache');
     *   $registry->get('session');
     *   $registry->get('config');
     *   and more...
     */
    public function __construct($registry) {
        $this->registry = $registry;
        $this->logger = $registry->get('log');
        $this->config = $registry->get('config');
    }


    public function define_shipping_method($chosen_shipping_method){
        $shipping_code = explode('_', $chosen_shipping_method);

        if($shipping_code[0] !== 'parcel') return array(
            "shipping_method" => null
        );

        $order_shipping_type_id = $shipping_code[4];
        $order_shipping_type = 'parcel_pro_type_id_' . $shipping_code[5];
        $order_shipping_rule_id = $shipping_code[5];

        $order_shipping_rules = $this->config->get($order_shipping_type . '_rule');

        if (is_array($order_shipping_rules)) {
            if (isset($order_shipping_rules[$order_shipping_rule_id])) {
                $order_shipping_rules = $order_shipping_rules[$order_shipping_rule_id];
            }
        }

        $DHL = array("DFY", "Parcelshop", "Europlus", "Europack");
        if(in_array($shipping_code[5], $DHL)) $carrier = 'DHL';
        $POSTNL = array(3085, 3086, 3087, 3089, 3091, 3189, 3385, 4940, 3533);
        if(in_array($shipping_code[5], $POSTNL)) $carrier = 'PostNl';
        $DPD = array(101,109,136,161,179,191,225,228,237,350,352);
        if(in_array($shipping_code[5], $DPD)) $carrier = 'DPD';
        $UPS = array(11,07,54,65);
        if(in_array($shipping_code[5], $UPS)) $carrier = 'UPS';
        $FADELLO = array("dc");
        if(in_array($shipping_code[5], $FADELLO)) $carrier = 'Fadello';
        $VSP = array(2928);
        if(in_array($shipping_code[5], $VSP)) $carrier = 'PostNL';
        $Intrapost = array(1,2,3,6,7,8,9);
        if(in_array($shipping_code[5], $Intrapost)) $carrier = 'Intrapost';


        $handtekening_bij_aflevering = false;
        $niet_leveren_bij_de_buren = false;
        $directe_avond_levering = false;
        $zaterdag_levering = false;
        $extrazeker = false;
        $rembours = false;
        $verzekerd_bedrag = false;

        //PostNL, Pakket + rembours
        if ($order_shipping_type == 'parcel_pro_type_id_2') {
            $rembours = $order_total;
        }

        //PostNL, Pakket + verzekerd bedrag
        if ($order_shipping_type == 'parcel_pro_type_id_3') {
            $verzekerd_bedrag = false;
        }

        //PostNL, Pakket + handtekening voor ontvangst
        if ($order_shipping_type == 'parcel_pro_type_id_4') {

        }

        //PostNL, Rembours + Verhoogd aansprakelijk
        if ($order_shipping_type == 'parcel_pro_type_id_195') {
            $rembours = $order_total;
            $verzekerd_bedrag = false;
        }

        //DHL, DFY
        if ($order_shipping_type == 'parcel_pro_type_id_DFY') {
            if (isset($order_shipping_rules['handtekening'])) {
                if ($order_shipping_rules['handtekening'] == '1') {
                    $handtekening_bij_aflevering = true;
                }
            }

            if (isset($order_shipping_rules['nietbijburen'])) {
                if ($order_shipping_rules['nietbijburen'] == '1') {
                    $niet_leveren_bij_de_buren = true;
                }
            }

            if (isset($order_shipping_rules['avond'])) {
                if ($order_shipping_rules['avond'] == '1') {
                    $directe_avond_levering = true;
                }
            }
            if (isset($order_shipping_rules['extrazeker'])) {
                if ($order_shipping_rules['extrazeker'] == '1') {
                    $extrazeker = true;
                }
            }
        }

        //DPD, Rembours
        if ($order_shipping_type == 'parcel_pro_type_id_28') {
            $rembours = $order_total;
        }

        //DPD, Verzekerd
        if ($order_shipping_type == 'parcel_pro_type_id_35') {
            $verzekerd_bedrag = '';
        }

        //DPD, Verzekerd, rembours
        if ($order_shipping_type == 'parcel_pro_type_id_36') {
            $rembours = $order_total;
            $verzekerd_bedrag = '';
        }

        //'DPD, DPD 12:00, rembours';
        if ($order_shipping_type == 'parcel_pro_type_id_41') {
            $rembours = $order_total;
        }


        //DPD, 8:30, rembours';
        if ($order_shipping_type == 'parcel_pro_type_id_43') {
            $rembours = $order_total;
        }

        return array(
            "shipping_method" => $order_shipping_type,
            "Carrier"=>$carrier,
            "handtekening_bij_aflevering" =>  $handtekening_bij_aflevering,
            "niet_leveren_bij_de_buren" =>  $niet_leveren_bij_de_buren,
            "directe_avond_levering" =>  $directe_avond_levering,
            "zaterdag_levering" =>  $zaterdag_levering,
            "extrazeker" =>  $extrazeker,
            "rembours" =>  $rembours,
            "verzekerd_bedrag" =>  $verzekerd_bedrag,
        );
    }

    public function format_order_data( $order ) {

        $date = date('Y\-m\-d G:i:s');
        $postcode_afzender = null;
        $hmacSha256 = hash_hmac("sha256", $this->config->get('parcelpro_Id') . $date . $postcode_afzender . $order['shipping_postcode'], $this->config->get('parcelpro_ApiKey'));

        // Verzendopties bepalen
        $shipping_option_data = $this->define_shipping_method($order['shipping_code']);

        $data = array_merge($order, $shipping_option_data);

        $order_shipping_type = $shipping_option_data['shipping_method'];

        $data['GebruikerId']          = $this->config->get('parcelpro_Id');
        $data['Datum']                = $date;
        $data['HmacSha256']           = $hmacSha256;
        $data['API']                  = $this->config->get('parcelpro_ApiKey');

        // Verzendgegevens
        $data['order_id']             = $order['order_id'];
        $data['payment_firstname']    = $order['payment_firstname'];
        $data['payment_lastname']     = $order['payment_lastname'];
        $data['payment_company']      = $order['payment_company'];
        $data['payment_address_1']    = isset($order['payment_address_1']) ? $order['payment_address_1'] : $order['payment_address1'];
        $data['payment_address_2']    = isset($order['payment_address_2']) ? $order['payment_address_2'] : $order['payment_address2'];
        $data['payment_postcode']     = $order['payment_postcode'];
        $data['payment_city']         = $order['payment_city'];
        $data['shipping_firstname']   = $order['shipping_firstname'];
        $data['shipping_lastname']    = $order['shipping_lastname'];

        $data['shipping_company']     = $order['shipping_company'];

        if($data['shipping_method'] == 'parcel_pro_type_id_3533' || $data['shipping_method'] == 'parcel_pro_type_id_Parcelshop'){
            $data['shipping_company'] = $order['shipping_company'];
        }

        $data['shipping_address_1']   = $order['shipping_address_1'];
        $data['shipping_address_2']   = $order['shipping_address_2'];
        $data['shipping_postcode']    = $order['shipping_postcode'];
        $data['shipping_city']        = $order['shipping_city'];
        $data['shipping_country']     = $order['shipping_country'];
        $data['shipping_iso_code_2']  = !isset($order['shipping_country_iso_2']) ? $order['shipping_iso_code_2'] : $order['shipping_country_iso_2'];
        $data['shipping_code']        = $order['shipping_code'];

        if(empty($data['shipping_address_2']) || ctype_alpha($data['shipping_address_2'])){
            preg_match("/^(\\D{1,})[\\s\\r\\n]{1,}(\\d{1,}[\\s\\S]*)$/", $data['shipping_address_1'], $matches);
            if(!empty($matches[2])){
                $data['nummer'] = $matches[2];
                $data['toevoeging'] = $data['shipping_address_2'];
            }
        }else{
            $data['nummer'] = $data['shipping_address_2'];
        }

        $data['email']                = $order['email'];
        $data['telephone']            = $order['telephone'];
        $data['date_added']           = $order['date_added'];

        $data['aantal_pakketten'] = 1;

        return $data;
    }

    public function submitShipping($data) {
        $gebruiker_id = $this->config->get('parcelpro_Id');
        $apiKey = $this->config->get('parcelpro_ApiKey');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->webhook_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            sprintf('X-Oc-Webhook-Accountid: %s', $gebruiker_id),
            sprintf('X-Oc-Webhook-Signature: %s', hash_hmac("sha256", json_encode($data), $apiKey)),
            sprintf('X-Oc-Webhook-Referer: %s', $_SERVER['HTTP_HOST']),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response) {
            $result = json_decode($response, true);
        } else {
            $result = array();
        }

        return $result;
    }

    public function saveSuData($order_id, $saving_data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET su_order_id = '" . (int) $saving_data['su_order_id'] . "', su_url_tracking = '" . $this->db->escape($saving_data['su_url_tracking']) . "', su_url_label = '" . $this->db->escape($saving_data['su_url_label']) . "', su_barcode = '" . $this->db->escape($saving_data['su_barcode']) . "', su_barcodes = '" . $this->db->escape($saving_data['su_barcodes']) . "', su_colli = '" . (int) $saving_data['su_colli'] . "', su_date_added = NOW()  WHERE order_id = '" . (int) $order_id . "'");
    }

}
