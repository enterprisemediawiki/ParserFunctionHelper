<?php
/**
 *
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2015 by James Montalvo
 * @licence GNU GPL v3+
 */
 
namespace ParserFunctionHelper;

class Setup {

	static public function onUnitTestsList ( &$files ) {



	    $files = array_merge( $files, glob( __DIR__ . '/tests/phpunit/*Test.php' ) );
	    return true;
	}


	/**
	* Handler for ParserFirstCallInit hook; sets up parser functions.
	* @see http://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	* @param $parser Parser object
	* @return bool true in all cases
	*/
	static function setupParserFunctions ( &$parser ) {
		global $egParserFunctionHelperClasses;

		foreach( $egParserFunctionHelperClasses as $class ) {
			$obj = new $class( $parser );
			$obj->setupParserFunction();
		}

		// $substrcount = new SubstrCount( $parser );
		// $substrcount->setupParserFunction();

		// always return true
		return true;

	}
	

}