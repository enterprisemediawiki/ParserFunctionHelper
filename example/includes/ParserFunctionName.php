<?php
/**
 * @author {{your-name}}
 * @copyright © 2016 by {{your-name}}
 * @licence GNU GPL v3+
 */

use ParserFunctionHelper\ParserFunctionHelper;

class {{parser-function-name}} extends ParserFunctionHelper {


	// The __construct function sets up your parser function with its name,
	// parameter names and defaults
	public function __construct ( Parser &$parser ) {

		parent::__construct(

			// this is a reference to the MediaWiki parser, and it SHOULD NOT BE CHANGED.
			$parser,

			// The name of your parser function. This should be the same as in Magic.php
			'{{parser-function-wikitext}}',

			// the "ordered" parameters to your parser function. the first element of this
			// array will be the first element of the parser function, and so on. Note that
			// the MediaWiki user never has to type "first-ordered-unnamed-param" or
			// "second-such-param", and these names are purely for variable naming within
			// the parser function code below.
			array(
				'first-ordered-unnamed-param' => 'some-default-value',
				'second-such-param' => 'another-default'
			),

			// these are "named" parameters. So you'd do something like:
			// {{#your-function: an unnamed value | another val | another-named = 50 }}
			// the above would set the "another-named" parameter which can be set out-of-order
			// from the "first-named-param", or without "first-named-param" altogether.
			array(
				'first-named-param' => 10,
				'another-named' => "another default"
			)
		);

	}


	// the render function takes in the parameters you defined above and performs
	// the required logic.
	public function render ( Parser &$parser, $params ) {

		// access params like:
		$firstOrdered = $params['first-ordered-unnamed-param'];
		$secondOrdered = $params['second-such-param'];

		$firstNamed = $params['first-named-param'];
		$secondNamed = $params['another-named'];

		// ... DO STUFF WITH THE PARAMS ...

		// return the value. This will print the output to MediaWiki
		return $output;

		// alternatively, return the output without parsing wikitext
		return return array( $output, 'noparse' => true, 'isHTML' => true );

	}

}
