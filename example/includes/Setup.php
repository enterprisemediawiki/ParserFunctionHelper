<?php
/**
 *
 * @addtogroup Extensions
 * @author {{your-name}}
 * @copyright © 2016 by {{your-name}}
 * @licence GNU GPL v3+
 */

namespace {{nospace-extension-name}};

class Setup {

	/**
	* Handler for ParserFirstCallInit hook; sets up parser functions.
	* @see http://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	* @param $parser Parser object
	* @return bool true in all cases
	*/
	static function setupParserFunctions ( &$parser ) {

		${{parser-function-name}} = new \{{parser-function-name}}( $parser );
		${{parser-function-name}}->setupParserFunction();

		// always return true
		return true;

	}

}
