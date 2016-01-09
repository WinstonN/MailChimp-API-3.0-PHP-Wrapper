<?php

class mailchimp {

	public $auth;
	public $url;
	public $exp_apikey;

	public $response;
		
	public function __construct ($apikey) {
		$this->exp_apikey = explode('-', $apikey);
		$this->auth = array('Authorization: apikey '.$this->exp_apikey[0].'-'.$this->exp_apikey[1]); 
	    $this->url = "Https://".$this->exp_apikey[1].".api.mailchimp.com/3.0";
	    return $this->auth;
	    return $this->url;

	} 



	//ACCOUNT --------------------------------------------------------------------------------------------------------------------------------------

	public function GET_root () {
		$ch = curl_init($this->url."/");
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}




	//AUTHORIZED APPS RESOURCES --------------------------------------------------------------------------------------------------------------------


	public function GET_authorized_apps_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/authorized-apps/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_authorized_apps_instance ($appid) {

		$ch = curl_init($this->url.'/authorized-apps/'.$appid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_authorized_apps_collection ($client_id, $client_sec) {

		$params = array(
						'client_id' => $client_id , 
						'client_secret' => $client_sec
						);

		$payload = json_encode($params);
		
		$ch = curl_init($this->url.'/authorized-apps/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}




	//AUTOMATIONS RESOURCES ------------------------------------------------------------------------------------------------------------------------

	public function GET_automations_collection ($offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/automations/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_emails_collection ($workflowid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_emails_instance ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}	

	//Calling this function will pause an email in an automation workflow

	public function POST_pause_automated_email ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/actions/pause');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//Calling this function will unpause an email in an automation workflow

	public function POST_start_automated_email ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/actions/start');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_emails_queue_collection ($workflowid, $emailid, $offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	
	public function POST_automations_emails_queue_collection ($workflowid, $emailid, $emailaddress) {

		$params = array('email_address' => $emailaddress);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_emails_queue_instance ($workflowid, $emailid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_instance ($workflowid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_automations_workflow_removed_subscribers ($workflowid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/removed-subscribers/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function POST_automations_workflow_removed_subscribers ($workflowid, $emailaddress) {

		$params = array('email_address' => $emailaddress);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/removed-subscribers/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}



	//BATCH OPERATIONS RESOURCES ---------------------------------------------------------------------------------------------------------------------

	public function POST_batches_collection ($operations = array()) {

		$params = array('operations' => $operations);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/batches/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_batches_collection () {
		$ch = curl_init($this->url.'/batches/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_batches_instance ($batchid) {
		$ch = curl_init($this->url.'/batches/'.$batchid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}
	



	//CAMPAIGNS FOLDERS RESOURCES --------------------------------------------------------------------------------------------------------------------

	public function POST_camapigns_folders_collection ($foldername) {

		$params = array('name'=> $foldername);

		$payload -json_encode($params);

		$ch = curl_init($this->url.'campaign-folders');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_campaigns_folders_collection () {
		$ch = curl_init($this->url.'/camapigns-folders/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_campaigns_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/camapigns-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_campaigns_folders_instance ($folderid, $foldername) {

		$params = array('name' => $foldername);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/camapigns-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_campaigns_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/camapigns-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}




	//CAMPAIGNS RESOURCES ----------------------------------------------------------------------------------------------------------------------------

	public function GET_campaigns_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/campaigns/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch); 
		return json_decode($this->response);
	}

	public function POST_campaigns_collection ($type, 
											   $recipients = array(), 
											   $settings = array(), 
											   $variate_settings = NULL, 
											   $tracking = NULL,
											   $rss_opts = NULL,
											   $ab_split_opts = NULL,
											   $social_card = NULL,
											   $report_summary = NULL,
											   $delivery_status = NULL
											   ) {
		$params = array('type'=>$type,
						'recipients'=>$recipients,
						'settings'=>$settings);

		if (!is_null($variate_settings)) {
			$params['variate_settings'] = $variate_settings;
		} 
		if (!is_null($tracking)) {
			$params['tracking'] = $tracking;
		}
		if (!is_null($rss_opts)) {
			$param['rss_opts'] = $rss_opts;
		}
		if (!is_null($ab_split_opts)) {
			$params['ab_split_opts'] = $ab_split_opts;
		}
		if (!is_null($social_card)) {
			$params['social_card'] = $social_card;
		}
		if (!is_null($report_summary)) {
			$params['report_summary'] = $report_summary;
		}
		if (!is_null($delivery_status)) {
			$params['delivery_status'] = $delivery_status;
		}

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/campaigns/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function GET_campaigns_feedback_collection ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//$message is the string you would like to pass as a comment to a campaign

	public function POST_campaigns_feedback_collection ($campaignid, $message) {

		$feedback = array('message' => $message);

		$payload = json_encode($feedback);

		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_campaigns_feedback_instance ($campaignid, $feedbackid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//$message is the string you would like to pass as a campaign comment

	public function PATCH_campaigns_feedback_instance ($campaignid, $feedbackid, $message) {

		$newmessage = array('message' => $message);

		$payload = json_encode($newmessage);
		
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//DELETE functionality for this endpoint not yet available as of 07-04-2015

	public function DELETE_campaigns_feedback_instance ($campaignid, $feedbackid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_campaigns_instance ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_campaigns_instance ($campaignid,
											  $type, 
											  $recipients = array(), 
											  $settings = array(), 
											  $variate_settings = NULL, 
											  $tracking = NULL,
											  $rss_opts = NULL,
											  $ab_split_opts = NULL,
											  $social_card = NULL,
											  $report_summary = NULL,
											  $delivery_status = NULL
											  ) {

		$params = array('type'=>$type,
						'recipients'=>$recipients,
						'settings'=>$settings);

		if (!is_null($variate_settings)) {
			$params['variate_settings'] = $variate_settings;
		} 
		if (!is_null($tracking)) {
			$params['tracking'] = $tracking;
		}
		if (!is_null($rss_opts)) {
			$param['rss_opts'] = $rss_opts;
		}
		if (!is_null($ab_split_opts)) {
			$params['ab_split_opts'] = $ab_split_opts;
		}
		if (!is_null($social_card)) {
			$params['social_card'] = $social_card;
		}
		if (!is_null($report_summary)) {
			$params['report_summary'] = $report_summary;
		}
		if (!is_null($delivery_status)) {
			$params['delivery_status'] = $delivery_status;
		}

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/campaigns/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_campaigns_instance ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_campaign_send ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/actions/send/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_campaign_cancel_send ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/actions/cancel-send/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_campaign_content ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/content/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}	

	public function PUT_campaign_content ($campaignid,
										  $plain_text = NULL, 
										  $html = NULL,
										  $url = NULL,
										  $template = NULL,
										  $archive = NULL,
										  $variate_contents = NULL
										  ) {

		$params = array();

		if (!is_null($plain_text)) {
			$params['plain_text'] = $plain_text;
		}
		if (!is_null($html)) {
			$params['html'] = $html;
		}
		if (!is_null($url)) {
			$params['url'] = $url;
		}
		if (!is_null($template)) {
			$params['template'] = $template;
		}
		if (!is_null($archive)) {
			$params['archive'] = $archive;
		}
		if (!is_null($variate_contents)) {
			$params['variate_contents'] = $variate_contents;
		}

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/content/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_send_checklist ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/send-checklist/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}



	//CONVERSATIONS RESOURCES ----------------------------------------------------------------------------------------------------------------------

	public function GET_conversations_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/conversations/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_conversations_instance ($conversationid) {
		$ch = curl_init($this->url.'/conversations/'.$conversationid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_conversations_messages_collection ($conversationid, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/conversations/'.$conversationid.'/messages/'.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	// This function creates a new entry in an existing conversation
	// $read must be passed as a boolean. 

	public function POST_conversations_messages_collection ($conversationid, $fromemail, $read, $subject, $message) {

		$conversation = array('from_email' => $fromemail, 'read' => $read, 'subject' => $subject, 'message' => $message);

		$payload = json_encode($conversation);

		$ch = curl_init($this->url.'/conversations/'.$conversationid.'/messages/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_conversations_messages_instance ($conversationid, $messageid) {
		$ch = curl_init($this->url.'/campaigns/'.$conversationid.'/messages/'.$messageid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}






	//FILE MANAGER RESOURCES --------------------------------------------------------------------------------------------------------------


	public function GET_file_manager_files_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/file-manager/files/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	// $fileurl IS THE URL THE FILE YOU WOULD LIKE TO UPLOAD TO THE FILE MANAGER CAN BE FOUND AT
	// $name DOES NOT REQUIRE THE FILE EXTENSION AS THIS WILL BE PULLED FROM $fileurl
	// NOTE THAT NOT ALL TYPES OF FILES ARE ACCPETABLE FOR UPLOAD SEE URL BELOW FOR DETAILS
	// http://kb.mailchimp.com/campaigns/images-videos-files/host-files-in-mailchimp

	public function POST_file_manager_files_collection ($name, $fileurl) {

		$file = file_get_contents($fileurl);
		$ext = pathinfo($fileurl, PATHINFO_EXTENSION);
		$data = base64_encode($file);

		$params = array('name'=>$name.'.'.$ext, 'file_data' => $data);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/file-manager/files/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_file_manager_files_instance ($fileid) {
		$ch = curl_init($this->url.'/file-manager/files/'.$fileid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//CURRENTLY YOU CAN ONLY UPDATE WHAT FOLDER A FILE IS LOCATED IN

	public function PATCH_file_manager_files_instance ($fileid, $folderid) {

		$params = array('folder_id' => $folderid);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/file-manager/files/'.$fileid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_file_manager_files_instance ($fileid) {
		$ch = curl_init($this->url.'/file-manager/files/'.$fileid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_file_manager_folders_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/file-manager/folders/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_file_manager_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/file-manager/folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_file_manager_folders_instance ($folderid, $name) {

		$params = array('name' => $name);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/file-manager/folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_file_manager_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/file-manager/folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}






	//LISTS RESOURCES -----------------------------------------------------------------------------------------------------------------------

	public function GET_list_abuse_collection ($listid, $filters = array()) {
	
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/abuse-reports/'.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_list_abuse_instance ($listid, $reportid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/abuse-reports/'.$reportid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_activity_collection ($listid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/activity/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_clients_collection ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/clients/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_collection ($offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_lists_collection ($name, 
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
							  			   $language
							  			   )	

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

		$payload = json_encode($params);
		
		$ch = curl_init($this->url.'/lists/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_lists_growth_history_collection ($listid, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/growth-history/'.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//$month should be passed as a string formatted: "YYYY-MM"

	public function GET_lists_growth_history_instance ($listid, $month) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/growth-history/'.$month);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_instance ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_lists_instance  ($listid, 
							   			   $name, 
							   			   $reminder, 
							   			   $emailtype, 
							   			   $company, #bool
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
		if (!is_null($company)or
			!is_null($address_street)or
			!is_null($address_street2)or
			!is_null($address_city)or
			!is_null($address_state)or
			!is_null($address_zip)or
			!is_null($country)
			) {
		$params['contact'] = $contactarray;
		}
		if (!is_null($from_name)or
			!is_null($from_email)or
			!is_null($subject)or
			!is_null($language)
			) {
		$params['campaign_defaults'] = $defaultsarray;
		}
		
		$payload = json_encode($params);

		$ch = curl_init($this->url.'/lists/'.$listid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function DELETE_lists_instance ($listid) {

		$ch = curl_init($this->url.'/lists/'.$listid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_interests_categories_collection ($listid,  $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//$type can be "checkboxes", "radio", "hidden", or "dropdown"

	public function POST_lists_interests_categories_collection ($listid, $title, $type) {

		$params = array('title' => $title, 'type' => $type);

		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/interest-categories/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_lists_interests_categories_instance ($listid, $category_id) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_list_interests_collection ($listid, $category_id, $offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_list_interests_collection ($listid, $category_id, $name) {

		$params = array('name' => $name);

		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_lists_interests_instance ($listid, $category_id, $groupid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests/'.$groupid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_lists_interests_instance ($listid, $category_id, $interestid, $name) {

		$params = array('name' => $name);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests/'.$interestid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function DELETE_lists_interests_instance ($listid, $category_id, $interestid) {

		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests/'.$interestid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_members_activity_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/activity/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_list_members_collection ($listid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function POST_list_members_collection ($listid, 
												  $emailaddress, 
												  $status, 
												  $email_type = NULL,
												  $merge_fields = NULL,
												  $interests = NULL,
												  $language = NULL,
												  $vip = NULL,
												  $location = NULL 
												  ) {

		$params = array('email_address' => $emailaddress,
						'status' => $status,
						);

		if (!is_null($email_type)) {
			$params['email_type'] = $email_type;
		}
		if (!is_null($merge_fields)) {
			$params['merge_fields'] = $merge_fields;
		}
		if (!is_null($interests)) {
			$params['interests'] = $interests;
		}
		if (!is_null($language)) {
			$params['language'] = $language;
		}
		if (!is_null($vip)) {
			$params['vip'] = $vip;
		}
		if (!is_null($location)) {
			$params['location'] = $location;
		}


		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function GET_lists_members_goals_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/goals');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function GET_list_members_instance ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function PATCH_list_members_instance ($listid, 
												 $emailaddress, 
												 $status = NULL, 
												 $email_type = NULL,
												 $merge_fields = NULL,
												 $interests = NULL,
												 $language = NULL,
												 $vip = NULL,
												 $location = NULL
												 ) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$params = array('email_address' => $emailaddress);

		if (!is_null($status)) {
			$params['status'] = $status;
		}
		if (!is_null($email_type)) {
			$params['email_type'] = $email_type;
		}
		if (!is_null($merge_fields)) {
			$params['merge_fields'] = $merge_fields;
		}
		if (!is_null($interests)) {
			$params['interests'] = $interests;
		}
		if (!is_null($language)) {
			$params['language'] = $language;
		}
		if (!is_null($vip)) {
			$params['vip'] = $vip;
		}
		if (!is_null($location)) {
			$params['location'] = $location;
		}


		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function PUT_list_members_instance ($listid, 
											   $emailaddress, 
											   $status, 
											   $email_type = NULL,
											   $merge_fields = NULL,
											   $interests = NULL,
											   $language = NULL,
											   $vip = NULL,
											   $location = NULL,
											   $status_if_new = NULL
											   ) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$params = array('email_address' => $emailaddress,
						'status' => $status
						);

		if (!is_null($email_type)) {
			$params['email_type'] = $email_type;
		}
		if (!is_null($merge_fields)) {
			$params['merge_fields'] = $merge_fields;
		}
		if (!is_null($interests)) {
			$params['interests'] = $interests;
		}
		if (!is_null($language)) {
			$params['language'] = $language;
		}
		if (!is_null($vip)) {
			$params['vip'] = $vip;
		}
		if (!is_null($location)) {
			$params['location'] = $location;
		}
		if (!is_null($status_if_new)) {
			$params['status_if_new']= $status_if_new;
		}


		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}


	public function DELETE_list_members_instance ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function GET_lists_members_notes_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function POST_lists_members_notes_collection ($listid, $emailaddress, $note) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$params = array('note'=>$note);

		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}


	public function GET_lists_members_notes_instance ($listid, $emailaddress, $noteid) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/'.$noteid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}


	public function PATCH_lists_members_notes_instance ($listid, $emailaddress, $noteid, $note) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$params = array('note' => $note);

		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/'.$noteid);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}


	public function DELETE_lists_members_notes_instance ($listid, $emailaddress, $noteid) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/'.$noteid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_lists_merge_fields_collection ($listid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	// $listid, $name, & $type are required fields, others are optional.
	// pass $required & $visible as boolean
	// SCHEMA DESCRIBES $type AS STRING
	// $types array('text','number','address','phone','email','date','url','imageurl','radio','dropdown','checkboxes','birthday','zip');

	public function POST_lists_merge_fields_collection ($listid, $name, $type, $required, $default_value, $visible ) {

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

		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_merge_fields_instance ($listid, $mergeid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.$mergeid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//$listid, $name, & $type are required fields, others are optional.
	//If you are not passing any value then pass as NULL
	//pass $required & $visible as boolean
	//SCHEMA DESCRIBES $type AS STRING
	//$types array('text','number','address','phone','email','date','url','imageurl','radio','dropdown','checkboxes','birthday','zip');


	public function PATCH_lists_merge_fields_instance ($listid, $mergeid, $name, $type, $required, $default_value, $visible ) {

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

		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.$mergeid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_lists_merge_field_instance ($listid, $mergeid) {

		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.$mergeid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);

	}

	public function GET_lists_segments_collection ($listid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_lists_segments_collection ($listid, $name, $conditions = array()) {
		
		$params = array('name'=>$name);

		if (!is_null($conditions)) {
			$params['options'] = $conditions;
		}

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_lists_segments_instance ($listid, $segmentid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.$segmentid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_lists_segments_instance ($listid, $segmentid, $name, $conditions = NULL) {
		
		$params = array('name'=>$name);

		if (!is_null($conditions)) {
			$params['options'] = $conditions;
		}

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.$segmentid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function DELETE_lists_segments_instance ($listid, $segmentid) {
		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.$segmentid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);		
	}





	//REPORTS RESOURCES ---------------------------------------------------------------------------------------------------------------

	public function GET_reports_abuse_collection ($campaignid, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/abuse-reports/'.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_abuse_instance ($campaignid, $abuseid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/abuse-reports/'.$abuseid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_advice_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/advice/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_click_details_collection ($campaignid, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_click_details_instance ($campaignid, $linkid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$linkid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_click_details_members_collection ($campaignid, $urlid, $offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$urlid.'/members/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_click_details_members_instance ($campaignid, $urlid, $emailid, $offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$urlid.'/members/'.$emailid.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_collection ($offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_domain_performance_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/domain-performance/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_email_activity_collection ($campaignid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/email-activity/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_email_activity_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/email-activity/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_instance ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_locations_collections ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/locations/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_sent_to_collection ($campaignid, $offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/sent-to/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_sent_to_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/sent-to/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_unsubscribes_collection ($campaignid, $offset = 0, $count = 10, $filters = array()) {
		
		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/unsubscribed/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_unsubscribes_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/unsubscribed/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_eepurl ($campaignid) {
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/eepurl/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_reports_campaign_sub_reports ($campaignid) {
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/sub-reports/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//TEMPLATE FOLDERS RESOURCES ----------------------------------------------------------------------------------------------------------------

	public function GET_template_folders_collection () {
		$ch = curl_init($this->url.'/template-folders/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function POST_template_folders_collection ($foldername) {

		$params = array('name' => $foldername);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/template-folders/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);		
	}

	public function GET_template_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/template-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function PATCH_template_folders_instance ($folderid, $foldername) {

		$params = array('name' => $foldername);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/template-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);		
	}

	public function DELETE_template_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/template-folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//TEMPLATES RESOURCES -----------------------------------------------------------------------------------------------------------------------

	public function GET_templates_collection ($offset = 0, $count = 10, $filters = array()) {

		$filter_string = '';
		foreach($filters as $filter_key => $filter_value) {
			$encoded_value = urlencode($filter_value);
			$filter_string .= '&' . $filter_key . '=' . $encoded_value;
		}
		
		$ch = curl_init($this->url.'/templates/'.'?offset='.$offset.'&count='.$count.$filter_string);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_templates_instance ($templateid) {
		
		$ch = curl_init($this->url.'/templates/'.$templateid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//CURRENTLY NOT AVAILABLE - as of 07-04-2015

	public function PATCH_templates_instance ($templateid, $name) {

		$params = array('name' => $name);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/templates/'.$templateid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	//CURRENTLY NOT AVAILABLE - as of 07-04-2015

	public function DELETE_templates_instance ($templateid) {

		$ch = curl_init($this->url.'/templates/'.$templateid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}

	public function GET_template_instance_default_content ($templateid) {
		$ch = curl_init($this->url.'/templates/'.$templateid.'/default-content/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->response = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->response, false);
	}
}

/* 

THE CODE WITHIN THIS FILE WAS WRITTEN BY JOHN HUTCHESON 

SPECIAL SHOUT-OUTS!!!! ---------------------------------> 

NATE RANSON:

FOR ANSWERING ALL OF MY NOOB QUESTIONS, AND GUIDING A YOUNG JEDI ON THE PATH

MICHAEL GABRIEL:

FOR *ALL* THE MANAGERIAL SUPPORT

NATHAN SHE & ADAM THIGPEN:

FOR THEIR EXTENSIVE TESTING AND QA SKILLZ

*/


?>