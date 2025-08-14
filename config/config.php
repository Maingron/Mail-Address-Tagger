<?php
// Example config - will get merged with the default config in MailAddressTagger.php
// You don't need to use a config file, as long as you pass some config variable to the MailAddressTagger constructor
return [
	'base_address' => 'contact@maingron.com',
	'fallback_address' => 'contact+fallback@maingron.com',
	'tag_generator' => new \MailAddressTagger\RandomStringTagGenerator(10, '/^[a-zA-Z0-9].*+$/')
];
