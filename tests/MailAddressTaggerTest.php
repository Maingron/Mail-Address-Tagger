<?php
use PHPUnit\Framework\TestCase;
use MailAddressTagger\MailAddressTagger;

class MailAddressTaggerTest extends TestCase {
	private array $config;
	private int $tagLength;

	protected function setUp(): void {
		$this->tagLength = 8;
		$this->config = [
			'base_address' => 'test@test.com',
			'fallback_address' => 'fallback-probably_error@test.com',
			'tag_generator' => new \MailAddressTagger\RandomHexTagGenerator($this->tagLength)
		];
	}

	public function testGenerateTaggedAddress() {
		$tagger = new MailAddressTagger($this->config);
		
		// Generate multiple addresses to ensure randomness
		for($i = 0; $i < 200; $i++) {
			$emailGenAll[] = $tagger->getTaggedAddress();
		}

		foreach($emailGenAll as $emailGen) {
			$this->assertNotEquals($tagger->getTaggedAddress(), $emailGen, 'Email should not be the identical to base address');
			$this->assertMatchesRegularExpression('/^test\+([a-f0-9]{'.$this->tagLength.'})@test\.com$/', $emailGen, 'Email should be tagged with a random hex string');
		}


		// Check for duplicates
		$this->assertCount(count(array_unique($emailGenAll)), $emailGenAll, 'Generated email addresses should be unique');

	}

	public function testGenerateTaggedAddressWithInput() {
		$tagger = new MailAddressTagger([
			'base_address' => 'something@nowhere.at',
			'fallback_address' => 'fallback@nowhere.it',
			'tag_generator' => $this->config['tag_generator']
		]);

		$emailGen = $tagger->getTaggedAddress('address1@domain.tld');

		$this->assertMatchesRegularExpression('/^address1\+([a-f0-9]{'.$this->tagLength.'})@domain\.tld$/', $emailGen, 'Email should be tagged with a random hex string');
		$this->assertNotEquals($tagger->getTaggedAddress(), $emailGen, 'Email should not be the identical to base address');
	}
}
