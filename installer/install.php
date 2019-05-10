<?php /** @noinspection PhpComposerExtensionStubsInspection */

use app\hostfile\Host;
use app\hostfile\VHostFileHandler;
use app\hostfile\VHostFileList;
use app\installer\InfoPrinter\InfoPrinter;
use app\installer\UpdateController;
use app\repositories\hosts\HostRepositoryXML;
use app\viewer\MakeView;

require_once __DIR__ . '/../inc/_close/vendor/autoload.php';

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

    if (file_exists(__DIR__ . '/../_config.php') === false) {
        copy(__DIR__ . '/../_config.sample.php', __DIR__ . '/../_config.php');
    }

    include __DIR__ . '/../_config.php';

    $smartyVhost   = new MakeView(CU_SMARTY_DIR);
    $vHostFileList = new VHostFileList();

    $hostFileHandler->addHostList($hostList);


    foreach ($vHostFiles as $vHostFileName => $vHostInfos) {

        $vhostFileHandler = new VHostFileHandler($smartyVhost,
                                                 $vHostInfos['templateName'],
                                                 $vHostFileName);

        $vhostFileHandler->createFileIfNotExist();

    }


    $replacerIniPath = realpath(__DIR__ . '/replacement.ini');

    $updateController = new UpdateController($appRootDir);

    InfoPrinter::info('Starting. XamppContainerDir: ' . $xamppDir);

    $updateController->update($xamppDir, $replacerIniPath);

    $hostRepository = new HostRepositoryXML(XML_HOST_REPOSITORY_FILE);
    try {
        $hostRepository->saveFromArray(
            [
                Host::FieldName_tld          => 'curserver',
                Host::FieldName_vhost_htdocs => dirname(__DIR__) . '/',
                Host::FieldName_vhost_dir    => dirname(__DIR__) . '/',
                Host::FieldName_ip           => '127.0.0.1',
            ]
        );
    } catch (Exception $e) {
        die('ERROR saving curserver host');
    }


    echo "Finished - please check your xampps\n\n";
    echo "\n\n";
    echo 'You can call http://localhost/ in your browser and insert your first host (curserver)';

} else {

    echo "Aborted by user!\n\n";
}