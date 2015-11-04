<?php

namespace TH\DG\Helpers;

use TH\DG\Factory;

class Model extends Helper
{
    
    private static $systemFiles = array('Model.php', 'Post.php', 'Term.php');
    
    public static function autodiscover()
    {
        $basePath = Factory::getBasePath();
        foreach (glob($basePath . '/app/Models/*') as $modelFile) {
            if (in_array(basename($modelFile), self::$systemFiles)) {
                continue;
            }
            $modelClass = str_replace('.php', '', basename($modelFile));
            $model = Factory::getModel($modelClass);
            if (is_object($model)) {
                $model->setup();
            }
        }
    }
    
}