<?php
use PHPUnit\Framework\TestCase;
use MailAddressTagger\RandomStringTagGenerator;

class RandomStringTagGeneratorTest extends TestCase {
	private int $generatorLength;
	private string $stringSet;
	private RandomStringTagGenerator $generator;

	protected function setUp(): void {
		$this->generatorLength = 8;
		$this->stringSet = 'maybe=suc325f0l!';
		$this->generator = new RandomStringTagGenerator($this->generatorLength, '/^['.$this->stringSet.']+$/');
	}

	public function testGeneratesCorrectLengthAndFormat() {
		$generator = $this->generator;
		for ($i = 0; $i < 100; $i++) {
			$tag = $generator->generateTag();
			$this->assertMatchesRegularExpression('/^['.$this->stringSet.']{'.$this->generatorLength.'}$/', $tag, 'Tag should be '.$this->generatorLength.' chars from set: '. $this->stringSet);
		}
	}

	public function testTagsAreRandomAndUnique() {
		$generator = $this->generator;
		$tags = [];
		for ($i = 0; $i < 200; $i++) {
			$tags[] = $generator->generateTag();
		}
		$this->assertCount(count(array_unique($tags)), $tags, 'Tags should be unique');
	}
}
