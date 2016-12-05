<?php
/**
 * This script bootstraps a ParserFunctionHelper-based extension
 * May at some point add a parser function to an existing extension
 *
 * Usage:
 *  no parameters
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @author James Montalvo
 * @ingroup Maintenance
 */

// Determine mediawiki install path
if ( ! isset( $IP ) ) {
	$IP = __DIR__ . '/../../';
	if ( getenv("MW_INSTALL_PATH") ) {
		$IP = getenv("MW_INSTALL_PATH");
	}
}
require_once( "$IP/maintenance/Maintenance.php" );

class CreateParserFunction extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = "Bootstrap a ParserFunctionHelper-based extension";

		// addOption ($name, $description, $required=false, $withArg=false, $shortName=false)
		$this->addOption(
			'ext-name',
			'Name of extension, like MyParserFunction',
			true, true );

		$this->addOption(
			'function',
			'English function wikitext as used in MediaWiki, like {{#func-name: ... }}. Spaces removed, forced lowercase.',
			true, true );

		$this->addOption(
			'your-name',
			'Your name, for docs.',
			false, true );

	}

	public function execute() {

		$extensionName = $this->getOption( 'ext-name' );
		$noSpaceExtensionName = str_replace( ' ', '', $extensionName );
		$lowerCaseNoSpaceExtensionName = strtolower( $noSpaceExtensionName );

		// as subject, use wikitext parser function with spaces removed and capital first letter
		$pfNameInit = ucfirst( str_replace( ' ', '', $this->getOption( 'function' ) ) );
		// echo "\n\n\n Test: $pfNameInit\n\n\n";

		$parserFunctionName = preg_replace_callback(

			// find - character and immediately following character
			'/-./',

			// strip off - and capitalize character following
			function( $matches ) {
				return strtoupper( substr( $matches[0], 1, 1 ) );
			},

			$pfNameInit
		);

		// for function wikitext just make sure no capitals or spaces.
		$parserFunctionWikitext = strtolower( str_replace( ' ', '', $this->getOption( 'function' ) ) );

		$yourName = $this->getOption( 'your-name', "Your Name" );

		// copy template files
		$source = __DIR__ . '/example';
		$dest = __DIR__ . '/../' . $noSpaceExtensionName;
		if ( ! self::rcopy( $source, $dest ) ) {
			$this->output( "\nDestination $dst already exists.\n" );
			$this->output( "Set a new destination with --path=/path/to/new/extension\n" );
			return false;
		}

		// replace templated info
		self::replace( "$dest/i18n/en.json", array(
			"extension-name" => $extensionName,
			"lowercase-nospace-extension-name" => $lowerCaseNoSpaceExtensionName
		) );

		self::replace( "$dest/Magic.php", array(
			"parser-function-wikitext" => $parserFunctionWikitext
		) );

		self::replace( "$dest/extension.json", array(
			"extension-name" => $extensionName,
			"nospace-extension-name" => $noSpaceExtensionName,
			"lowercase-nospace-extension-name" => $lowerCaseNoSpaceExtensionName,
			"your-name" => $yourName,
			"parser-function-name" => $parserFunctionName
		) );

		self::replace( "$dest/README.md", array(
			"extension-name" => $extensionName,
			"parser-function-wikitext" => $parserFunctionWikitext
		) );

		self::replace( "$dest/includes/ParserFunctionName.php", array(
			"your-name" => $yourName,
			"parser-function-name" => $parserFunctionName,
			"parser-function-wikitext" => $parserFunctionWikitext
		) );

		self::replace( "$dest/includes/Setup.php", array(
			"your-name" => $yourName,
			"nospace-extension-name" => $noSpaceExtensionName,
			"parser-function-name" => $parserFunctionName
		) );

		// rename file
		rename( "$dest/includes/ParserFunctionName.php", "$dest/includes/$parserFunctionName.php" );

		$this->output( "\nExtension:$extensionName created at $dest\n" );
		return true;

	}

	// copies files and non-empty directories
	// adapted from: http://php.net/manual/en/function.copy.php#104020
	static public function rcopy ( $src, $dst ) {

		if ( file_exists( $dst ) ) {
			return false;
		}

		if ( is_dir( $src ) ) {
			mkdir( $dst );
			$files = scandir( $src );
			foreach ( $files as $file ) {
				if ( $file != "." && $file != ".." ) {
					self::rcopy( "$src/$file", "$dst/$file" );
				}
			}
		}
		else if ( file_exists( $src ) ) {
			copy( $src, $dst );
		}

		return true;
	}

	static public function replace ( $file, $replaces ) {

		$fileText = file_get_contents( $file );

		foreach ( $replaces as $key => $replace ) {
			$search = '{{' . $key . '}}';
			// echo "find $search in $file, replace with $replace\n";
			$fileText = str_replace( $search, $replace, $fileText );
		}

		file_put_contents( $file, $fileText );

		return true;
	}

}
$maintClass = "CreateParserFunction";
require_once( DO_MAINTENANCE );


