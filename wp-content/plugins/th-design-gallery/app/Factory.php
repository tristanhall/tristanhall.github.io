<?php

namespace TH\DG;

class Factory
{
    
    public static function getBasePath()
    {
        return WP_PLUGIN_DIR . '/' . substr(plugin_basename(__FILE__), 0, strpos(plugin_basename(__FILE__), '/'));
    }
    
    public static function getBaseUrl($blog_id, $path, $scheme)
    {
        return get_site_url($blog_id, $path, $scheme);
    }
    
    /**
     * Gets a new instance of a model.
     * 
     * @access public
     * @static
     * @param string $modelName
     * @return object
     */
    public static function getModel($modelName)
    {
        $modelName = ucfirst($modelName);
        if (class_exists('TH\\DG\\Models\\' . $modelName)) {
            $className = 'TH\\DG\\Models\\' . $modelName;
            $object = new $className();
            return $object;
        } else {
            throw new Exception('Class "TH\\DG\\Models\\'.$modelName.'" does not exist.');
        }
    }
    
    /**
     * Gets a new instance of a helper.
     * 
     * @access public
     * @static
     * @param string $modelName
     * @return object
     */
    public static function getHelper($helperName)
    {
        $helperName = ucfirst($helperName);
        if (class_exists('TH\\DG\\Helpers\\'.$helperName)) {
            $className = 'TH\\DG\\Helpers\\' . $helperName;
            $object = new $className();
            return $object;
        } else {
            throw new Exception('Class "TH\\DG\\Helpers\\'.$helperName.'" does not exist.');
        }
    }
    
    /**
     * Gets a new instance of a model.
     * 
     * @access public
     * @static
     * @param string $modelName
     * @return object
     */
    public static function getController($controllerName)
    {
        $controllerName = ucfirst($controllerName);
        if (class_exists('TH\\DG\\Controller\\'.$controllerName)) {
            $className = 'TH\\DG\\Controller\\' . $controllerName;
            $object = new $className();
            return $object;
        } else {
            throw new Exception('Class "TH\\DG\\Controller\\'.$controllerName.'" does not exist.');
        }
    }
    
}