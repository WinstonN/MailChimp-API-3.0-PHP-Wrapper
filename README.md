#MailChimp PHP Wrapper

This is a PHP wrapper for [version 3.0 of MailChimp's API](https://kb.mailchimp.com/api)

##Instantiation

	$some_var = new mailchimp('APIKEY');

##Calling a Resource

Each function returns decoded json. However the non-decoded MailChimp response can still be found in the '$response' class property. If you would like to see decoded function return, then try:

	try {

		var-dump($some_var->VERB_some_resource(argument 1, argument 2, etc.));

	} catch (exception $e) {

	}

##Pagination

Some functions (primarily GET requests against collections) can paginate their returns using the $offset and $count arguments. Not providing a value for these arguments will default their values to $offset= 0 and $count= 10. Please see "Pagination" [HERE](http://developer.mailchimp.com/documentation/mailchimp/guides/get-started-with-mailchimp-api-3/#parameters).

##Filters

Top level filtering to be explored in the near future.

##API Resources & Their Associated Funtions

Resources as they appear in MailChimp's [documentation](http://developer.mailchimp.com/documentation/mailchimp/reference/overview/) are on top while the method too call from the library can be found on bottom with its arguments listed.

####Root:

	GET: /
	GET_root();

####Authorized Apps:

	GET: /authorized-apps
	GET_authorized_apps_collection ($offset = 0, $count = 10)

	GET: /authorized-apps/{app_id}
	GET_authorized_apps_instance ($appid);

	POST: /authorized-apps
	POST_authorized_apps_collection ($client_id, $client_sec);

####Automations:

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

####Batch Operations

	POST: /batches
	POST_batches_collection ($operations = array());

	GET: /batches
	GET_batches_collection ();

	GET: /batches/{batch_id}
	GET_batches_instance ($batchid);

####Campaign Folders

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

####Campaigns

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

####Conversations

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

####E-commerce Stores

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

####File Manager Files

	POST: /file-manager/files
	POST_file_manager_files_collection ($name, $fileurl);

	GET: /file-manager/files
	GET_file_manager_files_collection ($offset = 0, $count = 10);

	GET: /file-manager/files/{file_id}
	GET_file_manager_files_instance ($fileid);

	PATCH: /file-manager/files/{file_id}
	PATCH_file_manager_files_instance ($fileid, $folderid);

	DELETE: /file-manager/files/{file_id}	
	DELETE_file_manager_files_instance ($fileid)

####File Manager Folders

	POST: /file-manager/folders
	POST_file_manager_folders_collection ($folderid, $name);

	GET: /file-manager/folders
	GET_file_manager_folders_collection ($offset = 0, $count = 10);

	GET: /file-manager/folders/{folder_id}
	GET_file_manager_folders_instance ($folderid);

	PATCH: /file-manager/folders/{folder_id}
	PATCH_file_manager_folders_instance ($folderid, $name);

	DELETE: /file-manager/folders/{folder_id}
	DELETE_file_manager_folders_instance ($folderid);

####Lists
	
	POST: /lists
	POST_lists_collection ($name,$reminder,$emailtype, $company, $address_street, $address_street2, $address_city, $address_state, $address_zip, $country, $from_name, $from_email, $subject, $language, $optional_parameters = array());

	GET: /lists
	GET_lists_collection ($offset = 0, $count = 10);

	GET: /lists/{list_id}
	GET_lists_instance ($listid);

	
	PATCH: /lists/{list_id}
	PATCH_lists_instance ($listid, $name, $reminder, $emailtype, $company, $address_street, $address_street2, $address_city, $address_state, $address_zip, $country, $from_name, $from_email, $subject, $language);

	DELETE: /lists/{list_id}	
	DELETE_lists_instance ($listid);

	GET: /lists/{list_id}/abuse-reports
	GET_list_abuse_collection ($listid);	

	GET: /lists/{list_id}/abuse-reports/{report_id}
	GET_list_abuse_instance ($listid, $reportid);

	GET: /lists/{list_id}/activity
	GET_lists_activity_collection ($listid, $offset = 0, $count = 10);

	GET: /lists/{list_id}/clients
	GET_lists_clients_collection ($listid);

	GET: /lists/{list_id}/growth-history
	GET_lists_growth_history_collection ($listid);

	GET: /lists/{list_id}/growth-history/{month}
	GET_lists_growth_history_instance ($listid, $month);

	POST: /lists/{list_id}/interest-categories
	POST_lists_interests_categories_collection ($listid, $title, $type);

	GET: /lists/{list_id}/interest-categories
	GET_lists_interests_categories_collection ($listid,  $offset = 0, $count = 10);

	GET: /lists/{list_id}/interest-categories/{interest_category_id}
	GET_lists_interests_categories_instance ($listid, $category_id);

	PATCH: /lists/{list_id}/interest-categories/{interest_category_id}
	COMING SOON

	DELETE: /lists/{list_id}/interest-categories/{interest_category_id}
	COMING SOON

	GET: /lists/{list_id}/interest-categories/{interest_category_id}/interests
	GET_list_interests_collection ($listid, $category_id, $offset = 0, $count = 10);

	GET: /lists/{list_id}/interest-categories/{interest_category_id}/interests/{interest_id}
	GET_lists_interests_instance ($listid, $category_id, $groupid);

	PATCH: /lists/{list_id}/interest-categories/{interest_category_id}/interests/{interest_id}
	PATCH_lists_interests_instance ($listid, $category_id, $interestid, $name);

	DELETE: /lists/{list_id}/interest-categories/{interest_category_id}/interests/{interest_id}	
	DELETE_lists_interests_instance ($listid, $category_id, $interestid);

	POST: /lists/{list_id}/members
	POST_list_members_collection ($listid, $emailaddress, $status, $optional_parameters = array());

	GET: /lists/{list_id}/members
	GET_list_members_collection ($listid, $offset = 0, $count = 10);

	GET: /lists/{list_id}/members/{subscriber_hash}	
	GET_list_members_instance ($listid, $emailaddress);

	PATCH: /lists/{list_id}/members/{subscriber_hash}
	PATCH_list_members_instance ($listid, $emailaddress, $optional_parameters = array());

	PUT: /lists/{list_id}/members/{subscriber_hash}	
	PUT_list_members_instance ($listid, $emailaddress, $status, $optional_parameters = array());

	DELETE: /lists/{list_id}/members/{subscriber_hash}
	DELETE_list_members_instance ($listid, $emailaddress);

	GET: /lists/{list_id}/members/{subscriber_hash}/activity
	GET_lists_members_activity_collection ($listid, $emailaddress);

	GET: /lists/{list_id}/members/{subscriber_hash}/goals
	GET_lists_members_goals_collection ($listid, $emailaddress);

	POST: /lists/{list_id}/members/{subscriber_hash}/notes
	POST_lists_members_notes_collection ($listid, $emailaddress, $note)
	
	GET: /lists/{list_id}/members/{subscriber_hash}/notes
	GET_lists_members_notes_collection ($listid, $emailaddress);

	GET: /lists/{list_id}/members/{subscriber_hash}/notes/{note_id}
	GET_lists_members_notes_instance ($listid, $emailaddress, $noteid);

	PATCH: /lists/{list_id}/members/{subscriber_hash}/notes/{note_id}	
	PATCH_lists_members_notes_instance ($listid, $emailaddress, $noteid, $note);

	DELETE:	/lists/{list_id}/members/{subscriber_hash}/notes/{note_id}
	DELETE_lists_members_notes_instance ($listid, $emailaddress, $noteid);

	POST: /lists/{list_id}/merge-fields
	POST_lists_merge_fields_collection ($listid, $name, $type, $required, $default_value, $visible);

	GET: /lists/{list_id}/merge-fields
	GET_lists_merge_fields_collection ($listid, $offset = 0, $count = 10);

	GET: /lists/{list_id}/merge-fields/{merge_id}
	GET_lists_merge_fields_instance ($listid, $mergeid);

	PATCH: /lists/{list_id}/merge-fields/{merge_id}
	PATCH_lists_merge_fields_instance ($listid, $mergeid, $name, $type, $required, $default_value, $visible);

	DELETE: /lists/{list_id}/merge-fields/{merge_id}
	DELETE_lists_merge_field_instance ($listid, $mergeid);

	POST: /lists/{list_id}/segments
	POST_lists_segments_collection ($listid, $name, $conditions = NULl, $static_segment = NULL);

	GET: /lists/{list_id}/segments
	GET_lists_segments_collection ($listid, $offset = 0, $count = 10);

	GET: /lists/{list_id}/segments/{segment_id}
	GET_lists_segments_instance ($listid, $segmentid);

	PATCH: /lists/{list_id}/segments/{segment_id}	
	PATCH_lists_segments_instance ($listid, $segmentid, $name, $conditions = NULL, $static_segment = NULL);

	DELETE: /lists/{list_id}/segments/{segment_id}
	DELETE_lists_segments_instance ($listid, $segmentid);

	POST: /lists/{list_id}/segments/{segment_id}/members
	COMING SOON

	GET: /lists/{list_id}/segments/{segment_id}/members	
	COMING SOON

	DELETE: /lists/{list_id}/segments/{segment_id}/members/{subscriber_hash}
	COMING SOON

	

####THIS LIST IS NOT COMPLETE BUT ALL ENDPOINT ARE PRESENT WITHIN THE WRAPPER. I WILL UPDATE THE README TO REFLECT THIS SOON.

##Notes

- In almost all endpoints requiring a subscriber hash this library only requires the email address, and will generate the hash on it's own. 

- non-required body parameters for POST, PUT, & PATCH requests should be placed in $optional_parameters for that method.

- Timestamp format: "YYYY/MM/DD HH:MM:SS"

If you dont feel like this helps you, then this .gif of some dogs is the best I can do.

![OMFGDOGS](http://omfgdogs.com/omfgdogs.gif)


