<?php

class mailchimp
{

    public $auth;
    public $url;
    public $exp_apikey;

    public $response;

    public function __construct($apikey)
    {
        $this->exp_apikey = explode('-', $apikey);
        $this->auth = array('Authorization: apikey ' . $this->exp_apikey[0] . '-' . $this->exp_apikey[1]);
        $this->url = "Https://" . $this->exp_apikey[1] . ".api.mailchimp.com/3.0";
        return $this->auth;
        return $this->url;

    }
    
    // MAIN CALLS
    // GET ----------------------------------------------------------------------------------------------------------------------------------------

    public function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, false);
    }

    // POST ----------------------------------------------------------------------------------------------------------------------------------------

    public function post($url, $payload)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, false);
    }

    // PATCH ----------------------------------------------------------------------------------------------------------------------------------------

    public function patch($url, $payload)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, false);
    }

    // DELETE ----------------------------------------------------------------------------------------------------------------------------------------

    public function delete($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, false);
    }

    // PUT ----------------------------------------------------------------------------------------------------------------------------------------

    public function put($url, $payload)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, false);
    }

    // ACCOUNT --------------------------------------------------------------------------------------------------------------------------------------

    public function GET_root()
    {
        $url = $this->url . "/";
        $response = $this->get($url);

        return $response;
    }

    // AUTHORIZED APPS RESOURCES --------------------------------------------------------------------------------------------------------------------

    public function GET_authorized_apps_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/authorized-apps/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_authorized_apps_instance($appid)
    {
        $url = $this->url . '/authorized-apps/' . $appid;
        $response = $this->get($url);

        return $response;
    }

    public function POST_authorized_apps_collection($client_id, $client_sec)
    {
        $params = array(
            'client_id' => $client_id,
            'client_secret' => $client_sec
        );

        $payload = json_encode($params);
        $url = $this->url . '/authorized-apps/';

        $response = $this->post($url, $payload);

        return $response;
    }

    // AUTOMATIONS RESOURCES ------------------------------------------------------------------------------------------------------------------------

    public function GET_automations_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/automations/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_automations_emails_collection($workflowid, $offset = 0, $count = 10)
    {

        $url = $this->url . '/automations/' . $workflowid . '/emails/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_automations_emails_instance($workflowid, $emailid)
    {
        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid;
        $response = $this->get($url);

        return $response;
    }

    // Calling this function will pause an email in an automation workflow
    public function POST_pause_automated_email($workflowid, $emailid)
    {
        $params = array();

        $payload = json_encode($params);
        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid . '/actions/pause';

        $response = $this->post($url, $payload);

        return $response;
    }

    // Calling this function will unpause an email in an automation workflow
    public function POST_start_automated_email($workflowid, $emailid)
    {
        $params = array();

        $payload = json_encode($params);
        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid . '/actions/start';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_automations_emails_queue_collection($workflowid, $emailid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid . '/queue/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_automations_emails_queue_collection($workflowid, $emailid, $emailaddress)
    {
        $params = array(
            'email_address' => $emailaddress
        );

        $payload = json_encode($params);
        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid . '/queue/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_automations_emails_queue_instance($workflowid, $emailid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/automations/' . $workflowid . '/emails/' . $emailid . '/queue/' . $member_id;
        $response = $this->get($url);

        return $response;
    }

    public function GET_automations_instance($workflowid)
    {
        $url = $this->url . '/automations/' . $workflowid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_automations_workflow_removed_subscribers($workflowid)
    {
        $url = $this->url . '/automations/' . $workflowid . '/removed-subscribers/';
        $response = $this->get($url);

        return $response;
    }

    public function POST_automations_workflow_removed_subscribers($workflowid, $emailaddress)
    {
        $params = array('email_address' => $emailaddress);

        $payload = json_encode($params);
        $url = $this->url . '/automations/' . $workflowid . '/removed-subscribers/';

        $response = $this->post($url, $payload);

        return $response;
    }

    // BATCH OPERATIONS RESOURCES ---------------------------------------------------------------------------------------------------------------------

    public function POST_batches_collection($operations = array())
    {

        $params = array('operations' => $operations);

        $payload = json_encode($params);
        $url = $this->url . '/batches/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_batches_collection()
    {
        $url = $this->url . '/batches/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_batches_instance($batchid)
    {
        $url = $this->url . '/batches/' . $batchid;
        $response = $this->get($url);

        return $response;
    }


    // CAMPAIGNS FOLDERS RESOURCES --------------------------------------------------------------------------------------------------------------------

    public function POST_camapigns_folders_collection($foldername)
    {

        $params = array('name' => $foldername);

        $payload = json_encode($params);
        $url = $this->url . 'campaign-folders';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_campaigns_folders_collection()
    {
        $url = $this->url . '/camapigns-folders/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_campaigns_folders_instance($folderid)
    {
        $url = $this->url . '/camapigns-folders/' . $folderid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_campaigns_folders_instance($folderid, $foldername)
    {
        $params = array('name' => $foldername);

        $payload = json_encode($params);
        $url = $this->url . '/camapigns-folders/' . $folderid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_campaigns_folders_instance($folderid)
    {
        $url = $this->url . '/camapigns-folders/' . $folderid;
        $response = $this->delete($url);

        return $response;
    }

    // CAMPAIGNS RESOURCES ----------------------------------------------------------------------------------------------------------------------------

    public function GET_campaigns_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/campaigns/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_campaigns_collection($type, $settings = array(), $optional_parameters = array())
    {

        $params = array('type' => $type, 'settings' => $settings);
        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/campaigns/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_campaigns_feedback_collection($campaignid)
    {
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/';
        $response = $this->get($url);

        return $response;
    }

    // $message is the string you would like to pass as a comment to a campaign
    public function POST_campaigns_feedback_collection($campaignid, $message)
    {
        $feedback = array('message' => $message);

        $payload = json_encode($feedback);
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_campaigns_feedback_instance($campaignid, $feedbackid)
    {
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/' . $feedbackid;
        $response = $this->get($url);

        return $response;
    }

    // $message is the string you would like to pass as a campaign comment
    public function PATCH_campaigns_feedback_instance($campaignid, $feedbackid, $message)
    {
        $newmessage = array('message' => $message);

        $payload = json_encode($newmessage);
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/' . $feedbackid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    // DELETE functionality for this endpoint not yet available as of 07-04-2015
    public function DELETE_campaigns_feedback_instance($campaignid, $feedbackid)
    {
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/' . $feedbackid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_campaigns_instance($campaignid)
    {
        $url = $this->url . '/campaigns/' . $campaignid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_campaigns_instance($campaignid, $type, $settings = array(), $optional_parameters = array())
    {

        $params = array('type' => $type, 'settings' => $settings);
        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/campaigns/' . $campaignid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_campaigns_instance($campaignid)
    {
        $url = $this->url . '/campaigns/' . $campaignid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_campaign_send($campaignid)
    {
        $payload = array();
        $url = $this->url . '/campaigns/' . $campaignid . '/feedback/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function POST_campaign_cancel_send($campaignid)
    {
        $payload = array();
        $url = $this->url . '/campaigns/' . $campaignid . '/actions/cancel-send/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_campaign_content($campaignid)
    {
        $url = $this->url . '/campaigns/' . $campaignid . '/content/';
        $response = $this->get($url);

        return $response;
    }

    public function PUT_campaign_content($campaignid, $params)
    {
        $payload = json_encode($params);
        $url = $this->url . '/campaigns/' . $campaignid . '/content/';

        $response = $this->put($url, $payload);

        return $response;
    }

    public function GET_send_checklist($campaignid)
    {
        $url = $this->url . '/campaigns/' . $campaignid . '/send-checklist/';
        $response = $this->get($url);

        return $response;
    }

    public function POST_campaign_pause($campaignid)
    {
        $payload = array();
        $url = $this->url . '/campaigns/' . $campaignid . '/actions/pause';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function POST_campaigns_resume($campaignid)
    {
        $payload = array();
        $url = $this->url . '/campaigns/' . $campaignid . '/actions/resume';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function POST_campaigns_replicate($campaignid)
    {
        $payload = array();
        $url = $this->url . '/campaigns/' . $campaignid . '/actions/replicate';

        $response = $this->post($url, $payload);

        return $response;
    }


    // CONVERSATIONS RESOURCES ----------------------------------------------------------------------------------------------------------------------

    public function GET_conversations_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/conversations/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_conversations_instance($conversationid)
    {
        $url = $this->url . '/conversations/' . $conversationid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_conversations_messages_collection($conversationid)
    {
        $url = $this->url . '/conversations/' . $conversationid . '/messages/';
        $response = $this->get($url);

        return $response;
    }

    // This function creates a new entry in an existing conversation
    // $read must be passed as a boolean.
    public function POST_conversations_messages_collection($conversationid, $fromemail, $read, $subject, $message)
    {
        $conversation = array('from_email' => $fromemail, 'read' => $read, 'subject' => $subject, 'message' => $message);

        $payload = json_encode($conversation);
        $url = $this->url . '/conversations/' . $conversationid . '/messages/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_conversations_messages_instance($conversationid, $messageid)
    {
        $url = $this->url . '/campaigns/' . $conversationid . '/messages/' . $messageid;
        $response = $this->get($url);

        return $response;
    }

    // ECOMMERCE ENDPOINTS -----------------------------------------------------------------------------------------------------------------

    public function GET_ecommerce_stores_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_stores_instance($storeid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid;
        $response = $this->get($url);

        return $response;
    }

    public function POST_ecommerce_stores_collection($storeid, $listid, $name, $currencycode, $optional_parameters = array())
    {

        $required_params = array('id' => $storeid,
            'list_id' => $listid,
            'name' => $name,
            'currency_code' => $currencycode
        );

        $params = array_merge($required_params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function PATCH_ecommerce_stores_instance($storeid, $update_params = array())
    {

        $params = $update_params;

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_ecommerce_stores_instance($storeid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_carts_collection($storeid, $cartid, $customer = array(), $currency_code, $order_total, $lines, $optional_parameters = array())
    {
        $params = array("id" => $cartid,
            "customer" => $customer,
            "currency_code" => $currency_code,
            "order_total" => $order_total,
            "lines" => $lines);

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/carts/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_carts_collection($storeid, $offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/ecommerce/stores/' . $storeid . '/carts/?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_carts_instance($storeid, $cartid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/carts/' . $cartid;
        $response = $this->get($url);

        return $response;
    }

    public function DELETE_ecommerce_carts_instance($storeid, $cartid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/carts/' . $cartid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_customers_collection($storeid, $customerid, $customer_email, $opt_in_status, $optional_parameters = array())
    {
        $params = array("id" => $customerid,
            "emaail_address" => $customer_email,
            "opt_in_status" => $opt_in_status
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_customers_collection($storeid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_customers_instance($storeid, $customerid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/' . $customerid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_ecommerce_customer_instance($storeid, $customerid, $patch_parameters = array())
    {
        $payload = json_encode($patch_parameters);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/' . $customerid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function PUT_ecommerce_customer_instance($storeid, $customerid, $customer_email, $opt_in_status, $optional_parameters = array())
    {
        $params = array("id" => $customerid,
            "email_address" => $customer_email,
            "opt_in_status" => $opt_in_status
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/' . $customerid;

        $response = $this->put($url, $payload);

        return $response;
    }

    public function DELETE_ecommerce_customer_instance($storeid, $customerid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/customers/' . $customerid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_orders_collection($storeid, $orderid, $customer = array(), $currency_code, $order_total, $lines, $optional_parameters = array())
    {
        $params = array("id" => $orderid,
            "customer" => $customer,
            "currency_code" => $currency_code,
            "order_total" => $order_total,
            "lines" => $lines
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_orders_collection($storeid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_order_instance($storeid, $orderid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_ecommerce_order_instance($storeid, $orderid, $patch_parameters = array())
    {
        $payload = json_encode($patch_parameters);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_ecommerce_order_instance($storeid, $orderid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_order_lines_collection($storeid, $orderid, $lineid, $productid, $product_varientid, $quantity, $price)
    {
        $params = array("id" => $lineid,
            "product_id" => $productid,
            "product_variant_id" => $product_varientid,
            "quantity" => $quantity,
            "price" => $price
        );

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid . '/lines/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_order_lines_collection($storeid, $orderid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid . '/lines/?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_order_lines_instance($storeid, $orderid, $lineid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid . '/lines/' . $lineid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_ecommerce_order_line_instance($storeid, $orderid, $lineid, $patch_parameters = array())
    {
        $payload = json_encode($patch_parameters);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid . '/lines/' . $lineid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_ecommerce_order_line_instance($storeid, $orderid, $lineid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/orders/' . $orderid . '/lines/' . $lineid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_products_collection($storeid, $productid, $title, $variants = array(), $optional_parameters = array())
    {
        $params = array("id" => $productid,
            "title" => $title,
            "variants" => $variants
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_products_collection($storeid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_products_instance($storeid, $productid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid;
        $response = $this->get($url);

        return $response;
    }

    public function DELETE_ecommerce_products_instance($storeid, $productid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_ecommerce_product_variants_collection($storeid, $productid, $variantid, $title, $optional_parameters = array())
    {
        $params = array("id" => $variantid,
            "title" => $title
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_ecommerce_product_variants_collection($storeid, $productid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_ecommerce_product_variants_instance($storeid, $productid, $variantid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/' . $variantid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_ecommerce_product_variant_instance($storeid, $productid, $variantid, $patch_parameters = array())
    {
        $payload = json_encode($patch_parameters);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/' . $variantid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function PUT_ecommerce_product_variant_instance($storeid, $productid, $variantid, $variantid_unknown, $title, $optional_parameters = array())
    {
        $params = array("id" => $variantid,
            "title" => $title
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/' . $variantid;

        $response = $this->put($url, $payload);

        return $response;
    }

    public function DELETE_ecommerce_product_variant_instance($storeid, $productid, $variantid)
    {
        $url = $this->url . '/ecommerce/stores/' . $storeid . '/products/' . $productid . '/variants/' . $variantid;
        $response = $this->delete($url);

        return $response;
    }

    // FILE MANAGER RESOURCES --------------------------------------------------------------------------------------------------------------

    public function GET_file_manager_files_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/file-manager/files/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    // $fileurl IS THE URL THE FILE YOU WOULD LIKE TO UPLOAD TO THE FILE MANAGER CAN BE FOUND AT
    // $name DOES NOT REQUIRE THE FILE EXTENSION AS THIS WILL BE PULLED FROM $fileurl
    // NOTE THAT NOT ALL TYPES OF FILES ARE ACCPETABLE FOR UPLOAD SEE URL BELOW FOR DETAILS
    // http://kb.mailchimp.com/campaigns/images-videos-files/host-files-in-mailchimp

    public function POST_file_manager_files_collection($name, $fileurl)
    {
        $file = file_get_contents($fileurl);
        $ext = pathinfo($fileurl, PATHINFO_EXTENSION);
        $data = base64_encode($file);

        $params = array('name' => $name . '.' . $ext, 'file_data' => $data);

        $payload = json_encode($params);
        $url = $this->url . '/file-manager/files/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_file_manager_files_instance($fileid)
    {
        $url = $this->url . '/file-manager/files/' . $fileid;
        $response = $this->get($url);

        return $response;
    }

    // CURRENTLY YOU CAN ONLY UPDATE WHAT FOLDER A FILE IS LOCATED IN
    public function PATCH_file_manager_files_instance($fileid, $folderid)
    {
        $params = array('folder_id' => $folderid);

        $payload = json_encode($params);
        $url = $this->url . '/file-manager/files/' . $fileid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_file_manager_files_instance($fileid)
    {
        $url = $this->url . '/file-manager/files/' . $fileid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_file_manager_folders_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/file-manager/folders/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_file_manager_folders_instance($folderid)
    {
        $url = $this->url . '/file-manager/folders/' . $folderid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_file_manager_folders_instance($folderid, $name)
    {
        $params = array('name' => $name);

        $payload = json_encode($params);
        $url = $this->url . '/file-manager/folders/' . $folderid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_file_manager_folders_instance($folderid)
    {
        $url = $this->url . '/file-manager/folders/' . $folderid;
        $response = $this->delete($url);

        return $response;
    }

    public function POST_file_manager_folders_collection($folderid, $name)
    {
        $params = array('name' => $name);
        $payload = json_encode($params);
        $url = $this->url . '/file-manager/folders/';

        $response = $this->post($url, $payload);

        return $response;
    }


    // LISTS RESOURCES -----------------------------------------------------------------------------------------------------------------------

    public function GET_list_abuse_collection($listid)
    {
        $url = $this->url . '/lists/' . $listid . '/abuse-reports/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_list_abuse_instance($listid, $reportid)
    {
        $url = $this->url . '/lists/' . $listid . '/abuse-reports/' . $reportid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_lists_activity_collection($listid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/activity/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_lists_clients_collection($listid)
    {
        $url = $this->url . '/lists/' . $listid . '/clients/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_lists_collection($offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_lists_collection($name,
                                          $reminder,
                                          $emailtype, #bool
                                          $company,
                                          $address_street,
                                          $address_street2,
                                          $address_city,
                                          $address_state,
                                          $address_zip,
                                          $country,
                                          $from_name,
                                          $from_email,
                                          $subject,
                                          $language,
                                          $optional_parameters = array())

    {

        $params = array('name' => $name,
            'permission_reminder' => $reminder,
            'email_type_option' => $emailtype,

            'contact' => array('company' => $company,
                'address1' => $address_street,
                'city' => $address_city,
                'state' => $address_state,
                'zip' => $address_zip,
                'country' => $country),

            'campaign_defaults' => array('from_name' => $from_name,
                'from_email' => $from_email,
                'subject' => $subject,
                'language' => $language)
        );

        if (!is_null($address_street2)) {
            $params['address2'] = $address_street2;
        }

        if (!is_null($optional_parameters['phone'])) {
            $params['contact']['phone'] = $optional_parameters['phone'];
        }

        $payload = json_encode($params);
        $url = $this->url . '/lists/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_growth_history_collection($listid)
    {
        $url = $this->url . '/lists/' . $listid . '/growth-history/';
        $response = $this->get($url);

        return $response;
    }

    // $month should be passed as a string formatted: "YYYY-MM"
    public function GET_lists_growth_history_instance($listid, $month)
    {
        $url = $this->url . '/lists/' . $listid . '/growth-history/' . $month;
        $response = $this->get($url);

        return $response;
    }

    public function GET_lists_instance($listid)
    {
        $url = $this->url . '/lists/' . $listid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_lists_instance($listid,
                                         $name,
                                         $reminder,
                                         $emailtype,
                                         $company,
                                         $address_street,
                                         $address_street2,
                                         $address_city,
                                         $address_state,
                                         $address_zip,
                                         $country,
                                         $from_name,
                                         $from_email,
                                         $subject,
                                         $language)


    {

        $params = array();
        $contactarray = array();
        $defaultsarray = array();

        if (!is_null($name)) {
            $params['name'] = $name;
        }
        if (!is_null($reminder)) {
            $params['permission_reminder'] = $reminder;
        }
        if (!is_null($emailtype)) {
            $params['email_type_option'] = $emailtype;
        }
        if (!is_null($company)) {
            $contactarray['company'] = $company;
        }
        if (!is_null($address_street)) {
            $contactarray['address1'] = $address_street;
        }
        if (!is_null($address_street2)) {
            $contactarray['address2'] = $address_street2;
        }
        if (!is_null($address_city)) {
            $contactarray['city'] = $address_city;
        }
        if (!is_null($address_state)) {
            $contactarray['state'] = $address_state;
        }
        if (!is_null($address_zip)) {
            $contactarray['zip'] = $address_zip;
        }
        if (!is_null($country)) {
            $contactarray['country'] = $country;
        }
        if (!is_null($from_name)) {
            $defaultsarray['from_name'] = $from_name;
        }
        if (!is_null($from_email)) {
            $defaultsarray['from_email'] = $from_email;
        }
        if (!is_null($subject)) {
            $defaultsarray['subject'] = $subject;
        }
        if (!is_null($language)) {
            $defaultsarray['language'] = $language;
        }
        if (!is_null($company) or
            !is_null($address_street) or
            !is_null($address_street2) or
            !is_null($address_city) or
            !is_null($address_state) or
            !is_null($address_zip) or
            !is_null($country)
        ) {
            $params['contact'] = $contactarray;
        }
        if (!is_null($from_name) or
            !is_null($from_email) or
            !is_null($subject) or
            !is_null($language)
        ) {
            $params['campaign_defaults'] = $defaultsarray;
        }

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_lists_instance($listid)
    {
        $url = $this->url . '/lists/' . $listid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_lists_interests_categories_collection($listid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    // $type can be "checkboxes", "radio", "hidden", or "dropdown"
    public function POST_lists_interests_categories_collection($listid, $title, $type)
    {
        $params = array('title' => $title, 'type' => $type);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/interest-categories/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_interests_categories_instance($listid, $category_id)
    {
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id;
        $response = $this->get($url);

        return $response;
    }

    public function GET_list_interests_collection($listid, $category_id, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id . '/interests' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_list_interests_collection($listid, $category_id, $name)
    {
        $params = array('name' => $name);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id . '/interests';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_interests_instance($listid, $category_id, $groupid)
    {
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id . '/interests/' . $groupid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_lists_interests_instance($listid, $category_id, $interestid, $name)
    {
        $params = array('name' => $name);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id . '/interests/' . $interestid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_lists_interests_instance($listid, $category_id, $interestid)
    {
        $url = $this->url . '/lists/' . $listid . '/interest-categories/' . $category_id . '/interests/' . $interestid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_lists_members_activity_collection($listid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/activity/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_list_members_collection($listid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/members/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_list_members_collection($listid, $emailaddress, $status, $optional_parameters = array())
    {
        $params = array('email_address' => $emailaddress,
            'status' => $status,
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/members/';

        $response = $this->post($url, $payload);

        return $response;
    }


    public function GET_lists_members_goals_collection($listid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/goals';
        $response = $this->get($url);

        return $response;
    }


    public function GET_list_members_instance($listid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id;
        $response = $this->get($url);

        return $response;
    }


    public function PATCH_list_members_instance($listid, $emailaddress, $optional_parameters = array())
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $params = array('email_address' => $emailaddress);

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function PUT_list_members_instance($listid, $emailaddress, $status, $optional_parameters = array())
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $params = array('email_address' => $emailaddress,
            'status' => $status
        );

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id;

        $response = $this->put($url, $payload);

        return $response;
    }


    public function DELETE_list_members_instance($listid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id;
        $response = $this->delete($url);

        return $response;
    }


    public function GET_lists_members_notes_collection($listid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/notes/';
        $response = $this->get($url);

        return $response;
    }

    public function POST_lists_members_notes_collection($listid, $emailaddress, $note)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $params = array('note' => $note);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/notes/';

        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_members_notes_instance($listid, $emailaddress, $noteid)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/notes/' . $noteid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_lists_members_notes_instance($listid, $emailaddress, $noteid, $note)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $params = array('note' => $note);

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/notes/' . $noteid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_lists_members_notes_instance($listid, $emailaddress, $noteid)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/lists/' . $listid . '/members/' . $member_id . '/notes/' . $noteid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_lists_merge_fields_collection($listid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/merge-fields/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    // $listid, $name, & $type are required fields, others are optional.
    // pass $required & $visible as boolean
    // SCHEMA DESCRIBES $type AS STRING
    // $types array('text','number','address','phone','email','date','url','imageurl','radio','dropdown','checkboxes','birthday','zip');
    public function POST_lists_merge_fields_collection($listid, $name, $type, $required, $default_value, $visible)
    {
        $params = array('name' => $name, 'type' => $type);

        if (!is_null($required)) {
            $param['required'] = $required;
        }

        if (!is_null($default_value)) {
            $param['default_value'] = $default_value;
        }

        if (!is_null($visible)) {
            $params['public'] = $visible;
        }

        $payload = json_encode($params);

        $url = $this->url . '/lists/' . $listid . '/merge-fields/';
        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_merge_fields_instance($listid, $mergeid)
    {
        $url = $this->url . '/lists/' . $listid . '/merge-fields/' . $mergeid;
        $response = $this->get($url);

        return $response;
    }

    //$listid, $name, & $type are required fields, others are optional.
    //If you are not passing any value then pass as NULL
    //pass $required & $visible as boolean
    //SCHEMA DESCRIBES $type AS STRING
    //$types array('text','number','address','phone','email','date','url','imageurl','radio','dropdown','checkboxes','birthday','zip');
    public function PATCH_lists_merge_fields_instance($listid, $mergeid, $name, $type, $required, $default_value, $visible)
    {

        $params = array();

        if (!is_null($name)) {
            $params['name'] = $name;
        }

        if (!is_null($type)) {
            $params['type'] = $type;
        }

        if (!is_null($required)) {
            $param['required'] = $required;
        }

        if (!is_null($default_value)) {
            $param['default_value'] = $default_value;
        }

        if (!is_null($visible)) {
            $params['public'] = $visible;
        }

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/merge-fields/' . $mergeid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_lists_merge_field_instance($listid, $mergeid)
    {
        $url = $this->url . '/lists/' . $listid . '/merge-fields/' . $mergeid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_lists_segments_collection($listid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/lists/' . $listid . '/segments/' . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function POST_lists_segments_collection($listid, $name, $conditions = NULl, $static_segment = NULL)
    {
        $params = array('name' => $name);

        if (!is_null($conditions)) {
            $params['options'] = $conditions;
        }

        if (!is_null($static_segment)) {
            $params['static_segment'] = $static_segment;
        }

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/segments/';
        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_lists_segments_instance($listid, $segmentid)
    {
        $url = $this->url . '/lists/' . $listid . '/segments/' . $segmentid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_lists_segments_instance($listid, $segmentid, $name, $conditions = NULL, $static_segment = NULL)
    {
        $params = array('name' => $name);

        if (!is_null($conditions)) {
            $params['options'] = $conditions;
        }

        if (!is_null($static_segment)) {
            $params['static_segment'] = $static_segment;
        }

        $payload = json_encode($params);
        $url = $this->url . '/lists/' . $listid . '/segments/' . $segmentid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_lists_segments_instance($listid, $segmentid)
    {
        $url = $this->url . '/lists/' . $listid . '/segments/' . $segmentid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_lists_segment_members($listid, $segmentid)
    {
        $url = $this->url . '/lists/' . $listid . '/segments/' . $segmentid . '/members';
        $response = $this->get($url);

        return $response;
    }

    // REPORTS RESOURCES ---------------------------------------------------------------------------------------------------------------

    public function GET_reports_abuse_collection($campaignid, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/abuse-reports/' . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_abuse_instance($campaignid, $abuseid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/abuse-reports/' . $abuseid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_advice_collection($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/advice/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_click_details_collection($campaignid, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/click-details/' . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_click_details_instance($campaignid, $linkid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/click-details/' . $linkid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_click_details_members_collection($campaignid, $urlid, $offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/click-details/' . $urlid . '/members/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_click_details_members_instance($campaignid, $urlid, $emailid, $offset = 0, $count = 10)
    {
        $url = $this->url . '/reports/' . $campaignid . '/click-details/' . $urlid . '/members/' . $emailid . '?offset=' . $offset . '&count=' . $count;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_collection($offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_domain_performance_collection($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/domain-performance/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_email_activity_collection($campaignid, $offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/email-activity/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_email_activity_instance($campaignid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/reports/' . $campaignid . '/email-activity/' . $member_id;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_instance($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_locations_collections($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/locations/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_sent_to_collection($campaignid, $offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/sent-to/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_sent_to_instance($campaignid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/reports/' . $campaignid . '/sent-to/' . $member_id;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_unsubscribes_collection($campaignid, $offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/reports/' . $campaignid . '/unsubscribed/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_unsubscribes_instance($campaignid, $emailaddress)
    {
        $hashprep = strtolower($emailaddress);
        $member_id = md5($hashprep);

        $url = $this->url . '/reports/' . $campaignid . '/unsubscribed/' . $member_id;
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_eepurl($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/eepurl/';
        $response = $this->get($url);

        return $response;
    }

    public function GET_reports_campaign_sub_reports($campaignid)
    {
        $url = $this->url . '/reports/' . $campaignid . '/sub-reports/';
        $response = $this->get($url);

        return $response;
    }

    // TEMPLATE FOLDERS RESOURCES ----------------------------------------------------------------------------------------------------------------

    public function GET_template_folders_collection()
    {
        $url = $this->url . '/template-folders/';
        $response = $this->get($url);

        return $response;
    }

    public function POST_template_folders_collection($foldername)
    {

        $params = array('name' => $foldername);

        $payload = json_encode($params);
        $url = $this->url . '/template-folders/';
        $response = $this->post($url, $payload);

        return $response;
    }

    public function GET_template_folders_instance($folderid)
    {
        $url = $this->url . '/template-folders/' . $folderid;
        $response = $this->get($url);

        return $response;
    }

    public function PATCH_template_folders_instance($folderid, $foldername)
    {
        $params = array('name' => $foldername);

        $payload = json_encode($params);
        $url = $this->url . '/template-folders/' . $folderid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    public function DELETE_template_folders_instance($folderid)
    {
        $url = $this->url . '/template-folders/' . $folderid;
        $response = $this->delete($url);

        return $response;
    }

    // TEMPLATES RESOURCES -----------------------------------------------------------------------------------------------------------------------

    public function GET_templates_collection($offset = 0, $count = 10, $filters = array())
    {
        $filter_string = '';
        foreach ($filters as $filter_key => $filter_value) {
            $encoded_value = urlencode($filter_value);
            $filter_string .= '&' . $filter_key . '=' . $encoded_value;
        }

        $url = $this->url . '/templates/' . '?offset=' . $offset . '&count=' . $count . $filter_string;
        $response = $this->get($url);

        return $response;
    }

    public function GET_templates_instance($templateid)
    {
        $url = $this->url . '/templates/' . $templateid;
        $response = $this->get($url);

        return $response;
    }

    // CURRENTLY NOT AVAILABLE - as of 07-04-2015

    public function PATCH_templates_instance($templateid, $name)
    {
        $params = array('name' => $name);

        $payload = json_encode($params);
        $url = $this->url . '/templates/' . $templateid;

        $response = $this->patch($url, $payload);

        return $response;
    }

    // CURRENTLY NOT AVAILABLE - as of 07-04-2015

    public function DELETE_templates_instance($templateid)
    {
        $url = $this->url . '/templates/' . $templateid;
        $response = $this->delete($url);

        return $response;
    }

    public function GET_template_instance_default_content($templateid)
    {
        $url = $this->url . '/templates/' . $templateid . '/default-content/';
        $response = $this->get($url);

        return $response;
    }
}

?>