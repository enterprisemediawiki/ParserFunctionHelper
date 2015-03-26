<?php
/** 
 * The MeetingMinutes extension provides JS and CSS to enable recording meeting
 * minutes in SMW. See README.md.
 * 
 * Documentation: https://github.com/enterprisemediawiki/MeetingMinutes
 * Support:       https://github.com/enterprisemediawiki/MeetingMinutes
 * Source code:   https://github.com/enterprisemediawiki/MeetingMinutes
 *
 * @file MeetingMinutes.php
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2014 by James Montalvo
 * @licence GNU GPL v3+
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( ! defined( 'MEDIAWIKI' ) ) {
	die( 'ParserFunctionHelper extension' );
}

$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Parser Function Helper',
	'namemsg'        => 'parserfunctionhelper-name',
	'url'            => 'http://github.com/jamesmontalvo3/ParserFunctionHelper.git',
	'author'         => '[https://www.mediawiki.org/wiki/User:Jamesmontalvo3 James Montalvo]',
	'descriptionmsg' => 'parserfunctionhelper-desc',
	'version'        => '0.1.0'
);

//
$GLOBALS['wgMessagesDirs']['ParserFunctionHelper'] = __DIR__ . '/i18n';

// Autoload
$GLOBALS['wgAutoloadClasses']['ParserFunctionHelper\Setup'] = __DIR__ . '/includes/Setup.php';
$GLOBALS['wgAutoloadClasses']['ParserFunctionHelper\ParserFunctionHelper'] = __DIR__ . '/includes/ParserFunctionHelper.php';
$GLOBALS['wgAutoloadClasses']['ParserFunctionHelper\DummyFunction'] = __DIR__ . '/tests/dummies/DummyFunction.php';

// Unit testing
$GLOBALS['wgHooks']['UnitTestsList'][] = 'ParserFunctionHelper\Setup::onUnitTestsList';
