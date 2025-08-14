<?php
// Example config - will get merged with the default config in MailAddressTagger.php
// You don't need to use a config file, as long as you pass some config variable to the MailAddressTagger constructor
return [
	'base_address' => $_SERVER['SERVER_ADMIN'] ?? 'nobody@example.com',
	'base_address_static' => false, // If true, the base_address will be chosen randomly once and then used for all subsequent calls, if false, the base_address will be chosen randomly for each call to getTaggedAddress (Once per Constructor vs Once per getTaggedAddress)
	'fallback_address' => $_SERVER['SERVER_ADMIN'] ?? 'admin+fallback@example.com',
	'tag_generator' => new \MailAddressTagger\RandomStringTagGenerator(4, '/^[a-zA-Z0-9].*+$/'),
	'validate_email' => false // If true, the email address will be validated before being tagged, else fallback address will be used
];
