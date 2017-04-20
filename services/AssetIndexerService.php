<?php
/**
 * Asset Indexer plugin for Craft CMS
 *
 * AssetIndexer Service
 *
 * @author    Fred Carlsen
 * @copyright Copyright (c) 2016 Fred Carlsen
 * @link      http://sjelfull.no
 * @package   AssetIndexer
 * @since     1.0.0
 */

namespace Craft;

class AssetIndexerService extends BaseApplicationComponent
{
    /**
     */
    public function getConcurrentWorkers()
    {
        return 4;
    }

}