<?php

namespace TH\DG\Controller;

class Admin extends Controller
{
    
    public function __construct()
    {
        $this->action('admin_enqueue_scripts', array(__CLASS__, 'loadScripts'));
    }
    
    public function loadScripts()
    {
        
    }
    
}