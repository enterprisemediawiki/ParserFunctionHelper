<?php
/**
 *
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2015 by James Montalvo
 * @licence GNU GPL v3+
 */

 
namespace ParserFunctionHelper\Test;

use ParserFunctionHelper as PFH;
// use ParserFunctionHelper\Dummies as Dummies;

class ParserFunctionHelperTest extends \MediaWikiTestCase {

	//private $apple;

	protected function setUp() {
		parent::setUp();
		//$this->apple = Fruit::factory( 'apple' );
	}

	protected function tearDown() {
		//unset( $this->apple );
		parent::tearDown();
	}

	// public $functionName;
	// public $unlabelledParamDefaults;
	// public $labelledParamDefaults;
	// public $params;
	// public $allowUserDefinedParams = false; // all named params must be specified in class unless set to true


	// public function __construct ( \Parser &$parser, $functionName, $unlabelledParamDefaults, $labelledParamDefaults ) {}

	// static public function renderWrapper ( &$parser, $frame, $userParams ) {}

	// abstract public function render( \Parser &$parser, $params );

	function testAbstractClass ( ) {

		// $mocked = $this->getMockBuilder('ParserFunctionHelper')
		// 	->disableOriginalConstructor()
		// 	//->setMethods(array('processParams'))
		// 	->getMockForAbstractClass();

		$parser = new \Parser();

		$indexedDefaults = array(
			'index1' => 1,
			'index2' => 2,
			'index3' => 3,
		);
		$namedDefaults = array(
			'name1' => 4,
			'name2' => 5,
			'name3' => 6,
		);
		$userParams = array(
			'5',
			'3'
		);

		// $dummy = new PFH\DummyFunction();
		$dummy = new PFH\DummyFunction(
			$parser,
			$indexedDefaults,
			$namedDefaults
		);


		$outputParams = $dummy->processParams( $userParams );

		// user input
		$this->assertTrue( $outputParams['index1'] === $userParams[0] );
		$this->assertTrue( $outputParams['index2'] === $userParams[1] );

		// defaults
		$this->assertTrue( $outputParams['index3'] === $indexedDefaults['index3'] );
		$this->assertTrue( $outputParams['name1'] === $namedDefaults['name1'] );
		$this->assertTrue( $outputParams['name2'] === $namedDefaults['name2'] );
		$this->assertTrue( $outputParams['name3'] === $namedDefaults['name3'] );

		// find very clean way to test the following:
		// * parser function setup types:
		//    * All indexed
		//       * defaults only
		//       * some user defined
		//       * all user defined
		//       * user over-defined
		//    * All named
		//       * same as "All indexed"
		//    * Some index, some named
		//       * defaults only
		//       * some user defined indexed
		//       * all user defined indexed
		//       * some user defined named
		//       * all user defined named
		//       * user over-defined
		// * auto-reordering of names/orders


	}

	// public function processParams () {}
	// public function setupParserFunction () {}

}