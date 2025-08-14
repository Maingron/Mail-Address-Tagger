<?php
use PHPUnit\Framework\TestCase;
use MailAddressTagger\RandomStringTagGenerator;

class RandomStringTagGeneratorTest extends TestCase {
	#[\PHPUnit\Framework\Attributes\DataProvider('generatorConfigProvider')]
	public function testGeneratesCorrectLengthAndFormat(int $length, string $stringSet) {
		$generator = new RandomStringTagGenerator($length, '/^['.$stringSet.']+$/');
		for ($i = 0; $i < 100; $i++) {
			$tag = $generator->generateTag();
			$this->assertMatchesRegularExpression('/^['.$stringSet.']{'.$length.'}$/', $tag, 'Tag should be '.$length.' chars from set: '. $stringSet);
		}
	}

	#[\PHPUnit\Framework\Attributes\DataProvider('generatorConfigProvider')]
	public function testTagsAreRandomAndUnique(int $length, string $stringSet) {
		$generator = new RandomStringTagGenerator($length, '/^['.$stringSet.']+$/');
		$tags = [];
		ceil($testLength = $length * 2);
		if($length < 3) {
			$testLength = $length;
		}
		for ($i = 0; $i < $testLength; $i++) {
			$tags[] = $generator->generateTag();
		}
		$this->assertCount(count(array_unique($tags)), $tags, 'Tags should be unique');
	}

	public static function generatorConfigProvider(): array {
		return [
			[8, 'maybe=suc325f0l!'],
			[2, 'a-zA-Z0-9'],
			[1, 'aAbBcCdDeE'],
			[100, '0-9'],
			[20, 'a-z=+'],
		];
	}
}
