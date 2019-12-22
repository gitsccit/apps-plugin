<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::load('Apps.app', 'default', true);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

if ($cache = Configure::consume('Cache')) {
    Cache::setConfig($cache);
}
