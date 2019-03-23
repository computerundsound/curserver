<?php /** @noinspection PhpComposerExtensionStubsInspection */

use app\installer\UpdateController;

require_once __DIR__ . '/../inc/_close/vendor/autoload.php';

$xamppDir = dirname(__DIR__, 2) . '/';

$preInformation = <<<HTML

This script will help you to run curserver - Tool by Jörg Wrase (cusp.de)

Please make sure that you have the right directory structure

This tool will overwrite some settings (my.ini from mysql, php.ini)
The settings that will be changed are defined in the replacement.ini. 

DIRECTORY STRUCTURE:

+ Every Xampp-Installation must be in its own directory
+ The directory-name must start with

   xampp-

   Example: xampp-7.0

+ All xampp-directories must be on the same level (all in one directory)
+ This tool must be in the same directory

    Example:
    
    curserver
    xampp-5.5
    xampp-5.6
    xampp-7.1
    xampp-7.2
    xampp-7.5_beta
        
+ XDEBUG will be switched on

Current Xampp-directory is: $xamppDir

WARNING: USE THIS TOOL ON YOUR OWN RISK. IT CAN BREAK YOUR XAMPP-INSTALLATIONS
I'M NOT RESPONSIBLE FOR ANY PROBLEMS WITH THIS TOOL OR ANY DAMAGES THROUGH THIS TOOL



HTML;

echo $preInformation;

$input        = readline('Do you want to continue (yes/no)]? ');
$inputTrimmed = trim($input);

if ($inputTrimmed === 'yes' || $inputTrimmed === 'y') {

    echo "Start: \n\n";

    $replacerIniPath = realpath(__DIR__ . '/replacement.ini');

    $updateController = new UpdateController();
    $updateController->update($xamppDir, $replacerIniPath);

    echo 'Finished - please check your xampps';

} else {
    echo "Aborted by user!\n\n";
}