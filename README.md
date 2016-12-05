Parser Function Helper
======================

Helper class for creating MediaWiki parser functions.

Installation
------------

1. Download this extension and put the "ParserFunctionHelper" directory into your MediaWiki "extensions" directory.
2. Add the following code at the bottom of your LocalSettings.php:
```php
wfLoadExtension('ParserFunctionHelper');
```

Once installed, develop your own extension that uses ParserFunctionHelper (ParserFunctionHelper doesn't do anything on it's own).

Generate a new extension with script
------------------------------------

To generate a new parser function extension, run the following:

```bash
cd /path/to/your/mediawiki/extensions/ParserFunctionHelper
php createParserFunction.php --ext-name=MyNewExtension --function=my-parser-function --your-name="Your Full Name"
```

A new extension will be generated at `/path/to/your/mediawiki/extensions/MyNewExtension

Creating your own extension (old instructions)
----------------------------------------------

Below are old instructions. I haven't had time to figure out what's still applicable.

1. Copy the BasicParserFunction extension code from https://github.com/enterprisemediawiki/BasicParserFunction and put the files in your wiki's extension directory.
2. Rename your new BasicParserFunction directory to whatever you want your extension to be called. Also, throughout the extension the name "BasicParserFunction" is used in many places. You'll want to rename these as well. You can skip this step initially if you are just learning and don't mind leaving your extension called "BasicParserFunction".
3. View the 6 files in your extension (this tutorial assumes you kept it called "BasicParserFunction"):
  1. BasicParserFunction.php: The "entry point" for your extension, where everything is setup for MediaWiki
  2. Magic.php: Defines the name of your parser function(s)
  3. README.md: Documenation
  4. SubstrCount.php: This is the meat of your parser function, where the logic is handled.
  5. i18n/en.json: Internationalization file, specifying what text should be displayed if you're using the English version of a wiki.
  6. i18n/es.json: Just like en.json, but Spanish instead of English
4. Edit three lines in BasicParserFunction.php:
  1. The variable ```$GLOBALS['egParserFunctionHelperClasses'][]``` can be changed to whatever your parser function should be called. In BasicParserFunction it is "BasicParserFunction\SubstrCount", but another example could be "MyParserFunction\DoImportantFunction".
  2. The function you define in the previous step needs to have a file associated with it, and you need to tell MediaWiki to "autoload" it. So the line that starts with $GLOBALS['wgAutoloadClasses'] should be changed to reflect your parser functions name.
  3. (optional, for now) Edit the "credits" line. See https://www.mediawiki.org/wiki/Manual:$wgExtensionCredits for more info.
5. Edit Magic.php:
  1. Change the name of your parser function!
6. Change the name of SubstrCount.php to whatever you want your parser function to be called.
7. Edit your newly-named file. The SubstrCount.php file includes inline annotations for its function, but the gist is this:
  1. The __construct function defines the name, parameters and defaults for the parser function
  2. The render function defines what the function does
