<?php
/**
 * Plugin Name: Stashbox
 * Plugin URI: http://tristanhall.com
 * Description: Keeps track of websites, MySQL credentials, FTP credentials, etc.
 * Author: Tristan Hall
 * Version: 1.0
 * License: Commercial
 */

namespace TH\Stashbox;

//Stashbox Helpers
require_once( __DIR__.'/helpers.php' );

//Composer Autoloader
require_once( __DIR__.'/vendor/autoload.php' );

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

\TH\WPAtomic\WPAtomic::init( __NAMESPACE__ );