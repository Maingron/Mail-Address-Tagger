<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP Mail Address Tagger Example by Maingron</title>
		<style>
			html,
			body {
				margin: 0;
				color-scheme: light dark;
				font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			}

			body {
				padding: .5em 1em;
				box-sizing: border-box;
				width: max(80%, 600px);
				max-width: 100vw;
				margin: 0 auto;
			}
		</style>

	</head>
	<body>
		<h1>PHP Mail Address Tagger Example</h1>

		<h2>Example Addresses</h2>

		<ul>
			<?php
				require_once(__DIR__ . '/vendor/autoload.php');
				if(file_exists(__DIR__ . '/config/config.php')) {
					$config = require_once(__DIR__ . '/config/config.php');
				}
				if(empty($config)) {
					$config = [];
				}

				use MailAddressTagger\MailAddressTagger;

				$tagger = new MailAddressTagger($config);

				for($i = 0; $i < 5; $i++) {
					echo "<li>";
					echo $tagger->getTaggedAddress();
					echo "</li>";
				}

			?>
		</ul>

		<footer>
			<hr>
			<p>
				<a href="https://github.com/Maingron/PHP-Mail-Address-Tagger">GitHub</a>
				|
				<span>Mail Address Tagger: Example</span>
				|
				<span>A Maingron Project</span>
			</p>
		</footer>
		
	</body>
</html>
