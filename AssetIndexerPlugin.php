<?php
/**
 * Asset Indexer plugin for Craft CMS
 *
 * Index Asset Sources with many/large files easily and in parallel
 *
 * @author    Fred Carlsen
 * @copyright Copyright (c) 2016 Fred Carlsen
 * @link      http://sjelfull.no
 * @package   AssetIndexer
 * @since     1.0.0
 */

namespace Craft;

class AssetIndexerPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init ()
    {
        parent::init();

        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return Craft::t('Asset Indexer');
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return Craft::t('Index Asset Sources with many/large files easily and in parallel');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl ()
    {
        return 'https://github.com/sjelfull/assetindexer/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl ()
    {
        return 'https://raw.githubusercontent.com/sjelfull/assetindexer/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper ()
    {
        return 'Fred Carlsen';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl ()
    {
        return 'http://sjelfull.no';
    }

    /**
     * @return bool
     */
    public function hasCpSection ()
    {
        return true;
    }

    public function registerCpRoutes ()
    {
        return array(
            'assetindexer' => array( 'action' => 'AssetIndexer/index' )
        );
    }

    /**
     * @return array
     */
    protected function defineSettings ()
    {
        return array(
            'concurrentWorkers' => array( AttributeType::String, 'label' => 'Concurrent index workers', 'default' => 4 ),
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml ()
    {
        return craft()->templates->render('assetindexer/AssetIndexer_Settings', array(
            'settings' => $this->getSettings()
        ));
    }

    /**
     * @param mixed $settings The Widget's settings
     *
     * @return mixed
     */
    public function prepSettings ($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}