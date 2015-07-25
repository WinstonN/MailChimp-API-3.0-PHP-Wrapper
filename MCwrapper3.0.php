<?php

//ALL RESOURCES CAN BE FOUND UNDER THE 'mailchimp' CLASS. 
//TO MAKE A CALL TO A RESOURCE YOU WILL WANT TO CALL A FUNCTION BEGGINNNING WITH THE HTTP METHOD FOLLOWED BY THE RESOURCE.
//EXAMPLE: GET REQUEST TO LISTS COLLECTION ENDPOINT WOULD BE REFERENCED "GET_lists_collection"
//RESPONSE WILL BE STORED IN CLASS PROPERTY: $return
//APIKEY CAN BE FOUND/GENERATED IN YOUR MAILCHIMP ACCOUNT BY NAVIGATING ACCOUNT > EXTRAS > APIKEYS
//PROVIDE THE ENTIRE APIKEY AS A STRING WHEN INSTANTIATING 'mailchimp' CLASS

//SOME FUNCTIONS CAN USE THE $offset AND $count ARGUMENTS TO PAGINATE THE RETURN VALUES
//FOR THESE FUNTCIONS NOT PROVIDING A VALUE FOR THESE ARGUMRNTS WILL RESULT IN THEM DEFAULTING to: "$offset=0" & "$count=10"

//FOR ENDPOINTS THAT REQUIRE $member_id THE FUNCTION SHOULD PREP AND HASH THE $emailaddress FOR YOU
//EVEN IF IT CONTAINS UPPERCASE LETTERS
//HOWEVER IT IS STILL BEST PRACTICE TO PASS THE ADDRESS AS A COMPLETELY LOWERCASE STRING

//USE POST_pause_automated_email & POST_start_automated_email TO PAUSE AND START AUTOMATION EMAILS.

class mailchimp {

	public $auth;
	public $url;
	public $exp_apikey;

	public $return;
		
	public function __construct ($apikey) {
		$this->exp_apikey = explode('-', $apikey);
		$this->auth = array('Authorization: aipkey '.$this->exp_apikey[0].'-'.$this->exp_apikey[1]); 
	    $this->url = "Https://".$this->exp_apikey[1].".api.mailchimp.com/3.0";
	    return $this->auth;
	    return $this->url;

	} 






	//AUTHORIZED APPS RESOURCES --------------------------------------------------------------------------------------------------------------------

	public function GET_authorized_apps_collection ($offset = 0, $count = 10) {

		$ch = curl_init($this->url.'/authorized-apps/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_authorized_apps_instance ($appid) {

		$ch = curl_init($this->url.'/authorized-apps/'.$appid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}






	//AUTOMATIONS RESOURCES ------------------------------------------------------------------------------------------------------------------------

	public function GET_automations_collection ($offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/automations/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_automations_emails_collection ($workflowid, $offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_automations_emails_instance ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}	

	//Calling this function will pause an email in an automation workflow

	public function POST_pause_automated_email ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/actions/pause');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//Calling this function will unpause an email in an automation workflow

	public function POST_start_automated_email ($workflowid, $emailid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/actions/start');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_automations_emails_queue_collection ($workflowid, $emailid, $offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//$emailaddress is the email address (present on the list already) that you would like to queue to recieve the automation
	
	public function POST_automations_emails_queue_collection ($workflowid, $emailid, $emailaddress) {

		$params = array('email_address' => $emailaddress);

		$payload = json_encode($params);

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//The member_id in the endpoint is MD5 hash of the lowercase email address
	//Function will hash address for you, provide only address as a string for $emailaddress

	public function GET_automations_emails_queue_instance ($workflowid, $emailid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/automations/'.$workflowid.'/emails/'.$emailid.'/queue/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_automations_instance ($workflowid) {
		$ch = curl_init($this->url.'/automations/'.$workflowid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}





	

	//CAMPAIGNS RESOURCES ----------------------------------------------------------------------------------------------------------------------------

	public function GET_campaigns_collection ($offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/campaigns/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch); 
		return json_decode($this->return);
	}

	public function GET_campaigns_feedback_collection ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_campaigns_feedback_instance ($campaignid, $feedbackid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//$message is the string you would like to pass as a campaign comment

	public function PATCH_campaigns_feedback_instance ($campaignid, $feedbackid, $message) {

		$newmessage = array('message' => $message);

		$payload = json_encode($newmessage);
		
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//DELETE functionality for this endpoint not yet available as of 07-04-2015

	public function DELETE_campaigns_feedback_instance ($campaignid, $feedbackid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid.'/feedback/'.$feedbackid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_campaigns_instance ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}


	public function DELETE_campaigns_instance ($campaignid) {
		$ch = curl_init($this->url.'/campaigns/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}






	//CONVERSATIONS RESOURCES ----------------------------------------------------------------------------------------------------------------------

	public function GET_conversations_collection ($offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/conversations/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_conversations_instance ($conversationid) {
		$ch = curl_init($this->url.'/conversations/'.$conversationid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_conversations_messages_collection ($conversationid) {
		$ch = curl_init($this->url.'/conversations/'.$conversationid.'/messages/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_conversations_messages_instance ($conversationid, $messageid) {
		$ch = curl_init($this->url.'/campaigns/'.$conversationid.'/messages/'.$messageid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}






	//FILE MANAGER RESOURCES --------------------------------------------------------------------------------------------------------------


	public function GET_file_manager_files_collection ($offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/file-manager/files/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_file_manager_files_instance ($fileid) {
		$ch = curl_init($this->url.'/file-manager/files/'.$fileid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function DELETE_file_manager_files_instance ($fileid) {
		$ch = curl_init($this->url.'/file-manager/files/'.$fileid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_file_manager_folders_collection ($offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/file-manager/folders/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_file_manager_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/file-manager/folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function DELETE_file_manager_folders_instance ($folderid) {
		$ch = curl_init($this->url.'/file-manager/folders/'.$folderid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}






	//LISTS RESOURCES -----------------------------------------------------------------------------------------------------------------------

	public function GET_list_abuse_collection ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/abuse-reports/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_list_abuse_instance ($listid, $reportid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/abuse-reports/'.$reportid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_activity_collection ($listid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/activity/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_clients_collection ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/clients/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_collection ($offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function POST_lists_collection ($name, 
										   $reminder, 
							  			   //$emailtype is boolean, still trying to figure out what it's value means lol
							  			   $emailtype, 
							  			   $company, 
							  			   //These address fields will be placed into an array together for encoding
							  			   $address_street,
							  			   $address_street2,
							  			   $address_city,
							  			   $address_state,
							  			   $address_zip,
							  			   //$country = 2 character ISO3166 code. Defaults to 'US'.
							  			   $country,
							  			   //These are your campaign defaults and will also be placed into an array for encoding
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function GET_lists_growth_history_collection ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/growth-history/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//$month should be passed as a string formatted: "YYYY-MM"

	public function GET_lists_growth_history_instance ($listid, $month) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/growth-history/'.$month);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_instance ($listid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//PASS ANY FIELDS YOU DO NOT WISH TO UPDATE AS 'NULL'
	//PASSING FIELDS WITH EMPTY VALUES OR EMPTY STRINGS MAY RESULT IN OVERWRITING LIST DATA

	public function PATCH_lists_instance  ($listid, 
							   			   $name, 
							   			   $reminder, 
							   			   //$emailtype is boolean, still trying to figure out what it's value means lol
							   			   $emailtype, 
							   			   $company, 
							     		   //These address fields will be placed into an array together for encoding
							    		   $address_street,
							   		   	   $address_street2,
							    		   $address_city,
							   			   $address_state,
							   			   $address_zip,
							  			   //$country = 2 character ISO3166 code. Defaults to 'US'.
							  			   $country,
							 		       //These are your campaign defaults and will also be placed into an array for encoding
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function DELETE_lists_instance ($listid) {

		$ch = curl_init($this->url.'/lists/'.$listid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_interests_categories_collection ($listid,  $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function GET_lists_interests_categories_instance ($listid, $category_id) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_list_interests_collection ($listid, $category_id, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function POST_list_interests_collection ($listid, $category_id, $name) {

		$params = array('name' => $name);

		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function GET_lists_interests_instance ($listid, $category_id, $groupid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests/'.$groupid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function DELETE_lists_interests_instance ($listid, $category_id, $interestid) {

		$ch = curl_init($this->url.'/lists/'.$listid.'/interest-categories/'.$category_id.'/interests/'.$interestid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//The member_id in the endpoint is MD5 hash of email address
	//Function will hash address for you, provide only address as a string for $emailaddress

	public function GET_lists_members_activity_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/activity/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_list_members_collection ($listid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	//	******************** PLEASE READ FOR POSTING TO THIS ENDPOINT ********************************


	//$mergefields and $interests are both expecting objects
	//If you do not wish to pass one of these pass as NULL
	//the key to each of the $interests object's properties is the interest id
	//these key's values are either true or false
	//so $interest = array('interest_id' => true/false)

	//please read schema for expected merge fields
	//https://us9.api.mailchimp.com/schema/3.0/Lists/Members/Instance.json?_ga=1.91680986.1112410188.1433351910

	public function POST_list_members_collecton ($listid, $emailaddress, $status, $mergefields, $interests) {

		$params = array('email_address' => $emailaddress,
						'status' => $status,
						);

		if (!is_null($mergefields)) {
			$params['merge_fields'] = $mergefields;
		}

		if (!is_null($interests)) {
			$params['interests'] = $interests;
		}


		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function GET_lists_members_goals_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/goals');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function GET_list_members_instance ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function PATCH_lists_members_instance ($listid, $emailaddress, $status, $mergefields, $interests) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$params = array('email_address' => $emailaddress,
						'status' => $status,
						);

		if (!is_null($mergefields)) {
			$params['merge_fields'] = $mergefields;
		}

		if (!is_null($interests)) {
			$params['interests'] = $interests;
		}


		$payload = json_encode($params);

		$ch= curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function DELETE_list_members_instance ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function GET_lists_members_notes_collection ($listid, $emailaddress) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function GET_lists_members_notes_instance ($listid, $emailaddress, $noteid) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/'.$noteid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	//function will create $member_id from $emailaddress, pass $emailaddress as a string

	public function DELETE_lists_members_notes_instance ($listid, $emailaddress, $noteid) {

		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/lists/'.$listid.'/members/'.$member_id.'/notes/'.$noteid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

	}

	public function GET_lists_merge_fields_collection ($listid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	// $listid, $name, & $type are required fields, others are optional.
	// If you are not passing any value then pass as NULL
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_merge_fields_instance ($listid, $mergeid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/merge-fields/'.$mergeid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_segments_collection ($listid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//$type CAN BE 'static, saved, fuzzy'
	//$conditions is expecting the "options" object described here: https://us9.api.mailchimp.com/schema/3.0/Lists/Segments/Instance.json
	//Pass as NULL if not passing any value

	public function POST_lists_segments_collection ($listid, $name, $type, $conditions) {
		
		$params = array('name'=>$name,'type'=>$type);

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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_lists_segments_instance ($listid, $segmentid) {
		
		$ch = curl_init($this->url.'/lists/'.$listid.'/segments/'.$segmentid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}







	//REPORTS RESOURCES ---------------------------------------------------------------------------------------------------------------

	public function GET_reports_abuse_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/abuse-reports/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_abuse_instance ($campaignid, $abuseid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/abuse-reports/'.$abuseid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_advice_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/advice/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_click_details_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_click_details_instance ($campaignid, $linkid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$linkid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_click_details_members_collection ($campaignid, $urlid, $offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$urlid.'/members/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_click_details_members_instance ($campaignid, $urlid, $emailid, $offset = 0, $count = 10) {
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/click-details/'.$urlid.'/members/'.$emailid.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}



	public function GET_reports_collection ($offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/reports/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_domain_performance_collection ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/domain-performance/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_email_activity_collection ($campaignid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/email-activity/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//Function will create $member_id from email address. Pass $emailaddress as a string.

	public function GET_reports_email_activity_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/email-activity/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_instance ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_locations_collections ($campaignid) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/locations/');
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_sent_to_collection ($campaignid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/sent-to/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//function will creat $member_id from email address. Pass email address as a string.

	public function GET_reports_sent_to_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/sent-to/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_reports_unsubscribes_collection ($campaignid, $offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/reports/'.$campaignid.'/unsubscribed/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//Function will create $member_id from email address. Pass email address as a string.

	public function GET_reports_unsubscribes_instance ($campaignid, $emailaddress) {
		
		$hashprep = strtolower($emailaddress);
		$member_id = md5($hashprep);

		$ch = curl_init($this->url.'/reports/'.$campaignid.'/unsubscribed/'.$member_id);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}







	//TEMPLATES RESOURCES -----------------------------------------------------------------------------------------------------------------------

	public function GET_templates_collection ($offset = 0, $count = 10) {
		
		$ch = curl_init($this->url.'/templates/'.'?offset='.$offset.'&count='.$count);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	public function GET_templates_instance ($templateid) {
		
		$ch = curl_init($this->url.'/templates/'.$templateid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
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
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);
	}

	//CURRENTLY NOT AVAILABLE - as of 07-04-2015

	public function DELETE_templates_instance ($templateid) {

		$ch = curl_init($this->url.'/templates/'.$templateid);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->return = curl_exec($ch);
		curl_close($ch);
		return json_decode($this->return, false);

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