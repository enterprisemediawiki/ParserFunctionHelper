<?php

namespace ParserFunctionHelper;

class DummyFunction extends ParserFunctionHelper {

	// public function __construct() {

	// }

	public function __construct ( \Parser &$parser, $numericIndexParams=array(), $namedIndexParams=array() ) {
		parent::__construct(
			$parser,
			'dummy',
			$numericIndexParams,
			$namedIndexParams
		);
	}
	public function render ( \Parser &$parser, $params ) {
		return $params;
	}

}

