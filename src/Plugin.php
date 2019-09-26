<?php

namespace Apps;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

/**
 * Plugin for Apps
 */
class Plugin extends BasePlugin
{
    public function bootstrap(PluginApplicationInterface $app)
    {
        $app->addPlugin('Skeleton');
        parent::bootstrap($app);
    }
}
