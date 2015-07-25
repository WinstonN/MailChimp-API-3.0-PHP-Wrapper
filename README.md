#MailChimp PHP Wrapper

This is a PHP wrapper for [version 3.0 of MailChimp's API](https://kb.mailchimp.com/api)

##Example
This is an example of instantiation:

	$some_var = new Mailchimp('APIKEY');

##Example 2
This is an example of how to call a function

	try {

		$some_var->VERB_some_resource(argument 1, argument 2, etc.);
		var_dump($some_var->return);

	} catch (exception $e) {

	} 

##Note

Each function now returns decoded json. However the non-decoded MailChimp response can still be found in the $response class property. If you would like to see decoded function return, then try:

	try {

		var-dump($some_var->VERB_some_resource(argument 1, argument 2, etc.));

	} catch (exception $e) {

	}
