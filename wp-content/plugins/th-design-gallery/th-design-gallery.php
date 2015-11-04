<?php
/**
 * Plugin Name: Project Design Gallery
 * Author: Tristan Hall
 * Description: A simple customized gallery for design work.
 * License: Commercial
 * Version: 1.0.0
 */
 
spl_autoload_register(
    /**
     * The primary auto loading function.
     * 
     * @access public
     * @static
     * @param string $className
     * @return void
     */
    function($className) {
        $baseName = plugin_basename(__FILE__);
        $basePath = WP_PLUGIN_DIR . '/' . substr($baseName, 0, strpos($baseName, '/'));
        $classArr = explode('\\', $className);
        if ($classArr[0] !== 'TH' || $classArr[1] !== 'DG') {
            return;
        }
        array_shift($classArr);
        array_shift($classArr);
        $filePath = $basePath . '/app/' . implode('/', $classArr) . '.php';
        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            throw new Exception('File "'.$filePath.'" could not be found for class "'.$className.'".');
        }
    }
);

$adminController = TH\DG\Factory::getController('admin');
$frontController = TH\DG\Factory::getController('front');
TH\DG\Helpers\Model::autodiscover();