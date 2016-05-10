#MailChimp PHP Wrapper

This is a PHP wrapper for [version 3.0 of MailChimp's API](https://kb.mailchimp.com/api)

##Example [Instantiation]

	$some_var = new mailchimp('APIKEY');

##Example [Calling a Resource]

Each function returns decoded json. However the non-decoded MailChimp response can still be found in the '$response' class property. If you would like to see decoded function return, then try:

	try {

		var-dump($some_var->VERB_some_resource(argument 1, argument 2, etc.));

	} catch (exception $e) {

	}

##Pagination

Some functions (primarily GET requests against collections) can paginate their returns using the $offset and $count arguments. Not providing a value for these arguments will default these arguments to $offset= 0 and $count= 10. Please see "Pagination" [HERE](http://developer.mailchimp.com/documentation/mailchimp/guides/get-started-with-mailchimp-api-3/#parameters).

##Filters

Top level filtering to be explored in the near future.

##Resources & Their Functions

Resources as they appear in MailChimp's [documentation](http://developer.mailchimp.com/documentation/mailchimp/reference/overview/) are on top while the method too call from the library can be found on bottom with its arguments listed.

###Root:

	GET: /
	GET_root();

###Authorized Apps:

	GET: /authorized-apps
	GET_authorized_apps_collection ($offset = 0, $count = 10)

	GET: /authorized-apps/{app_id}
	GET_authorized_apps_instance ($appid);

	POST: /authorized-apps
	POST_authorized_apps_collection ($client_id, $client_sec);

###Automations:

	GET: /automations
	GET_automations_collection ($offset = 0, $count = 10);

	GET: /automations/{workflow_id}
	GET_automations_instance ($workflowid);

	POST: /automations/{workflow_id}/actions/pause-all-emails
	COMING SOON

	POST: /automations/{workflow_id}/actions/start-all-emails
	COMING SOON

	GET: /automations/{workflow_id}/emails
	GET_automations_emails_collection ($workflowid, $offset = 0, $count = 10);

	GET: /automations/{workflow_id}/emails/{workflow_email_id}
	GET_automations_emails_instance ($workflowid, $emailid);

	POST: /automations/{workflow_id}/emails/{workflow_email_id}/actions/pause
	POST_pause_automated_email ($workflowid, $emailid);

	POST: /automations/{workflow_id}/emails/{workflow_email_id}/actions/start
	POST_start_automated_email ($workflowid, $emailid);

	POST: /automations/{workflow_id}/emails/{workflow_email_id}/queue
	POST_automations_emails_queue_collection ($workflowid, $emailid, $emailaddress);

	GET: /automations/{workflow_id}/emails/{workflow_email_id}/queue
	GET_automations_emails_queue_collection ($workflowid, $emailid, $offset = 0, $count = 10);

	GET: /automations/{workflow_id}/emails/{workflow_email_id}/queue/{subscriber_hash}	
	GET_automations_emails_queue_instance ($workflowid, $emailid, $emailaddress);

	POST: /automations/{workflow_id}/removed-subscribers
	POST_automations_workflow_removed_subscribers ($workflowid, $emailaddress);

	GET: /automations/{workflow_id}/removed-subscribers	
	GET_automations_workflow_removed_subscribers ($workflowid);

###Batch Operations

	POST: /batches
	POST_batches_collection ($operations = array());

	GET: /batches
	GET_batches_collection ();

	GET: /batches/{batch_id}
	GET_batches_instance ($batchid);

###Campaign Folders

	POST: /campaign-folders	
	POST_camapigns_folders_collection ($foldername);

	GET: /campaign-folders
	GET_campaigns_folders_collection ();

	GET	/campaign-folders/{folder_id}
	GET_campaigns_folders_instance ($folderid);

	PATCH: /campaign-folders/{folder_id}
	PATCH_campaigns_folders_instance ($folderid, $foldername);

	DELETE:	/campaign-folders/{folder_id}
	DELETE_campaigns_folders_instance ($folderid);

###Campaigns

	POST: /campaigns
	POST_campaigns_collection ($type, $settings = array(), $optional_parameters = array());

	GET: /campaigns	
	GET_campaigns_collection ($offset = 0, $count = 10);

	GET: /campaigns/{campaign_id}
	GET_campaigns_instance ($campaignid);

	PATCH: /campaigns/{campaign_id};
	PATCH_campaigns_instance ($campaignid, $type, $settings = array(), $optional_parameters = array());

	DELETE:	/campaigns/{campaign_id}
	DELETE_campaigns_instance ($campaignid);

	POST: /campaigns/{campaign_id}/actions/cancel-send	
	POST_campaign_cancel_send ($campaignid);

	POST: /campaigns/{campaign_id}/actions/pause
	POST_campaign_pause ($campaignid);

	POST:/campaigns/{campaign_id}/actions/replicate
	POST_campaigns_replicate($campaignid);

	POST: /campaigns/{campaign_id}/actions/resume
	POST_campaigns_resume($campaignid);

	POST: /campaigns/{campaign_id}/actions/schedule	
	COMING SOON

	POST: /campaigns/{campaign_id}/actions/send
	POST_campaign_send ($campaignid);

	POST: /campaigns/{campaign_id}/actions/test	
	COMING SOON

	POST: /campaigns/{campaign_id}/actions/unschedule
	COMING SOON

	GET: /campaigns/{campaign_id}/content	
	GET_campaign_content ($campaignid);

	PUT	/campaigns/{campaign_id}/content
	PUT_campaign_content ($campaignid, $params);

	POST: /campaigns/{campaign_id}/feedback
	POST_campaigns_feedback_collection ($campaignid, $message);

	GET: /campaigns/{campaign_id}/feedback
	GET_campaigns_feedback_collection ($campaignid);

	GET: /campaigns/{campaign_id}/feedback/{feedback_id}	
	GET_campaigns_feedback_instance ($campaignid, $feedbackid);

	PATCH: /campaigns/{campaign_id}/feedback/{feedback_id}
	PATCH_campaigns_feedback_instance ($campaignid, $feedbackid, $message);

	DELETE: /campaigns/{campaign_id}/feedback/{feedback_id}	
	DELETE_campaigns_feedback_instance ($campaignid, $feedbackid);

	GET	/campaigns/{campaign_id}/send-checklist	
	GET_send_checklist ($campaignid);

###Conversations

	GET: /conversations
	GET_conversations_collection ($offset = 0, $count = 10);

	GET: /conversations/{conversation_id}
	GET_conversations_instance ($conversationid);

	POST: /conversations/{conversation_id}/messages
	POST_conversations_messages_collection ($conversationid, $fromemail, $read, $subject, $message);

	GET: /conversations/{conversation_id}/messages
	GET_conversations_messages_collection ($conversationid);

	GET: /conversations/{conversation_id}/messages/{message_id}
	GET_conversations_messages_instance ($conversationid, $messageid);

###E-commerce Stores

	POST: /ecommerce/stores
	POST_ecommerce_stores_collection ($storeid, $listid, $name, $currencycode, $optional_parameters = array());

	GET: /ecommerce/stores
	GET_ecommerce_stores_collection ($offset = 0, $count = 10);

	GET: /ecommerce/stores/{store_id}
	GET_ecommerce_stores_instance ($storeid);

	PATCH: /ecommerce/stores/{store_id}
	PATCH_ecommerce_stores_instance ($storeid, $update_params = array());

	DELETE: /ecommerce/stores/{store_id}
	DELETE_ecommerce_stores_instance ($storeid);

	POST: /ecommerce/stores/{store_id}/carts
	POST_ecommerce_carts_collection ($storid, $cartid, $customer = array(), $currency_code, $order_total, $lines, $optional_parameters = array());

	GET: /ecommerce/stores/{store_id}/carts
	GET_ecommerce_carts_collection ($storeid, $offset = 0, $count = 10, $filters = array());

	GET: /ecommerce/stores/{store_id}/carts/{cart_id}
	GET_ecommerce_carts_instance ($storeid, $cartid);

	DELETE: /ecommerce/stores/{store_id}/carts/{cart_id}
	DELETE_ecommerce_carts_instance ($storeid, $cartid);

	POST: /ecommerce/stores/{store_id}/customers
	POST_ecommerce_customers_collection ($storeid, $customerid, $customer_email, $opt_in_status, $optional_parameters= array());

	GET: /ecommerce/stores/{store_id}/customers
	GET_ecommerce_customers_collection ($storeid, $offset = 0, $count = 10);

	GET: /ecommerce/stores/{store_id}/customers/{customer_id}
	GET_ecommerce_customers_instance ($storeid, $customerid);

	PATCH: /ecommerce/stores/{store_id}/customers/{customer_id}	
	PATCH_ecommerce_customer_instance ($storeid, $customerid, $patch_parameters = array());

	PUT: /ecommerce/stores/{store_id}/customers/{customer_id}
	PUT_ecommerce_customer_instance ($storeid, $customerid, $customer_email, $opt_in_status, $optional_parameters = array());

	DELETE: /ecommerce/stores/{store_id}/customers/{customer_id}
	DELETE_ecommerce_customer_instance ($storeid, $customerid);

	POST: /ecommerce/stores/{store_id}/orders
	POST_ecommerce_orders_collection ($storeid, $orderid, $customer = array(), $currency_code, $order_total, $lines, $optional_parameters = array());

	GET: /ecommerce/stores/{store_id}/orders
	GET_ecommerce_orders_collection ($storeid, $offset = 0, $count = 10);

	GET	/ecommerce/stores/{store_id}/orders/{order_id}
	GET_ecommerce_order_instance ($storeid, $orderid);

	PATCH: /ecommerce/stores/{store_id}/orders/{order_id}
	PATCH_ecommerce_order_instance ($storeid, $orderid, $patch_parameters = array());

	DELETE: /ecommerce/stores/{store_id}/orders/{order_id}
	DELETE_ecommerce_order_instance ($storeid, $orderid);

	POST: /ecommerce/stores/{store_id}/orders/{order_id}/lines
	POST_ecommerce_order_lines_collection ($storeid, $orderid, $lineid, $productid, $product_varientid, $quantity, $price);

	GET: /ecommerce/stores/{store_id}/orders/{order_id}/lines
	GET_ecommerce_order_lines_collection ($storeid, $orderid, $offset = 0, $count = 10);

	GET	/ecommerce/stores/{store_id}/orders/{order_id}/lines/{line_id}
	GET_ecommerce_order_lines_instance ($storeid, $orderid, $lineid);

	PATCH: /ecommerce/stores/{store_id}/orders/{order_id}/lines/{line_id}
	PATCH_ecommerce_order_line_instance ($storeid, $orderid, $lineid, $patch_parameters = array());

	DELETE: /ecommerce/stores/{store_id}/orders/{order_id}/lines/{line_id}
	DELETE_ecommerce_order_line_instance ($storeid, $orderid, $lineid);

	POST: /ecommerce/stores/{store_id}/products
	POST_ecommerce_products_collection ($storeid, $productid, $title, $variants = array(), $optional_parameters = array());

	GET: /ecommerce/stores/{store_id}/products
	GET_ecommerce_products_collection ($storeid, $offset = 0, $count = 10);

	GET: /ecommerce/stores/{store_id}/products/{product_id}	
	GET_ecommerce_products_instance ($storeid, $productid);

	DELETE: /ecommerce/stores/{store_id}/products/{product_id}
	DELETE_ecommerce_products_instance ($storeid, $productid);

	POST: /ecommerce/stores/{store_id}/products/{product_id}/variants
	POST_ecommerce_product_variants_collection ($storeid, $productid, $variantid, $title, $optional_parameters = array());

	GET	/ecommerce/stores/{store_id}/products/{product_id}/variants	
	GET_ecommerce_product_variants_collection ($storeid, $productid, $offset = 0, $count = 10);

	GET	/ecommerce/stores/{store_id}/products/{product_id}/variants/{variant_id}
	GET_ecommerce_product_variants_instance ($storeid, $productid, $variantid);

	PATCH: /ecommerce/stores/{store_id}/products/{product_id}/variants/{variant_id}	
	GET_ecommerce_product_variants_instance ($storeid, $productid, $variantid)

	PUT: /ecommerce/stores/{store_id}/products/{product_id}/variants/{variant_id}
	PUT_ecommerce_product_variant_instance ($storeid, $productid, $variantid, $variantid, $title, $optional_parameters = array());

	DELETE: /ecommerce/stores/{store_id}/products/{product_id}/variants/{variant_id}
	DELETE_ecommerce_product_variant_instance ($storeid, $productid, $variantid);

####UPDATING THIS DOC AS YOU READ THIS.

##Notes

- In almost all endpoints requiring a subscriber hash this library only requires the email address, and will generate the hash on it's own. 

- non-required body parameters for POST, PUT, & PATCH requests should be placed in $optional_parameters for that method.

- Timestamp format: "YYYY/MM/DD HH:MM:SS"

If you dont feel like this helps you, then this .gif of some dogs is the best I can do.

![OMFGDOGS](http://omfgdogs.com/omfgdogs.gif)


