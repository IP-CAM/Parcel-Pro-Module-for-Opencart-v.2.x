<?php

//==============================================================================
// Parcel Pro Shipping v1.0.1
//
// Company: Parcel Pro
// Contact: info@parcelpro.nl
//==============================================================================

class ModelExtensionShippingParcelPro extends Model {

    function getQuote($address) {
        if (!$this->config->get('parcel_pro_status')) {
            return;
        }

        $language_id = isset($this->session->data['language']) ? $this->session->data['language'] : $this->config->get('config_language');

        $parcel_pro_heading = $this->config->get('parcel_pro_heading');
        $shipping_methode_heading = $parcel_pro_heading[$language_id];

        $sub_total = $this->cart->getSubTotal();

        $weight = $this->cart->getWeight();

        $customer_geozones = array();
        $geozones = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '0' OR zone_id = '" . (int) $address['zone_id'] . "')");
        foreach ($geozones->rows as $geozone) {
            $customer_geozones[] = $geozone['geo_zone_id'];
        }

        $quote_data = array();

        // PostNL, Standaard pakket
        if ($this->config->get('parcel_pro_type_id_3085_status') and is_array($this->config->get('parcel_pro_type_id_3085_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3085', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // PostNL, Pakket + rembours
        if ($this->config->get('parcel_pro_type_id_3086_status') and is_array($this->config->get('parcel_pro_type_id_3086_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3086', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // PostNL, Pakket + verzekerd bedrag
        if ($this->config->get('parcel_pro_type_id_3087_status') and is_array($this->config->get('parcel_pro_type_id_3087_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3087', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // PostNL, Pakket + handtekening voor ontvangst
        if ($this->config->get('parcel_pro_type_id_3089_status') and is_array($this->config->get('parcel_pro_type_id_3089_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3089', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // PostNL, Rembours + Verhoogd aansprakelijk
        if ($this->config->get('parcel_pro_type_id_3091_status') and is_array($this->config->get('parcel_pro_type_id_3091_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3091', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // PostNL, Pakket + handtekening voor ontvangst, ook bij buren
        if ($this->config->get('parcel_pro_type_id_3189_status') and is_array($this->config->get('parcel_pro_type_id_3089_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3189', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // PostNL, Alleen Huisadres
        if ($this->config->get('parcel_pro_type_id_3385_status') and is_array($this->config->get('parcel_pro_type_id_3385_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('3385', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // PostNL, Pakket buitenland
        if ($this->config->get('parcel_pro_type_id_4940_status') and is_array($this->config->get('parcel_pro_type_id_4940_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('4940', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // PostNL, Pakjegemak
        if ($this->config->get('parcel_pro_type_id_2928_status') and is_array($this->config->get('parcel_pro_type_id_2928_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('2928', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // PostNL, Brievenbuspakje
        if ($this->config->get('parcel_pro_type_id_2928_status') and is_array($this->config->get('parcel_pro_type_id_2928_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('2928', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // DHL, DFY
        if ($this->config->get('parcel_pro_type_id_DFY_status') and is_array($this->config->get('parcel_pro_type_id_DFY_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('DFY', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // DHL, EUROPACK
        if ($this->config->get('parcel_pro_type_id_Europack_status') and is_array($this->config->get('parcel_pro_type_id_Europack_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('Europack', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // DHL, EUROPLUS
        if ($this->config->get('parcel_pro_type_id_Europlus_status') and is_array($this->config->get('parcel_pro_type_id_Europlus_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('Europlus', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // DHL, PARCELSHOP
        if ($this->config->get('parcel_pro_type_id_Parcelshop_status') and is_array($this->config->get('parcel_pro_type_id_Parcelshop_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('Parcelshop', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // DPD, Normaal pakket
        if ($this->config->get('parcel_pro_type_id_101_status') and is_array($this->config->get('parcel_pro_type_id_101_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('101', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, Rembours
        if ($this->config->get('parcel_pro_type_id_109_status') and is_array($this->config->get('parcel_pro_type_id_109_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('109', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, Klein pakket
        if ($this->config->get('parcel_pro_type_id_136_status') and is_array($this->config->get('parcel_pro_type_id_136_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('136', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, Verzekerd
        if ($this->config->get('parcel_pro_type_id_161_status') and is_array($this->config->get('parcel_pro_type_id_161_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('161', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 10:00
        if ($this->config->get('parcel_pro_type_id_179_status') and is_array($this->config->get('parcel_pro_type_id_179_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('179', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 10:00, rembours
        if ($this->config->get('parcel_pro_type_id_191_status') and is_array($this->config->get('parcel_pro_type_id_191_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('191', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 12:00
        if ($this->config->get('parcel_pro_type_id_225_status') and is_array($this->config->get('parcel_pro_type_id_225_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('225', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 12:00, zaterdag
        if ($this->config->get('parcel_pro_type_id_228_status') and is_array($this->config->get('parcel_pro_type_id_228_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('228', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 12:00, rembours
        if ($this->config->get('parcel_pro_type_id_237_status') and is_array($this->config->get('parcel_pro_type_id_237_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('237', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, DPD 8:30
        if ($this->config->get('parcel_pro_type_id_350_status') and is_array($this->config->get('parcel_pro_type_id_350_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('350', $language_id, $sub_total, $weight, $customer_geozones));
        }


        // DPD, 8:30, rembours
        if ($this->config->get('parcel_pro_type_id_352_status') and is_array($this->config->get('parcel_pro_type_id_352_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('352', $language_id, $sub_total, $weight, $customer_geozones));
        }

        //UPS, standaard
        if ($this->config->get('parcel_pro_type_id_11_status') and is_array($this->config->get('parcel_pro_type_id_11_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('11', $language_id, $sub_total, $weight, $customer_geozones));
        }

        //UPS, Express
        if ($this->config->get('parcel_pro_type_id_07_status') and is_array($this->config->get('parcel_pro_type_id_07_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('07', $language_id, $sub_total, $weight, $customer_geozones));
        }

        //UPS, Express plus
        if ($this->config->get('parcel_pro_type_id_54_status') and is_array($this->config->get('parcel_pro_type_id_54_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('54', $language_id, $sub_total, $weight, $customer_geozones));
        }

        //UPS, Express Saver
        if ($this->config->get('parcel_pro_type_id_65_status') and is_array($this->config->get('parcel_pro_type_id_65_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('65', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // Fadello
        if ($this->config->get('parcel_pro_type_id_dc_status') and is_array($this->config->get('parcel_pro_type_id_dc_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('dc', $language_id, $sub_total, $weight, $customer_geozones));
        }

        // PostNL (ex VSP), Brievenbuspakje
        if ($this->config->get('parcel_pro_type_id_2928_status') and is_array($this->config->get('parcel_pro_type_id_2928_rule'))) {
            $quote_data = array_merge($quote_data, $this->getIdQuotes('2928', $language_id, $sub_total, $weight, $customer_geozones));
        }


        if (is_array($quote_data) and ! empty($quote_data)) {
            $quote_data = $this->subValSort($quote_data, 'sort_order');
        }

        $method_data = array();

        if ($quote_data) {
            $method_data = array(
                'code' => 'parcel_pro',
                'title' => $shipping_methode_heading,
                'quote' => $quote_data,
                'sort_order' => $this->config->get('parcel_pro_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }

    private function subValSort($array, $sort_key) {
        foreach ($array as $key => $value) {
            $helper[$key] = strtolower($value[$sort_key]);
        }

        asort($helper);

        foreach ($helper as $key => $value) {
            $sorted[$key] = $array[$key];
        }

        return $sorted;
    }

    private function getIdQuotes($id, $language_id, $sub_total, $weight, $customer_geozones) {
        $quote_data = array();

        foreach ($this->config->get('parcel_pro_type_id_' . $id . '_rule') as $key => $rule) {
            if ($rule['status']) {
                $rule_geozones = isset($rule['geo_zones']) ? $rule['geo_zones'] : array();
                $check_zone = $this->checkZone($rule_geozones, $customer_geozones);
                if (!$check_zone)
                    continue;

                $check_subtotal = $this->checkSubTotal($rule['total_min'], $rule['total_max'], $sub_total);
                if (!$check_subtotal)
                    continue;

                $check_weight = $this->checkWeight($rule['weight_min'], $rule['weight_max'], $weight);
                if (!$check_weight)
                    continue;

                $quote_data['parcel_pro_type_id_' . $id . '_' . $key] = array(
                    'sort_order' => $this->config->get('parcel_pro_type_id_' . $id . '_sort_order'),
                    'code' => 'parcel_pro.parcel_pro_type_id_' . $id . '_' . $key,
                    'title' => !empty($rule['name'][$language_id]) ? $rule['name'][$language_id] : $shipping_methode_heading,
                    'cost' => $this->tax->calculate($rule['cost'], $this->config->get('parcel_pro_type_id_' . $id . '_tax_class_id'), $this->config->get('config_tax')),
                    'tax_class_id' => $this->config->get('type_id_'.$id.'_tax_class_id'),
                    'text' => $this->currency->format($this->tax->calculate($rule['cost'], $this->config->get('parcel_pro_type_id_' . $id . '_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
                );
            }
        }

        return $quote_data;
    }

    private function checkZone($rule_geozones, $customer_geozones) {
        $status = false;

        foreach ($rule_geozones as $rule_geozone) {
            if (in_array($rule_geozone, $customer_geozones)) {
                $status = true;
            }
        }

        return $status;
    }

    private function checkSubTotal($total_min, $total_max, $sub_total) {
        $status = true;

        if ($total_min) {
            if ($sub_total < $total_min) {
                $status = false;
            }
        }

        if ($total_max) {
            if ($sub_total > $total_max) {
                $status = false;
            }
        }

        return $status;
    }

    private function checkWeight($weight_min, $weight_max, $weight) {
        $status = true;

        if ($weight_min) {
            if ($weight < $weight_min) {
                $status = false;
            }
        }

        if ($weight_max) {
            if ($weight > $weight_max) {
                $status = false;
            }
        }

        return $status;
    }

}

?>
