<?php
/**
 *
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2014 by James Montalvo
 * @licence GNU GPL v3+
 */
 
namespace ParserFunctionHelper;

abstract class ParserFunctionHelper {

	public $functionName;
	public $unlabelledParamDefaults;
	public $labelledParamDefaults;
	public $params;
	public $allowUserDefinedParams = false; // all named params must be specified in class unless set to true


	public function __construct ( \Parser &$parser, $functionName, $unlabelledParamDefaults, $labelledParamDefaults ) {

		$this->parser = $parser;
		$this->functionName = $functionName;
		$this->unlabelledParamDefaults = $unlabelledParamDefaults;
		$this->labelledParamDefaults = $labelledParamDefaults;

	}

	static public function renderWrapper ( &$parser, $frame, $userParams ) {

		// new instance of inheriting class (e.g. not this abstract class)
		$pf = new self( $parser );

		$pf->frame = $frame;
		$params = $pf->processParams( $userParams );

		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		// FIXME: Do I need this?
		// return $parser->insertStripItem( $str, $parser->mStripState );

		return $pf->render( $parser, $params );
	}

	abstract public function render( \Parser &$parser, $params );

	function processParams ( $userParams ) {

		$processedParams = array(); // reset this array if set to something

		// param name stuff
		$numUnnamedParams = count( $this->unlabelledParamDefaults );
		$unlabelledParamNames = array_keys( $this->unlabelledParamDefaults );
		$namedParamNames = array_keys( $this->labelledParamDefaults );

		for ( $i = 0; $i < $numUnnamedParams; $i++ ) {

		}


		// assign params - support unlabelled params, for backwards compatibility
		foreach ( $userParams as $i => $param ) {
			$param = trim( $this->frame->expand( $param ) );

			if ( $param === '' ) {
				continue; // skip blank parameters
			}

			if ( $i < $numUnnamedParams ) {
				$unlabelledParamName = $unlabelledParamNames[$i];
				$processedParams[ $unlabelledParamName ] = $param;
				continue;
			}

			$elements = explode( '=', $param, 2 );
			$paramName = trim( $elements[0] );

			// either 
			$validParamName = in_array( $paramName, $namedParamNames ) || $this->allowUserDefinedParams;

			// set paramName and value
			if ( count( $elements ) > 1 && $validParamName ) {

				$processedParams[ $paramName ] = trim( $elements[1] );

			} else {

				// FIXME: incorporate error-handling for named-param without a (valid) name
			
			}

		}

		// if any unnamed params were not set, set them now with defaults
		for ( $j = $i + 1; $j < $numUnnamedParams; $j++ ) {
			$unlabelledParamName = $unlabelledParamNames[$j];
			$processedParams[ $unlabelledParamName ] = $this->unlabelledParamDefaults[ $unlabelledParamName ];
		}

		foreach( $this->unlabelledParamDefaults as $name => $default ) {
			if ( ! array_key_exists( $name, $processedParams ) ) {
				$processedParams[ $name ] = $default;
			}
		}


		// if any named params were not set, set them now with defaults
		foreach( $this->labelledParamDefaults as $name => $default ) {
			if ( ! array_key_exists( $name, $processedParams ) ) {
				$processedParams[ $name ] = $default;
			}
		}

		// return "asdf $debug " . print_r( $processedParams, true ) . "asdfasdfasdfadsf";
		// print_r( $processedParams );
		return $processedParams;

	}

	public function setupParserFunction () {
		
		$parserFunctionClass = get_class( $this );

		// setup #some_name parser function
		$this->parser->setFunctionHook(
			$this->functionName,

			// lambda was: $this->className . '::renderWrapper',
			function ( &$parser, $frame, $userParams ) use ( $parserFunctionClass ) {

				// new instance of inheriting class (e.g. not this abstract class)
				$pf = new $parserFunctionClass( $parser );

				$pf->frame = $frame;
				// return $pf->processParams( $userParams );
				$processedParams = $pf->processParams( $userParams );

				// hack to remove newline from beginning of output, thanks to
				// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
				// FIXME: Do I need this?
				// return $parser->insertStripItem( $str, $parser->mStripState );

				return $pf->render( $parser, $processedParams );

			},

			SFH_OBJECT_ARGS
		);

	}

}