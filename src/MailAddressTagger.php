<?php

namespace MailAddressTagger;

/**
 * MailAddressTagger class
 *
 * This class generates tagged email addresses based on a base address or a provided input address
 * It can be used to create unique email addresses for tracking purposes
 */
class MailAddressTagger {
	private string $inputAddress;
	private string $outputAddress;
	private array $config;
	private TagGeneratorInterface $tagGenerator;

	/**
	 * Constructor for the MailAddressTagger class
	 *
	 * @param array $config Configuration array for the MailAddressTagger
	 * @param string $config['base_address'] The default email address to use if no specific address is requested
	 * @param string $config['fallback_address'] Fallback email address to use if something goes wrong - can be pre-tagged
	 * @param TagGeneratorInterface $config['tag_generator'] Tag generator instance
	 */
	public function __construct($config) {
		$this->config = [ // Default config
			'base_address' => 'nobody@example.com', // Default email address to use, if no specific address is requested
			'fallback_address' => 'nobody+fallbacktag@example.com', // Fallback email address to use if something goes wrong - can be pre-tagged
			'tag_generator' => new \MailAddressTagger\RandomHexTagGenerator(4)
		];

		$this->config = array_merge($this->config, $config); // Merge user config onto default config

		$this->inputAddress = $this->config['base_address']; // base address aka default address if no specific address gets requested in content
		$this->outputAddress = $this->config['fallback_address']; // We'll use this address if something goes wrong
		$this->tagGenerator = $this->config['tag_generator'];
	}

	/**
	 * Generates a tagged email address based on the input address or the default base address
	 * If an input address is provided, it will be used instead of the default base address
	 *
	 * @param string|null $inputAddress The email address to tag. If null, the base address will be used
	 * @return string The tagged email address
	 */
	public function getTaggedAddress($inputAddress = null): string {
		if($inputAddress) {
			$this->inputAddress = $inputAddress;
		}
		$tag = $this->tagGenerator->generateTag();
		$explodedAddress = explode('@', $this->inputAddress);
		$inputAddressName = $explodedAddress[0];
		$inputAddressDomain = $explodedAddress[sizeof($explodedAddress) - 1];

		$this->outputAddress = $inputAddressName . '+' . $tag . '@' . $inputAddressDomain;

		return $this->outputAddress;
	}
}
