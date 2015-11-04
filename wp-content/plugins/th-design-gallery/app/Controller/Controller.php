<?php

namespace TH\DG\Controller;

abstract class Controller
{
    
    protected function action($tag, $callback)
    {
        add_action($tag, $callback);
    }
    
    protected function filter($tag, $callback)
    {
        add_filter($tag, $callback);
    }
    
}