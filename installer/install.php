<?php /** @noinspection PhpComposerExtensionStubsInspection */

use app\installer\InfoPrinter\InfoPrinter;
use app\installer\UpdateController;

require_once __DIR__ . '/../inc/_close/includes/_application_top.php';

$xamppDir = dirname(__DIR__, 2) . '/';

$preInformationMD = file_get_contents(__DIR__ . '/readme.md');

$parseDown = new Parsedown();
$parseDown->setMarkupEscaped(true);
$preInformation = $parseDown->parse($preInformationMD);

$preInformation = strip_tags($preInformation);

$preInformation .= "\n\nCurrent XamppDir is $xamppDir\n\n";

echo $preInformation;

$input = 'yes';
//$input = readline('Do you want to continue? Enter "yes" or "no": ');

$inputTrimmed = trim($input);

$appRootDir = dirname(__DIR__) . '/';

if ($inputTrimmed === 'yes' || $inputTrimmed === 'y') {

    echo "Start: \n\n";

    $replacerIniPath = realpath(__DIR__ . '/replacement.ini');

    $updateController = new UpdateController($appRootDir);

    InfoPrinter::info('Starting. XamppContainerDir: ' . $xamppDir);

    $updateController->update($xamppDir, $replacerIniPath);


    echo "Finished - please check your xampps\n\n";
    echo "\n\n";
    echo 'You can call http://localhost/ in your browser and insert your first host (curserver)';

} else {

    echo "Aborted by user!\n\n";
}