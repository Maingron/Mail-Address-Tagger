<?php
use PHPUnit\Framework\TestCase;
use MailAddressTagger\RandomHexTagGenerator;

class RandomHexTagGeneratorTest extends TestCase {
	private int $generatorLength;
	private RandomHexTagGenerator $generator;

	protected function setUp(): void {
		$this->generatorLength = 8;
		$this->generator = new RandomHexTagGenerator($this->generatorLength);
	}
	
	public function testGeneratesCorrectLengthAndFormat() {
		for ($i = 0; $i < 100; $i++) {
			$tag = $this->generator->generateTag();
			$this->assertMatchesRegularExpression('/^[a-f0-9]{'.$this->generatorLength.'}$/', $tag, 'Tag should be '.$this->generatorLength.' lowercase hex chars');
		}
	}

	public function testTagsAreRandomAndUnique() {
		$generator = new RandomHexTagGenerator(8);
		$tags = [];
		for ($i = 0; $i < 200; $i++) {
			$tags[] = $this->generator->generateTag();
		}
		$this->assertCount(count(array_unique($tags)), $tags, 'Tags should be unique');
	}
}
