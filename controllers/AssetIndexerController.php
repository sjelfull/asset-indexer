<?php
/**
 * Asset Indexer plugin for Craft CMS
 *
 * AssetIndexer Controller
 *
 * @author    Fred Carlsen
 * @copyright Copyright (c) 2016 Fred Carlsen
 * @link      http://sjelfull.no
 * @package   AssetIndexer
 * @since     1.0.0
 */

namespace Craft;

use Sse\Event as SSEvent;
use Sse\SSE;

// Event handler
class EventHandler implements SSEvent
{
    public function update ()
    {
        //Here's the place to send data
        return 'Hello, world! ' . str_random();
    }

    public function check ()
    {
        //Here's the place to check when the data needs update
        return true;
    }
}

class AssetIndexerController extends BaseController
{
    public function actionIndex ()
    {
        $this->renderTemplate('assetindexer/AssetIndexer_Index', [
            'concurrentWorkers' => craft()->assetIndexer->getConcurrentWorkers(),
        ]);
    }

    public function actionStartIndexing ()
    {
        $id = craft()->request->getRequiredParam('id');

        craft()->assetIndexer->indexSource($id);

        $this->returnJson([ 'success' => true ]);
    }

    public function actionGetIndexStatus ()
    {
        $sse = new SSE(); //create a libSSE instance
        //$sse->set('sleep_time', 10);
        //$sse->set('exec_limit', 30);
        $sse->sleep_time = 10;
        $sse->exec_limit = 30;

        $sse->addEventListener('update_index', new EventHandler());
        $sse->start();//start the event loop

        //craft()->end();
    }

    public function actionGetSources ()
    {
        $sources = craft()->elementIndexes->getSources('Asset', 'index');
        $this->returnJson($sources);
    }
}