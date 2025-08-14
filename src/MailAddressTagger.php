<?php

namespace MailAddressTagger;

/**
 * MailAddressTagger class
 *
 * This class generates tagged email addresses based on a base address or a provided input address
 * It can be used to create unique email addresses for tracking purposes
 */
class MailAddressTagger {
	private string|array $inputAddress;
	private string $outputAddress;
	private array $config;
	private TagGeneratorInterface $tagGenerator;

	/**
	 * Constructor for the MailAddressTagger class
	 *
	 * @param array $config Configuration array for the MailAddressTagger
	 * @param string|array $config['base_address'] The default email address to use if no specific address is requested
	 * @param string $config['fallback_address'] Fallback email address to use if something goes wrong - can be pre-tagged
	 * @param TagGeneratorInterface $config['tag_generator'] Tag generator instance
	 */
	public function __construct($config) {
		$this->config = [ // Default config
			'base_address' => 'nobody@example.com', // Default email address to use, if no specific address is requested
			'base_address_static' => false, // If true, the base_address will be chosen randomly once and then used for all subsequent calls, if false, the base_address will be chosen randomly for each call to getTaggedAddress (Once per Constructor vs Once per getTaggedAddress)
			'fallback_address' => 'nobody+fallbacktag@example.com', // Fallback email address to use if something goes wrong - can be pre-tagged
			'tag_generator' => new \MailAddressTagger\RandomHexTagGenerator(4)
		];

		$this->config = array_merge($this->config, $config); // Merge user config onto default config

		if(gettype($this->config['base_address']) == 'array' && $this->config['base_address_static'] ?? false) {
			$this->inputAddress = $this->config['base_address'][array_rand($this->config['base_address'])];
		} else {
			$this->inputAddress = $this->config['base_address'];
		}

		$this->outputAddress = $this->config['fallback_address']; // We'll use this address if something goes wrong
		$this->tagGenerator = $this->config['tag_generator'];
	}

	/**
	 * Generates a tagged email address based on the input address or the default base address
	 * If an input address is provided, it will be used instead of the default base address
	 *
	 * @param string|array|null $inputAddress The email address to tag. If null, the base address will be used
	 * @return string The tagged email address
	 */
	public function getTaggedAddress($inputAddress = null): string {
		$inputAddress = $inputAddress ?? $this->inputAddress; // Use the provided input address or the default base address

		if(gettype($inputAddress) == 'array') {
			$inputAddress = $inputAddress[array_rand($inputAddress)];
		}

		$tag = $this->tagGenerator->generateTag();
		$explodedAddress = explode('@', $inputAddress);
		$inputAddressName = $explodedAddress[0];
		$inputAddressDomain = $explodedAddress[sizeof($explodedAddress) - 1];

		$this->outputAddress = $inputAddressName . '+' . $tag . '@' . $inputAddressDomain;

		return $this->outputAddress;
	}
}
