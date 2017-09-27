<?php

/**
 * wedos.php
 *
 * Laravel for Wedos preparation utility.
 *
 * @author     Jakub Vaněk
 * @copyright  2017 Jakub Vaněk
 * @license    https://github.com/vanekj/laravel-wedos/blob/master/LICENSE  MIT
 * @version    1.0.0
 * @link       https://github.com/vanekj/laravel-wedos
 */

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
	$content = preg_replace('/\s+<IfModule mod_negotiation\.c>\s+Options(?:\s-MultiViews)?(?:\s-Indexes)?\s+<\/IfModule>/', '', $content);

	file_put_contents($file, $content);
	chmod($file, 0644);
}