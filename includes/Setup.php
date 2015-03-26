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

}