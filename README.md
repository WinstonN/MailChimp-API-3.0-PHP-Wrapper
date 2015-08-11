#MailChimp PHP Wrapper

This is a PHP wrapper for [version 3.0 of MailChimp's API](https://kb.mailchimp.com/api)

##Example
This is an example of instantiation:

	$some_var = new mailchimp('APIKEY');

##Example 2
This is an example of how to call a function

	try {

		$some_var->VERB_some_resource(argument 1, argument 2, etc.);
		var_dump($some_var->return);

	} catch (exception $e) {

	} 

##Example 3

Each function now returns decoded json. However the non-decoded MailChimp response can still be found in the $response class property. If you would like to see decoded function return, then try:

	try {

		var-dump($some_var->VERB_some_resource(argument 1, argument 2, etc.));

	} catch (exception $e) {

	}

##Pagination

Some functions can paginate their returns using the $offset and $count arguments. Not providing a value for these arguments will default these arguments to $offset=0 and $count=10. 

##Filters

Some functions can have their return values filtered. The endpoints that support filters and their associated filter parameters can be found in filters.txt. The filter parameters have been included as arguments for each function and should be passed as an associative array (see below).

	array('filter_key'=>'filter_value')

##Notes

- Functions with endpoints that require a member_id use the $email_address argument to generate this ID (MD5 hash of lowercase email address). All that is needed is to pass the email address as a string.

- If you do not wish to update a field while PATCHing pass it's argument as (null). 

- Timestamp format: "YYYY/MM/DD HH:MM:SS"




