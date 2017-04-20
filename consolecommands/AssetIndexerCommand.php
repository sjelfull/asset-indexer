<?php
/**
 * Asset Indexer plugin for Craft CMS
 *
 * AssetIndexer Command
 *
 * @author    Fred Carlsen
 * @copyright Copyright (c) 2016 Fred Carlsen
 * @link      http://sjelfull.no
 * @package   AssetIndexer
 * @since     1.0.0
 */

namespace Craft;

class AssetIndexerCommand extends BaseCommand
{
    /**
     * ./craft/app/etc/console/yiic businesslogic getIndexOverview
     */
    public function actionSaveIndex ($sourceIds = '', $returnOutput = false)
    {

        // Get batches
        $batches   = array();
        $sessionId = craft()->assetIndexing->getIndexingSessionId();

        // Selection of sources or all sources?
        if ( $sourceIds ) {
            $sourceIds = explode(',', $sourceIds);
        }
        else {
            $sourceIds = craft()->assetSources->getViewableSourceIds();
        }

        $missingFolders = array();
        $grandTotal     = 0;

        foreach ($sourceIds as $sourceId) {
            // Get the indexing list
            $indexList = craft()->assetIndexing->getIndexListForSource($sessionId, $sourceId);

            if ( !empty($indexList['error']) ) {
                echo json_encode($indexList);

                return 0;
            }

            if ( isset($indexList['missingFolders']) ) {
                $missingFolders += $indexList['missingFolders'];
            }

            $batch = array();

            for ($i = 0; $i < $indexList['total']; $i++) {
                $batch[] = [
                    'sessionId' => $sessionId,
                    'sourceId'  => $sourceId,
                    'total'     => $indexList['total'],
                    'offset'    => $i,
                    'process'   => 1,
                ];
            }

            $batches[] = $batch;
        }


        // Overview

        $assetsSourcesBeingIndexed = $sourceIds;
        $assetsMissingFolders      = $missingFolders;

        $job = [
            'batches' => $batches,
            'total'   => $grandTotal,
        ];

        // Make sure folder exists and is writeable
        // Loop through batches and save to a csv file, to be parsed by shell script
        // Write to file
        $folderPath = craft()->path->getTempPath() . 'assetindexer' . DIRECTORY_SEPARATOR;
        IOHelper::ensureFolderExists($folderPath);

        $index = fopen($folderPath . 'index.csv', 'w');

        foreach ($batches as $batch) {
            foreach ($batch as $line) {
                fputcsv($index, array_values($line), "\t");
            }
        }

        fclose($index);

        if ( $returnOutput ) {
            echo json_encode($job);
        }

        return 1;
    }

    public function actionTest ($id = 'nothing', $offset = 0)
    {
        echo 'Indexed: ' . $id . ' with offset ' . $offset;

        return 1;
    }

    /**
     * ./craft/app/etc/console/yiic businesslogic --offset=x --sourceId=y --sessionId=z
     */
    public function actionStartIndexing ()
    {
        $logPath = craft()->path->getTempPath() . 'assetindexer' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
        IOHelper::ensureFolderExists($logPath);

        chdir(realpath(__DIR__ . '../scripts/'));

        $appPath  = craft()->path->getAppPath();
        $yiicPath = $appPath . 'etc/console/yiic';

        //ElasticSearchPlugin::log('Created logs folder at ' . BASEPATH . 'logs', LogLevel::Info, $force = true);

        shell_exec('bash start-indexing.sh  > ' . $logPath . '/indexing.log 2>&1 & echo $!');

        return 1;

        //return 0;
    }

    public function actionIndex ($offset = '', $sourceId = '', $sessionId = '')
    {
        if ( $offset ) {
            $index = craft()->assetIndexing->processIndexForSource($sessionId, $offset, $sourceId);

            if ( $index ) {
                echo sprintf("Processed offset: %s for source %s", $offset, $sourceId);

                return 1;
            }
        }

        return 0;
    }

    public function actionCleanUpIndex ()
    {
        // Get overview
        /*$sourceIds      = $assetsSourcesBeingIndexed;
        $missingFiles   = craft()->assetIndexing->getMissingFiles($sourceIds, $sessionId);
        $missingFolders = $assetsMissingFolders;

        $responseArray = array();

        if ( !empty($missingFiles) || !empty($missingFolders) ) {
            $responseArray['confirm'] = craft()->templates->render('assets/_missing_items', array( 'missingFiles' => $missingFiles, 'missingFolders' => $missingFolders ));
            $responseArray['params']  = array( 'finish' => 1 );
        }
        // Clean up stale indexing data (all sessions that have all recordIds set)
        $sessionsInProgress = craft()->db->createCommand()
                                         ->select('sessionId')
                                         ->from('assetindexdata')
                                         ->where('recordId IS NULL')
                                         ->group('sessionId')
                                         ->queryScalar();

        if ( empty($sessionsInProgress) ) {
            craft()->db->createCommand()->delete('assetindexdata');
        }
        else {
            craft()->db->createCommand()->delete('assetindexdata', array( 'not in', 'sessionId', $sessionsInProgress ));
        }*/

    }
}