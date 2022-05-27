<?php
/**
 * Long Read Plugin
 *
 * @package     LongReadPlugin
 * @author      dxw
 * @copyright   2020
 * @license     MIT
 *
 * @long-read-plugin
 * Plugin Name: Long Read Plugin
 * Plugin URI: https://github.com/dxw/long-read-plugin
 * Description: Adds the underlying functionality to enable long-reads
 * Author: dxw
 * Version: 1.0.3
 * Network: false
 */

$registrar = require __DIR__.'/src/load.php';
$registrar->register();
