<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.12.26 at 03:11 MEZ
 */

include_once __DIR__ . '/../inc/_close/includes/_application_viewer.php';

$tableName = \computerundsound\culibrary\CuNet::get_post('tableName');
$colName = \computerundsound\culibrary\CuNet::get_post('colName');
$replaceThis = \computerundsound\culibrary\CuNet::get_post('replace_this');
$replaceByThis = \computerundsound\culibrary\CuNet::get_post('replace_by_this');

if ('' !== $tableName && '' !== $colName) {

    $dataSets = $dbi_coo->selectAsArray($tableName);

    $allQueries = [];

    foreach ($dataSets as $dataSet) {

        if (array_key_exists($colName, $dataSet)) {

            $colContentOld = $dataSet[$colName];

            $colContentNew = preg_replace("|$replaceThis|", $replaceByThis, $colContentOld);

            $colContentNew = $dbi_coo->real_escape_string($colContentNew);
            $colContentOld = $dbi_coo->real_escape_string($colContentOld);

            $updateQuery = "UPDATE $tableName SET $colName='$colContentNew' WHERE $colName='$colContentOld'";

            $allQueries[] = $updateQuery;

            $dbi_coo->query($updateQuery);


        }


    }

}

$smarty_standard->assign('replaceData',
                         [
                             'tableName' => $tableName,
                             'colName' => $colName,
                             'replaceThis' => $replaceThis,
                             'replaceByThis' => $replaceByThis,
                         ]);

$smarty_standard->assign('queries', $allQueries);

$smarty_standard->display('replaceInMysqlTable.tpl');

