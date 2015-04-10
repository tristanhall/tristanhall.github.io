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

//Manually load WPAtomic for development
/*require_once( __DIR__.'/vendor/tristanhall/wpatomic/src/WPAtomic.php' );
require_once( __DIR__.'/vendor/tristanhall/wpatomic/src/Template.php' );
require_once( __DIR__.'/vendor/tristanhall/wpatomic/src/Post.php' );
require_once( __DIR__.'/vendor/tristanhall/wpatomic/src/Taxonomy.php' );
require_once( __DIR__.'/vendor/tristanhall/wpatomic/src/Mapper.php' );*/

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

\TH\WPAtomic\WPAtomic::init( __NAMESPACE__ );