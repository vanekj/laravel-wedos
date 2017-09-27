<?php

ob_start();

/**
 * Get root folder path
 * @return string
 */
function getRootFolderPath(): string {
	return __DIR__;
}

/**
 * Get "public" folder path
 * @return string
 */
function getPublicFolderPath(): string {
	return getRootFolderPath() . '/public';
}

/**
 * Create .htaccess file in root folder with required options
 * @return void
 */
function createRootHtaccess() {
	$file = getRootFolderPath() . '/.htaccess';

	$content = "RewriteEngine on\n";
	$content .= "RewriteCond %{REQUEST_URI} !^public\n";
	$content .= "RewriteRule ^(.*)$ public/$1 [L]\n";

	file_put_contents($file, $content);
	chmod($file, 0644);
}

/**
 * Update .htaccess file in "public" folder so not working
 * options are removed for proper functionality
 * @return void
 */
function updatePublicHtaccess() {
	$file = getPublicFolderPath() . '/.htaccess';

	$content = file_get_contents($file);
	$content = preg_replace('/<IfModule mod_negotiation\.c>\s+Options -MultiViews -Indexes\s+<\/IfModule>\s+/', '', $content);

	file_put_contents($file, $content);
	chmod($file, 0644);
}

/**
 * Get all options from "/config/app.php", that requires
 * .env config file values and should be rewritten
 * @return array
 */
function getAppConfigOptions(): array {
	$file = getRootFolderPath() . '/config/app.php';

	if (file_exists($file)) {
		$regex = '/(?\'match\'env\(\'(?\'key\'[A-Z_]+)\'(?:,\s(?\'value\'.+))?\))/';

		$content = file_get_contents($file);
		preg_match_all($regex, $content, $content_matches, PREG_SET_ORDER, 0);

		return $content_matches;
	}
}

/**
 * Get content in "/.env" file
 * @return string
 */
function getEnvContent(): string {
	$file = getRootFolderPath() . '/.env';

	if (file_exists($file)) {
		return file_get_contents($file);
	} else {
		return '';
	}
}

/**
 * Get "/.env" options as an array
 * @return array
 */
function getEnvOptions(): array {
	$content_env = getEnvContent();

	if (count($content_env) > 0) {
		$content_app_options = getAppConfigOptions();

		$option_keys = '';
		foreach ($content_app_options as $option):
			$option_keys .= $option['key'] . '|';
		endforeach;
		$option_keys = substr($option_keys, 0, -1);

		preg_match_all("/^(?'key'(?:$option_keys))=(?'value'.+)$/m", $content_env, $content_env_options, PREG_SET_ORDER, 0);

		return $content_env_options;
	} else {
		return [];
	}
}

/**
 * Update "/config/app.php" file so it's not using env()
 * function to read data from .env file which does't work
 * @return void
 */
function updateAppConfig(array $post) {
	$file = getRootFolderPath() . '/config/app.php';

	if (file_exists($file)) {
		$content = file_get_contents($file);

		foreach($post as $key => $value):
			if ($key !== 'submit') {
				if (!is_numeric($value) && !($value === 'true' || $value === 'false')) {
					$value = "'$value'";
				}

				$content = preg_replace("/env\('$key'(?:,\s.*)?\)/", $value, $content);
			}
		endforeach;

		file_put_contents($file, $content);
		chmod($file, 0644);
	}
}

/**
 * Remove unwanted files and deactivate this script
 * with some proper chmod settings
 * @return void
 */
function removeFiles() {
	unlink(getRootFolderPath() . '/.env');
	unlink(getRootFolderPath() . '/.env.example');

	chmod(getRootFolderPath() . '/wedos.php', 0000);
}

/**
 * Reload the website when the process is completed
 * @return void
 */
function reload() {
	$scheme = $_SERVER['REQUEST_SCHEME'];
	$name = $_SERVER['SERVER_NAME'];

	header("Location: $scheme://$name/");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	// Create root .htaccess file
	createRootHtaccess();

	// Update "public" .htaccess file
	updatePublicHtaccess();

	// Update config file
	updateAppConfig($_POST);

	// Remove files
	removeFiles();

	// Reload to see the laravel start screen
	reload();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>Laravel - Wedos installation</title>
	<style>
		* { box-sizing: border-box; }
		html, body { margin: 0; padding: 0; }
		body { font-size: 14px; line-height: 1.5 }

		body, input, select, textarea { font-family: monospace; }
		.container { margin: 10px auto 0 auto; padding: 0 15px; width: 520px; }
		.header { padding-bottom: 20px; }
		.footer { margin: 20px 0 0 0; text-align: center; }

		table { width: 100%; border-collapse: collapse; }
		td { padding: 2px 5px; }

		.form-item.-input, .form-item input { width: 100%; }
		.form-item.-submit { padding-top: 15px; }
	</style>
</head>
<body>
	<div class="container">
		<?php if (count(getEnvOptions()) > 0): ?>
			<form action="" method="POST">
				<table>
					<tbody>
						<tr>
							<td colspan="2" class="header">
								<strong>"/.env" values that would be replaced in config file.</strong><br />
								<small>You can change these values if needed.</small>
							</td>
						</tr>

						<?php foreach (getEnvOptions() as $option): ?>
						<tr>
							<td valign="middle" class="form-item -label">
								<label for="<?=$option['key']?>"><?=$option['key']?></label>
							</td>
							<td valign="middle" class="form-item -input">
								<input type="text" name="<?=$option['key']?>" id="<?=$option['key']?>" value="<?=$option['value']?>" />
							</td>
						</tr>
						<?php endforeach; ?>

						<tr>
							<td class="form-item -submit" colspan="2" align="center">
								<input class="submit" type="submit" name="submit" value="Start" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		<?php else: ?>
			<p>Error, please make sure you have a fresh Laravel installation and try again.</p>
		<?php endif; ?>

		<div class="footer">
			<hr />
			<a href="https://github.com/vanekj/laravel-wedos/issues" target="_blank" title="Projects GitHub page">Report an issue!</a>
		</div>
	</div>
</body>
</html>
