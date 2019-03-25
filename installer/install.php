<?php /** @noinspection PhpComposerExtensionStubsInspection */

use app\installer\UpdateController;

require_once __DIR__ . '/../inc/_close/vendor/autoload.php';

$xamppDir = dirname(__DIR__, 2) . '/';

$preInformationMD = file_get_contents(__DIR__ . '/readme.md');

$parseDown = new Parsedown();
$parseDown->setMarkupEscaped(true);
$preInformation = $parseDown->parse($preInformationMD);

$preInformation = strip_tags($preInformation);

$preInformation .= "\n\nCurrent XamppDir is $xamppDir\n\n";

echo $preInformation;
$input = '';
//$input        = readline('Do you want to continue (yes/no)]? ');
$inputTrimmed = trim($input);

if ($inputTrimmed === 'yes' || $inputTrimmed === 'y') {

    echo "Start: \n\n";

    $replacerIniPath = realpath(__DIR__ . '/replacement.ini');

    $updateController = new UpdateController();
    $updateController->update($xamppDir, $replacerIniPath);

    echo 'Finished - please check your xampps';

} else {

    $value              = parse_ini_file('replacement.ini', true);
    $value['templates'] = str_replace('\n', "\n", $value['templates']);

//    Debug::printText($value);


    echo "Aborted by user!\n\n";
}