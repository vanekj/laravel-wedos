<?php

/**
 * wedos.php
 *
 * Laravel for Wedos preparation utility.
 *
 * @author     Jakub Vaněk
 * @copyright  2017 Jakub Vaněk
 * @license    MIT
 * @version    2.1.0
 * @link       https://github.com/vanekj/laravel-wedos
 */

ob_start();

class Str
{
    /**
     * Transliterate a UTF-8 value to ASCII.
     *
     * @param  string  $value
     * @return string
     */
    public static function ascii($value)
    {
        foreach (static::charsArray() as $key => $val) {
            $value = str_replace($val, $key, $value);
        }

        return preg_replace('/[^\x20-\x7E]/u', '', $value);
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @return string
     */
    public static function slug($title, $separator = '-')
    {
        $title = static::ascii($title);

        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }

    /**
     * Returns the replacements for the ascii method.
     *
     * Note: Adapted from Stringy\Stringy.
     *
     * @see https://github.com/danielstjules/Stringy/blob/2.3.1/LICENSE.txt
     *
     * @return array
     */
    protected static function charsArray()
    {
        static $charsArray;

        if (isset($charsArray)) {
            return $charsArray;
        }

        return $charsArray = [
            '0'    => ['°', '₀', '۰'],
            '1'    => ['¹', '₁', '۱'],
            '2'    => ['²', '₂', '۲'],
            '3'    => ['³', '₃', '۳'],
            '4'    => ['⁴', '₄', '۴', '٤'],
            '5'    => ['⁵', '₅', '۵', '٥'],
            '6'    => ['⁶', '₆', '۶', '٦'],
            '7'    => ['⁷', '₇', '۷'],
            '8'    => ['⁸', '₈', '۸'],
            '9'    => ['⁹', '₉', '۹'],
            'a'    => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا'],
            'b'    => ['б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ'],
            'c'    => ['ç', 'ć', 'č', 'ĉ', 'ċ'],
            'd'    => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ'],
            'e'    => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ'],
            'f'    => ['ф', 'φ', 'ف', 'ƒ', 'ფ'],
            'g'    => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ'],
            'h'    => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ'],
            'i'    => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ'],
            'j'    => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج'],
            'k'    => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک'],
            'l'    => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ'],
            'm'    => ['м', 'μ', 'م', 'မ', 'მ'],
            'n'    => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ'],
            'o'    => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ'],
            'p'    => ['п', 'π', 'ပ', 'პ', 'پ'],
            'q'    => ['ყ'],
            'r'    => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ'],
            's'    => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს'],
            't'    => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ'],
            'u'    => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ'],
            'v'    => ['в', 'ვ', 'ϐ'],
            'w'    => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ'],
            'x'    => ['χ', 'ξ'],
            'y'    => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ'],
            'z'    => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ'],
            'aa'   => ['ع', 'आ', 'آ'],
            'ae'   => ['ä', 'æ', 'ǽ'],
            'ai'   => ['ऐ'],
            'at'   => ['@'],
            'ch'   => ['ч', 'ჩ', 'ჭ', 'چ'],
            'dj'   => ['ђ', 'đ'],
            'dz'   => ['џ', 'ძ'],
            'ei'   => ['ऍ'],
            'gh'   => ['غ', 'ღ'],
            'ii'   => ['ई'],
            'ij'   => ['ĳ'],
            'kh'   => ['х', 'خ', 'ხ'],
            'lj'   => ['љ'],
            'nj'   => ['њ'],
            'oe'   => ['ö', 'œ', 'ؤ'],
            'oi'   => ['ऑ'],
            'oii'  => ['ऒ'],
            'ps'   => ['ψ'],
            'sh'   => ['ш', 'შ', 'ش'],
            'shch' => ['щ'],
            'ss'   => ['ß'],
            'sx'   => ['ŝ'],
            'th'   => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
            'ts'   => ['ц', 'ც', 'წ'],
            'ue'   => ['ü'],
            'uu'   => ['ऊ'],
            'ya'   => ['я'],
            'yu'   => ['ю'],
            'zh'   => ['ж', 'ჟ', 'ژ'],
            '(c)'  => ['©'],
            'A'    => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ'],
            'B'    => ['Б', 'Β', 'ब'],
            'C'    => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ'],
            'D'    => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ'],
            'E'    => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə'],
            'F'    => ['Ф', 'Φ'],
            'G'    => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ'],
            'H'    => ['Η', 'Ή', 'Ħ'],
            'I'    => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ'],
            'K'    => ['К', 'Κ'],
            'L'    => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल'],
            'M'    => ['М', 'Μ'],
            'N'    => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν'],
            'O'    => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ'],
            'P'    => ['П', 'Π'],
            'R'    => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ'],
            'S'    => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ'],
            'T'    => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ'],
            'U'    => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ'],
            'V'    => ['В'],
            'W'    => ['Ω', 'Ώ', 'Ŵ'],
            'X'    => ['Χ', 'Ξ'],
            'Y'    => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ'],
            'Z'    => ['Ź', 'Ž', 'Ż', 'З', 'Ζ'],
            'AE'   => ['Ä', 'Æ', 'Ǽ'],
            'CH'   => ['Ч'],
            'DJ'   => ['Ђ'],
            'DZ'   => ['Џ'],
            'GX'   => ['Ĝ'],
            'HX'   => ['Ĥ'],
            'IJ'   => ['Ĳ'],
            'JX'   => ['Ĵ'],
            'KH'   => ['Х'],
            'LJ'   => ['Љ'],
            'NJ'   => ['Њ'],
            'OE'   => ['Ö', 'Œ'],
            'PS'   => ['Ψ'],
            'SH'   => ['Ш'],
            'SHCH' => ['Щ'],
            'SS'   => ['ẞ'],
            'TH'   => ['Þ'],
            'TS'   => ['Ц'],
            'UE'   => ['Ü'],
            'YA'   => ['Я'],
            'YU'   => ['Ю'],
            'ZH'   => ['Ж'],
            ' '    => ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"],
        ];
    }
}

class Wedos
{
	/**
	 * App is prepared with all paths set and configs loaded
	 *
	 * @var boolean
	 */
	private static $prepared = false;

	/**
	 * Path to the "/" folder
	 *
	 * @var string
	 */
	private static $root_path = '';

	/**
	 * Path to the "/public"
	 *
	 * @var string
	 */
	private static $public_path = '';

	/**
	 * Path to the "/config"
	 *
	 * @var string
	 */
	private static $config_path = '';

	/**
	 * All options (.env keys) found in config files
	 *
	 * @var array
	 */
	public static $config_options = [];

	/**
	 * All options from "/.env" file
	 *
	 * @var array
	 */
	public static $env_options = [];

	/**
	 * Prepare, load paths, configs, etc.
	 *
	 * @return void
	 */
	public static function prepare()
	{
		// Prepare paths
		self::preparePaths();

		// Load all configs
		self::loadConfigOptions();

		// Load .env values
		self::loadEnvValues();

		// Set as prepared
		self::$prepared = true;
	}

	/**
	 * Run all required functions
	 *
	 * @param  array  $post  Post data object
	 * @return void
	 */
	public static function make(array $post)
	{
		// Prepare if not already prepared
		if (!self::$prepared) {
			self::prepare();
		}

		// Update config options
		self::updateConfigs($post);

		// Update public .htaccess
		self::publicHtaccess();

		// Update root .htaccess
		self::rootHtaccess();

		// Set correct permissions to folders and files
		self::repairChmod();

		// Clean the files
		self::cleanup();

		// Reload when complete
		self::reload();
	}

	/**
	 * Prepare paths variables
	 *
	 * @return void
	 */
	public static function preparePaths()
	{
		// Set root path
		self::$root_path = __DIR__;

		// Set public path
		self::$public_path = self::$root_path . '/public';

		// Set config path
		self::$config_path = self::$root_path . '/config';
	}

	/**
	 * Load all options from config files
	 *
	 * @return array
	 */
	public static function loadConfigOptions(): array
	{
		$configs = array_diff(scandir(self::$config_path), array('..', '.'));
		$regex = "/env\((?:[\s\n]+)?\'(?'key'[A-Z_]+)\'(?:[,\s\n]+)?(?'value'(?:[^()]++|\((?2)\))++)?\)/";
		$keys = [];

		if (count($configs) > 0) {
			foreach($configs as $config_file) {
				$file = self::$config_path . "/{$config_file}";
				$content = file_get_contents($file);

				preg_match_all($regex, $content, $matches, PREG_SET_ORDER);

				foreach($matches as $match) {
					$key = $match['key'];
					$value = $match['value'];
					$type = 'string';

					if ($value === 'null') {
						$type = 'string|null';
					} else if (strlen($value) > 0 && strpos($value, "'") === false) {
						$type = is_numeric($value) ? 'integer' : 'boolean';
					}

					$value = preg_replace("/^'|'$/", '', $value);

					if (!in_array($key, $keys)) {
						array_push($keys, $key);

						self::$config_options[$key] = [
							'key' => $key,
							'value' => trim($value),
							'type' => $type
						];
					}
				}
			}
		} else {
			trigger_error('No config files found.');
		}

		return self::$config_options;
	}

	/**
	 * Load all "/.env" options
	 *
	 * @return array
	 */
	public static function loadEnvValues(): array
	{
		$file = self::$root_path . '/.env';

		if (file_exists($file)) {
			$content = file_get_contents($file);

			$keys = [];
			foreach(self::$config_options as $option) {
				if (!in_array($option['key'], $keys)) {
					array_push($keys, $option['key']);
				}
			}
			$keys = implode('|', $keys);

			$regex = "/^(?'key'(?:$keys))=(?'value'.+)$/m";

			preg_match_all($regex, $content, $matches, PREG_SET_ORDER);

			foreach($matches as $match) {
				self::$env_options[$match['key']] = [
					'key' => $match['key'],
					'value' => trim($match['value'])
				];
			}
		} else {
			trigger_error('.env file not found.');
		}

		return self::$env_options;
	}

	/**
	 * Repair file and folders permissions
	 *
	 * @return void
	 */
	public static function repairChmod()
	{
		self::rchmod();
		self::rchmod(self::$root_path . '/storage', 0777);
		self::rchmod(self::$root_path . '/bootstrap/cache', 0777);
	}

	/**
	 * Recursively set directory and files chmod
	 *
	 * @param  string   $start_dir   Root dir where to start recursion
	 * @param  integer  $dir_perms   Directory permissions
	 * @param  integer  $file_perms  File permissions
	 * @return void
	 */
	private static function rchmod($start_dir = '', $dir_perms = 0755, $file_perms = 0644)
	{
		$start_dir = strlen($start_dir) === 0 ? self::$root_path : $start_dir;

		if (is_dir($start_dir)) {
			if (substr(sprintf('%o', fileperms($start_dir)), -4) !== $dir_perms) {
				chmod($start_dir, $dir_perms);
			}

			$cd = opendir($start_dir);

			while (($file = readdir($cd)) !== false) {
				if ($file === '.' || $file === '..') continue;

				$path = "$start_dir/$file";

				if (is_dir($path)) {
					chmod($path, $dir_perms);
					self::rchmod($path);
				} else {
					chmod($path, $file_perms);
				}
			}

			closedir($cd);
		}
	}

	/**
	 * Update config options by given values
	 *
	 * @param  array  $post  Post data object
	 * @return void
	 */
	private static function updateConfigs(array $post)
	{
		$configs = array_diff(scandir(self::$config_path), array('..', '.'));

		if (count($configs) > 0) {
			foreach($configs as $config_file) {
				$file = self::$config_path . "/{$config_file}";
				$content = file_get_contents($file);

				foreach($post as $key => $value) {
					if ($key !== 'submit') {
						$regex = "/env\((?:[\s\n]+)?\'$key\'((?:[^()]++|\((?1)\))++)?\)/";
						$content = preg_replace($regex, $value, $content);
					}
				}

				file_put_contents($file, $content);
			}
		}
	}

	/**
	 * Clean .htaccess file in "public" folder so not working options
	 * are removed for proper functionality
	 *
	 * @return void
	 */
	private static function publicHtaccess()
	{
		$file = self::$public_path . '/.htaccess';

		if (file_exists($file)) {
			$content = file_get_contents($file);

			$regex = '/<IfModule mod_negotiation\.c>(.|\n)*?<\/IfModule>/';
			$content = preg_replace($regex, '', $content);

			file_put_contents($file, $content);
			chmod($file, 0644);
		}
	}

	/**
	 * Create or update .htaccess file in root folder with required options
	 *
	 * @return void
	 */
	private static function rootHtaccess()
	{
		$file = self::$root_path . '/.htaccess';
		$content = '';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			$content .= "\n";
		}

		$content .= "<IfModule mod_rewrite.c>";
		$content .= "\n    RewriteEngine on";
		$content .= "\n    RewriteCond %{REQUEST_URI} !^public";
		$content .= "\n    RewriteRule ^(.*)$ public/$1 [L]";
		$content .= "\n</IfModule>";

		file_put_contents($file, $content);
		chmod($file, 0644);
	}

	/**
	 * Deactivate this script
	 *
	 * @return void
	 */
	private static function cleanup()
	{
		chmod(self::$root_path . '/wedos.php', 0000);
	}

	/**
	 * Reload the website when the process is complete
	 *
	 * @return void
	 */
	private static function reload()
	{
		header("Location: {$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/");
		exit();
	}
}

// Prepare
Wedos::prepare();

// Global variables
$options = Wedos::$config_options;
$env_options = Wedos::$env_options;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['prepare'])) {
		Wedos::make($_POST);
	} else if (isset($_POST['repair-chmod'])) {
		Wedos::repairChmod();
	}
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
		* { box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; }
		html, body { margin: 0; padding: 0; }
		body { font-size: 14px; line-height: 1.5 }
		body, input, select, textarea { font-family: monospace; }
		.container { margin: 10px auto 0 auto; padding: 0 15px; width: 700px; }
		.header { padding-bottom: 20px; }
		.footer { margin: 20px 0; text-align: center; }
		table { width: 100%; border-collapse: collapse; }
		table tbody tr:nth-child(even) { background: lightgray; }
		td { padding: 2px 5px; }
		.form-item.-label { white-space: nowrap; }
		.form-item.-type { color: gray; text-align: right; }
		.form-item.-input,
		.form-item input[type="text"],
		.form-item input[type="number"] { width: 100%; }
		.form-item.-submit { padding-top: 15px; }
		.form-item.-submit input[type="submit"] { width: 100%; }
	</style>
</head>
<body>
	<div class="container">
		<?php if (count($options) > 0): ?>
			<form action="" method="POST">
				<table>
					<thead>
						<tr>
							<td colspan="3" class="header" align="center">
								<strong>Values that would be placed in config files.</strong><br />
								<small>You can change these values if needed.</small>
							</td>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($options as $option): ?>
							<?php
								$key = $option['key'];
								$type = $option['type'];
								$env_value = $env_options[$key]['value'];
								$config_value = $option['value'];
								$value = strlen($env_value) > 0 ? $env_value : $config_value;

								if ($key === 'CACHE_PREFIX') {
									$value = Str::slug($env_options['APP_NAME']['value'], '_') . '_cache';
								} else if ($key === 'SESSION_COOKIE') {
									$value = Str::slug($env_options['APP_NAME']['value'], '_') . '_session';
								}

								$value = $type === 'string' ? "'$value'" : $value;
							?>

							<tr>
								<td valign="middle" class="form-item -label">
									<?=$key?>
								</td>
								<td valign="middle" class="form-item -type">
									<small>[<?=$type?>]</small>
								</td>
								<td valign="middle" class="form-item -input">
									<?php if ($type === 'boolean'): ?>
									<label><input type="radio" name="<?=$key?>" id="<?=$key?>_true" value="true"<?=$value?' checked="checked"':''?> />true</label>
									<label><input type="radio" name="<?=$key?>" id="<?=$key?>_false" value="false"<?=!$value?' checked="checked"':''?> />false</label>
									<?php elseif ($type === 'integer'): ?>
									<input type="number" name="<?=$key?>" id="<?=$key?>" value="<?=$value?>" autocomplete="off" />
									<?php else: ?>
									<input type="text" name="<?=$key?>" id="<?=$key?>" value="<?=$value?>" autocomplete="off" />
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot>
						<tr>
							<td colspan="3" class="form-item -submit" align="center">
								<input class="submit" type="submit" name="prepare" value="Start" />
							</td>
						</tr>
					</tfoot>
				</table>
			</form>
		<?php else: ?>
			<p>Error, please make sure you have a fresh Laravel installation and try again.</p>
		<?php endif; ?>

		<div class="actions">
			<hr />
			<form action="" method="POST">
				<input class="submit" type="submit" name="repair-chmod" value="Repair folder and file permissions" />
			</form>
		</div>

		<div class="footer">
			<hr />
			<a href="https://github.com/vanekj/laravel-wedos/issues" target="_blank" title="Projects GitHub page">Report an issue!</a>
		</div>
	</div>
</body>
</html>