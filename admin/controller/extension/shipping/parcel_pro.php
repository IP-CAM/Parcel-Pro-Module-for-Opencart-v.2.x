<?php

//==============================================================================
// Parcel Pro Shipping v1.0.1
//
// Company: Parcel Pro
// Contact: info@parcelpro.nl
//==============================================================================

class ControllerExtensionShippingParcelPro extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/parcel_pro');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('parcel_pro', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_version'] = $this->language->get('text_version');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_select_all'] = $this->language->get('text_select_all');
        $data['text_unselect_all'] = $this->language->get('text_unselect_all');
        $data['text_min'] = $this->language->get('text_min');
        $data['text_max'] = $this->language->get('text_max');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_name'] = $this->language->get('text_name');
        $data['text_shipping_price'] = $this->language->get('text_shipping_price');
        $data['text_copyright'] = $this->language->get('text_copyright');

        $data['entry_version'] = $this->language->get('entry_version');
        $data['entry_user_id'] = $this->language->get('entry_user_id');
        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_sender_name'] = $this->language->get('entry_sender_name');
        $data['entry_sender_street'] = $this->language->get('entry_sender_street');
        $data['entry_sender_number'] = $this->language->get('entry_sender_number');
        $data['entry_sender_postcode'] = $this->language->get('entry_sender_postcode');
        $data['entry_sender_city'] = $this->language->get('entry_sender_city');
        $data['entry_sender_country'] = $this->language->get('entry_sender_country');
        $data['entry_sender_iban'] = $this->language->get('entry_sender_iban');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_auto_export_status'] = $this->language->get('entry_auto_export_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_sub_total'] = $this->language->get('entry_sub_total');
        $data['entry_weight'] = $this->language->get('entry_weight');
        $data['entry_shipping_heading'] = $this->language->get('entry_shipping_heading');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $data['entry_handtekening'] = $this->language->get('entry_handtekening');
        $data['entry_avond'] = $this->language->get('entry_avond');
        $data['entry_extrazeker'] = $this->language->get('entry_extrazeker');
        $data['entry_nietbijburen'] = $this->language->get('entry_nietbijburen');

        $data['button_add_rule'] = $this->language->get('button_add_rule');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_type_id_3085'] = $this->language->get('tab_type_id_3085');
        $data['tab_type_id_3086'] = $this->language->get('tab_type_id_3086');
        $data['tab_type_id_3087'] = $this->language->get('tab_type_id_3087');
        $data['tab_type_id_3089'] = $this->language->get('tab_type_id_3089');
        $data['tab_type_id_3091'] = $this->language->get('tab_type_id_3091');
        $data['tab_type_id_3189'] = $this->language->get('tab_type_id_3189');
        $data['tab_type_id_3385'] = $this->language->get('tab_type_id_3385');
        $data['tab_type_id_4940'] = $this->language->get('tab_type_id_4940');
        $data['tab_type_id_3533'] = $this->language->get('tab_type_id_3533');
        $data['tab_type_id_DFY'] = $this->language->get('tab_type_id_DFY');
        $data['tab_type_id_Europack'] = $this->language->get('tab_type_id_Europack');
        $data['tab_type_id_Europlus'] = $this->language->get('tab_type_id_Europlus');
        $data['tab_type_id_Parcelshop'] = $this->language->get('tab_type_id_Parcelshop');
        $data['tab_type_id_101'] = $this->language->get('tab_type_id_101'); // DPD Normaal pakket
        $data['tab_type_id_109'] = $this->language->get('tab_type_id_109'); // DPD Rembours
        $data['tab_type_id_136'] = $this->language->get('tab_type_id_136'); // DPD Klein pakket
        //$data['tab_type_id_155'] = $this->language->get('tab_type_id_155');
        $data['tab_type_id_161'] = $this->language->get('tab_type_id_161'); // DPD verzekerd
        $data['tab_type_id_179'] = $this->language->get('tab_type_id_179');
        $data['tab_type_id_191'] = $this->language->get('tab_type_id_191');
        $data['tab_type_id_225'] = $this->language->get('tab_type_id_225');
        $data['tab_type_id_228'] = $this->language->get('tab_type_id_228');
        $data['tab_type_id_237'] = $this->language->get('tab_type_id_237');
        $data['tab_type_id_350'] = $this->language->get('tab_type_id_350');
        $data['tab_type_id_352'] = $this->language->get('tab_type_id_352');
        $data['tab_type_id_11'] = $this->language->get('tab_type_id_11');
        $data['tab_type_id_07'] = $this->language->get('tab_type_id_07');
        $data['tab_type_id_54'] = $this->language->get('tab_type_id_54');
        $data['tab_type_id_65'] = $this->language->get('tab_type_id_65');
        $data['tab_type_id_dc'] = $this->language->get('tab_type_id_dc');
        $data['tab_type_id_2928'] = $this->language->get('tab_type_id_2928');

        $data['column_general'] = $this->language->get('column_general');
        $data['column_geo_zone'] = $this->language->get('column_geo_zone');
        $data['column_cart_value'] = $this->language->get('column_cart_value');
        $data['column_options'] = $this->language->get('column_options');
        $data['column_pricing'] = $this->language->get('column_pricing');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // Load Order Statuses
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/parcel_pro', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/shipping/parcel_pro', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        // General
        if (isset($this->request->post['parcel_pro_status'])) {
            $data['parcel_pro_status'] = $this->request->post['parcel_pro_status'];
        } else {
            $data['parcel_pro_status'] = $this->config->get('parcel_pro_status');
        }

        if (isset($this->request->post['parcel_pro_auto_export_status'])) {
            $data['parcel_pro_auto_export_status'] = $this->request->post['parcel_pro_auto_export_status'];
        } else {
            $data['parcel_pro_auto_export_status'] = $this->config->get('parcel_pro_auto_export_status');
        }

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $language) {
            if (isset($this->request->post['parcel_pro_heading'][$language['code']])) {
                $data['parcel_pro_heading'][$language['code']] = $this->request->post['parcel_pro_heading_'.$language['code']];
            } else {
                $data['parcel_pro_heading'][$language['code']] = $this->config->get('parcel_pro_heading')[$language['code']];
            }
        }

        if (isset($this->request->post['parcel_pro_sort_order'])) {
            $data['parcel_pro_sort_order'] = $this->request->post['parcel_pro_sort_order'];
        } else {
            $data['parcel_pro_sort_order'] = $this->config->get('parcel_pro_sort_order');
        }


        $options = array();
        array_push($options, "3085"); // PostNL, Standaard pakket
        array_push($options, "3086"); // PostNL, Pakket + rembours
        array_push($options, "3087"); // PostNL, Pakket + verzekerd bedrag
        array_push($options, "3089"); // PostNL, Pakket + handtekening voor ontvangst
        array_push($options, "3091"); // PostNL, Rembours + Verhoogd aansprakelijk
        array_push($options, "3189"); // PostNL, Pakket + handtekening voor ontvangst, ook bij buren
        array_push($options, "3385"); // PostNL, Alleen huisadres
        array_push($options,"4940");// PostNL, Pakket buitenland
        array_push($options,"3533");//PostNL, Pakjegemak
        array_push($options,"DFY");//DHL, DFY
        array_push($options,"Europlus");//DHL, EUROPLUS
        array_push($options,"Europack");//DHL, EUROPACK
        array_push($options,"Parcelshop");//DHL, Parcelshop
        array_push($options,"101");//DPD, Normaal pakket
        array_push($options,"109");//DPD, Rembours
        array_push($options,"136");//DPD, Klein pakket
        array_push($options,"161");//DPD, Verzekerd, rembours
        array_push($options,"179");//DPD, DPD 10:00
        array_push($options,"191");//DPD, DPD 10:00, rembours
        array_push($options,"225");//DPD, DPD 12:00
        array_push($options,"228");//DPD, DPD 12:00, zaterdag
        array_push($options,"237");//DPD, DPD 12:00, rembours
        array_push($options,"350");//DPD, DPD 8:30
        array_push($options,"352");//DPD, 8:30, rembours
        array_push($options,"11");//UPS, standaard
        array_push($options,"07");//UPS, Express
        array_push($options,"54");//UPS, Express Plus
        array_push($options,"65");//UPS, Express Saver
        array_push($options,"dc");//Fadello
        array_push($options,"2928");//PostNL (ex VSP), Brievenbuspakje

        for ($i = 0; $i < count($options); $i++) {

            if (isset($this->request->post['parcel_pro_type_id_'.$options[$i].'_status'])) {
                $data['parcel_pro_type_id_'.$options[$i].'_status'] = $this->request->post['parcel_pro_type_id_'.$options[$i].'_status'];
            } else {
                $data['parcel_pro_type_id_'.$options[$i].'_status'] = $this->config->get('parcel_pro_type_id_'.$options[$i].'_status');
            }

            if (isset($this->request->post['parcel_pro_type_id_'.$options[$i].'_tax_class_id'])) {
                $data['parcel_pro_type_id_'.$options[$i].'_tax_class_id'] = $this->request->post['parcel_pro_type_id_'.$options[$i].'_tax_class_id'];
            } else {
                $data['parcel_pro_type_id_'.$options[$i].'_tax_class_id'] = $this->config->get('parcel_pro_type_id_'.$options[$i].'_tax_class_id');
            }

            if (isset($this->request->post['parcel_pro_type_id_'.$options[$i].'_sort_order'])) {
                $data['parcel_pro_type_id_'.$options[$i].'_sort_order'] = $this->request->post['parcel_pro_type_id_'.$options[$i].'_sort_order'];
            } else {
                $data['parcel_pro_type_id_'.$options[$i].'_sort_order'] = $this->config->get('parcel_pro_type_id_'.$options[$i].'_sort_order');
            }

            $rules = ($this->config->get('parcel_pro_type_id_'.$options[$i].'_rule') ? $this->config->get('parcel_pro_type_id_'.$options[$i].'_rule') : array());
            $row_count = 0;
            $rows = '';
            foreach ($rules as $rule) {
                if($options[$i] === 'DFY' || $options[$i] === 'Europlus' || $options[$i] === 'Parcelshop'){
                    $rows .= $this->addRule_2($options[$i], $rule, $row_count);
                }else{
                    $rows .= $this->addRule_1($options[$i], $rule, $row_count);
                }
                $row_count++;
            }

            $data['rows_type_id_'.$options[$i].''] = $rows;
            $data['count_type_id_'.$options[$i].''] = $row_count;
        }

        $this->load->model('localisation/tax_class');
        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['text_edit'] = $this->language->get('text_edit');

        $this->response->setOutput($this->load->view('extension/shipping/parcel_pro.tpl', $data));
    }

    public function addRule_1($type_id, $rule = array(), $rule_counter = 0) {
        $this->language->load('shipping/parcel_pro');

        $this->load->model('localisation/tax_class');
        $tax_classes = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $geo_zones = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        $result = '<tbody id="parcel_pro_type_id_' . $type_id . '_rule' . $rule_counter . '">';
        $result .= '  <tr>';
        $result .= '    <td class="text-center">';
        $result .= '      <div><strong>' . $this->language->get('text_name') . '</strong></div>';
        foreach ($languages as $language) {
            $result .= '      <img src="language/' . $language['code'] . '/' . $language['code'] . '.png" title="' . $language['name'] . '" /> <input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][name][' . $language['code'] . ']" value="' . $rule['name'][$language['code']] . '" size="25" class="form-control" style="width: 25%; padding:5px; display: inline-block; height: 30px;" /><br />';
        }
        $result .= '      <div class="spacer_1"><strong>' . $this->language->get('text_status') . '</strong></div>';
        $result .= '      <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][status]">';
        if ($rule['status'] == '1') {
            $result .= '        <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '        <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '        <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '        <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '      </select>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <div class="well well-sm" style="height: 100px; overflow: auto;">';
        if (!isset($rule['geo_zones'])) {
            $rule['geo_zones'] = array();
        }
        $class = 'even';
        foreach ($geo_zones as $geo_zone) {
            $class = ($class == 'even' ? 'odd' : 'even');
            $result .= '        <div class="checkbox ' . $class . '" style="padding: 0; min-height: auto;">';
            $result .= '<label>';
            if (in_array($geo_zone['geo_zone_id'], $rule['geo_zones'])) {
                $result .= '          <input type="checkbox" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][geo_zones][]" value="' . $geo_zone['geo_zone_id'] . '" checked="checked" />';
            } else {
                $result .= '          <input type="checkbox" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][geo_zones][]" value="' . $geo_zone['geo_zone_id'] . '" />';
            }
            $result .= '</label>';
            $result .= str_replace("'", "&#39;", $geo_zone['name']);
            $result .= '        </div>';
        }
        $result .= '      </div>';
        $result .= '      <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Select All</a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Unselect All</a>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <table style="margin: 0 auto;">';
        $result .= '        <thead>';
        $result .= '          <tr>';
        $result .= '            <td class="left">&nbsp;</td>';
        $result .= '            <td class="center">' . $this->language->get('text_min') . '</td>';
        $result .= '            <td class="center">' . $this->language->get('text_max') . '</td>';
        $result .= '          </tr>';
        $result .= '        </thead>';
        $result .= '        <tbody>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_sub_total') . '</td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][total_min]" value="' . $rule['total_min'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][total_max]" value="' . $rule['total_max'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '          </tr>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_weight') . '</td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][weight_min]" value="' . $rule['weight_min'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][weight_max]" value="' . $rule['weight_max'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '          <tr>';
        $result .= '        </tbody>';
        $result .= '      </table>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <div><strong>' . $this->language->get('text_shipping_price') . '</strong></div>';
        $result .= '      <div><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][cost]" value="' . $rule['cost'] . '" size="5" class="form-control" style="width: 50%; padding:5px; display: inline-block; height: 30px;" /></div>';
        $result .= '    </td>';
        $result .= '    <td class="left"><a onclick="$(\'#parcel_pro_type_id_' . $type_id . '_rule' . $rule_counter . '\').remove();" class="btn btn-primary">' . $this->language->get('button_remove') . '</a></td>';
        $result .= '  </tr>';
        $result .= '</tbody>';

        return $result;
    }

    public function addRule_2($type_id, $rule = array(), $rule_counter = 0) {
        $this->language->load('shipping/parcel_pro');

        $this->load->model('localisation/tax_class');
        $tax_classes = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $geo_zones = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        $result = '<tbody id="parcel_pro_type_id_' . $type_id . '_rule' . $rule_counter . '">';
        $result .= '  <tr>';
        $result .= '    <td class="text-center">';
        $result .= '      <div><strong>' . $this->language->get('text_name') . '</strong></div>';
        foreach ($languages as $language) {
            $result .= '      <img src="language/' . $language['code'] . '/' . $language['code'] . '.png" /> <input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][name][' . $language['code'] . ']" value="' . $rule['name'][$language['code']] . '" size="25" class="form-control" style="width: 40%; padding:5px; display: inline-block; height: 30px;"/><br />';
        }
        $result .= '      <div class="spacer_1"><strong>' . $this->language->get('text_status') . '</strong></div>';
        $result .= '      <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][status]">';
        if ($rule['status'] == '1') {
            $result .= '        <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '        <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '        <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '        <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '      </select>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <div class="well well-sm" style="height: 100px; overflow: auto;">';
        if (!isset($rule['geo_zones'])) {
            $rule['geo_zones'] = array();
        }
        $class = 'even';
        foreach ($geo_zones as $geo_zone) {
            $class = ($class == 'even' ? 'odd' : 'even');
            $result .= '        <div class="checkbox ' . $class . '" style="padding: 0; min-height: auto;">';
            $result .= '<label>';
            if (in_array($geo_zone['geo_zone_id'], $rule['geo_zones'])) {
                $result .= '          <input type="checkbox" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][geo_zones][]" value="' . $geo_zone['geo_zone_id'] . '" checked="checked" />';
            } else {
                $result .= '          <input type="checkbox" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][geo_zones][]" value="' . $geo_zone['geo_zone_id'] . '" />';
            }
            $result .= '</label>';
            $result .= str_replace("'", "&#39;", $geo_zone['name']);
            $result .= '        </div>';
        }
        $result .= '      </div>';
        $result .= '      <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Select All</a> / <a onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Unselect All</a>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <table style="margin: 0 auto;">';
        $result .= '        <thead>';
        $result .= '          <tr>';
        $result .= '            <td class="left">&nbsp;</td>';
        $result .= '            <td class="center">' . $this->language->get('text_min') . '</td>';
        $result .= '            <td class="center">' . $this->language->get('text_max') . '</td>';
        $result .= '          </tr>';
        $result .= '        </thead>';
        $result .= '        <tbody>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_sub_total') . '</td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][total_min]" value="' . $rule['total_min'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][total_max]" value="' . $rule['total_max'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '          </tr>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_weight') . '</td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][weight_min]" value="' . $rule['weight_min'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '            <td class="center"><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][weight_max]" value="' . $rule['weight_max'] . '" size="5" class="form-control" style="width: 75%; padding:5px; display: inline-block; height: 30px;" /></td>';
        $result .= '          <tr>';
        $result .= '        </tbody>';
        $result .= '      </table>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <table style="margin: 0 auto;">';
        $result .= '        <tbody>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_handtekening') . '</td>';
        $result .= '            <td class="center">';
        $result .= '              <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][handtekening]">';
        if ($rule['handtekening'] == '1') {
            $result .= '                <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '                <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '              </select>';
        $result .= '            </td>';
        $result .= '          </tr>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_avond') . '</td>';
        $result .= '            <td class="center">';
        $result .= '              <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][avond]">';
        if ($rule['avond'] == '1') {
            $result .= '                <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '                <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '              </select>';
        $result .= '            </td>';
        $result .= '          </tr>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_extrazeker') . '</td>';
        $result .= '            <td class="center">';
        $result .= '              <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][extrazeker]">';
        if ($rule['extrazeker'] == '1') {
            $result .= '                <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '                <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '              </select>';
        $result .= '            </td>';
        $result .= '          </tr>';
        $result .= '          <tr>';
        $result .= '            <td class="left">' . $this->language->get('entry_nietbijburen') . '</td>';
        $result .= '            <td class="center">';
        $result .= '              <select name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][nietbijburen]">';
        if ($rule['nietbijburen'] == '1') {
            $result .= '                <option value="1" selected="selected">' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0">' . $this->language->get('text_disabled') . '</option>';
        } else {
            $result .= '                <option value="1" >' . $this->language->get('text_enabled') . '</option>';
            $result .= '                <option value="0" selected="selected">' . $this->language->get('text_disabled') . '</option>';
        }
        $result .= '              </select>';
        $result .= '            </td>';
        $result .= '          </tr>';
        $result .= '        </tbody>';
        $result .= '      </table>';
        $result .= '    </td>';
        $result .= '    <td class="center">';
        $result .= '      <div><strong>' . $this->language->get('text_shipping_price') . '</strong></div>';
        $result .= '      <div><input type="text" name="parcel_pro_type_id_' . $type_id . '_rule[' . $rule_counter . '][cost]" value="' . $rule['cost'] . '" size="5" class="form-control" style="width: 50%; padding:5px; display: inline-block; height: 30px;" /></div>';
        $result .= '    </td>';
        $result .= '    <td class="left"><a onclick="$(\'#parcel_pro_type_id_' . $type_id . '_rule' . $rule_counter . '\').remove();" class="button">' . $this->language->get('button_remove') . '</a></td>';
        $result .= '  </tr>';
        $result .= '</tbody>';

        return $result;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/parcel_pro')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>
