<?php
namespace MailAddressTagger;

/**
 * TagGeneratorInterface interface
 */
class RandomStringTagGenerator implements TagGeneratorInterface {
	private int $length;
	private $regexPattern;
	private string $genAllowed;

	public function __construct(int $length = 4, ?string $regexPattern = null) {
		$this->length = $length;
		$this->regexPattern = $regexPattern ?? '/^[a-zA-Z0-9]+$/';
		$this->genAllowed = '';
		$allChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=.-:_!@#$%^&*()_+[]{}|;:,.<>?';

		foreach(str_split($allChars) as $char) {
			if(preg_match($this->regexPattern, $char)) {
				$this->genAllowed .= $char;
			}
		}

		if(empty($this->genAllowed)) {
			throw new \InvalidArgumentException('No characters available for tag generation. Please check your regex pattern.');
		}
	}

	/**
	 * Generates a random tag based on the user-defined regex pattern and length
	 *
	 * @return string The generated tag
	 */
	public function generateTag(): string {
		$tag = '';
		for($i = 0; $i < $this->length; $i++) {
			$tag .= $this->genAllowed[random_int(0, strlen($this->genAllowed) - 1)];
		}
		if(!preg_match($this->regexPattern, $tag)) {
			return $this->generateTag();
		}
		return $tag;
	}
}
