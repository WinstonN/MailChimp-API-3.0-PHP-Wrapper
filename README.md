#MailChimp PHP Wrapper

This is a PHP wrapper for [version 3.0 of MailChimp's API](https://kb.mailchimp.com/api)

##Example
This is an example of instantiation:

	$some_var = new Mailchimp('APIKEY');

##Example 2
This is an example of how to call a function

	try {

		$some_var->VERB_Some_Resource(argument 1, argument 2, etc.);
		var_dump($some_var->return);

	} catch (exception $e) {

	} 
