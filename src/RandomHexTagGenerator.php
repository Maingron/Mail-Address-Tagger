<?php
namespace MailAddressTagger;

/**
 * TagGeneratorInterface interface
 */
class RandomHexTagGenerator implements TagGeneratorInterface {
	private int $length;

	public function __construct(int $length = 4) {
		$this->length = $length / 2;
	}

	/**
	 * Generates a random hexadecimal tag of the specified length
	 *
	 * @return string The generated tag
	 */
	public function generateTag(): string {
		return bin2hex(random_bytes((int) $this->length));
	}
}
