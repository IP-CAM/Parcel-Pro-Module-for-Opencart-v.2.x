<?php

class ControllerExtensionModuleparcelpro extends Controller{
    private $error = array();

    public function install() {
        $this->checkdb();
        $event = $this->load->model("extension/event");
        $this->model_extension_event->addEvent("parcelpro", "catalog/model/checkout/order/addOrderHistory/after", "extension/module/parcelpro/post_order_add");
    }

    public function uninstall() {
        $event = $this->load->model("extension/event");
        $this->model_extension_event->deleteEvent("parcelpro");
    }

    public function index() {
        $this->checkdb();
        $this->language->load('extension/module/parcelpro');

        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $this->model_setting_setting->editSetting('parcelpro', $this->request->post);

                $this->session->data['success'] = $this->language->get('text_success');

                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['entry_Id'] = $this->language->get('entry_Id');
        $data['entry_ApiKey'] = $this->language->get('entry_ApiKey');
        $data['entry_Webhook'] = $this->language->get('entry_Webhook');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_module_add'] = $this->language->get('button_module_add');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/parcelpro', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('extension/module/parcelpro', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['parcelpro_Id'])) {
                $data['parcelpro_Id'] = $this->request->post['parcelpro_Id'];
        } else {
                $data['parcelpro_Id'] = $this->config->get('parcelpro_Id');
        }

        if (isset($this->request->post['parcelpro_ApiKey'])) {
                $data['parcelpro_ApiKey'] = $this->request->post['parcelpro_ApiKey'];
        } else {
                $data['parcelpro_ApiKey'] = $this->config->get('parcelpro_ApiKey');
        }

        if (isset($this->request->post['parcelpro_Webhook'])) {
                $data['parcelpro_Webhook'] = $this->request->post['parcelpro_Webhook'];
        } else {
                if (!($data['parcelpro_Webhook'] = $this->config->get('parcelpro_Webhook'))) {
                    $data['parcelpro_Webhook'] = "https://login.parcelpro.nl/api/opencart/order-created.php";
                }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/parcelpro.tpl', $data));
      }

      private function checkdb() {
        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_date_added`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column datetime NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_weight`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column varchar(16) NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_colli`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column int(11) NOT NULL DEFAULT '1' after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_barcodes`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column text NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_barcode`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column varchar(128) NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_url_label`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column varchar(255) NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_label_printed`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column varchar(255) NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_url_tracking`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column  varchar(255) NOT NULL after `date_modified`";

          $this->db->query($sql);
        }

        $table = '`' . DB_PREFIX . 'order`';
        $column = '`su_order_id`';
        $sql = "DESC $table $column";

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
          $sql = "alter table $table add column $column int(11) NULL after `date_modified`";

          $this->db->query($sql);
        }
      }
}
