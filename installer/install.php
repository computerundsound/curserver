<?php /** @noinspection PhpComposerExtensionStubsInspection */

use app\hostfile\Host;
use app\hostfile\HostFileHandler;
use app\hostfile\HostList;
use app\hostfile\VHostFileHandler;
use app\hostfile\VHostFileList;
use app\installer\InfoPrinter\InfoPrinter;
use app\installer\UpdateController;
use app\repositories\hosts\HostRepositoryXML;
use app\viewer\MakeView;

define('CU_SEND_SESSION', false);

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

$appRootDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;

if ($inputTrimmed === 'yes' || $inputTrimmed === 'y') {

    echo "Start: \n\n";

    $smartyVhost   = new MakeView(CU_SMARTY_DIR);
    $vHostFileList = new VHostFileList();

    $hostFileHandler = new HostFileHandler(HOST_FILE_PATH);

    $hostList = new HostList();

    $hostFileHandler->addHostList($hostList);

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

    $hostList = $hostRepository->getAllHosts();

    foreach ($vHostFiles->getAllVHostFiles() as $vHostInfos) {

        $vHostFilePath = PATH_TO_VHOSTS . $vHostInfos['fileName'];

        $vhostFileHandler = new VHostFileHandler($smartyVhost,
                                                 $vHostInfos['templateName'],
                                                 $vHostFilePath);

        $vhostFileHandler->createFileIfNotExist();

        $vhostFileHandler->addHostList($hostList);
        try {
            $vhostFileHandler->buildContent(CU_PORT);
        } catch (Exception $e) {
            die('Unable to build host');
        }
        $vhostFileHandler->writeContentToVhostFile();
    }

    echo "Finished - please check your xampps\n\n";
    echo "\n\n";
    echo 'You can call http://localhost/ in your browser and insert your first host (curserver)';

} else {

    echo "Aborted by user!\n\n";
}