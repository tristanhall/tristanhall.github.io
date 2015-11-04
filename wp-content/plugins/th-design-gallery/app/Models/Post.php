<?php
    
namespace TH\DG\Models;

class Post extends Model
{
    
    protected $post = null;
    
    protected $postType = 'post';
    
    protected $postTitle = 'Post';
    
    public function __construct()
    {
        return $this;
    }
    
    public function setup()
    {
        $postArgs = array(
            
        );
        //register_post_type($this->postType, $postArgs);
    }
    
    public function load($postId)
    {
        $this->post = get_post($postId);
        $wpPost = new \ReflectionClass($this->post);
        $methods = $wpPost->getMethods();
        $properties = $wpPost->getProperties();
        foreach ($properties as $p) {
            $p->setAccessible(true);
            $name = $p->getName();
            $this->$name = $p->getValue($this->post);
        }
        foreach ($methods as $m) {
            $m->setAccessible(true);
            $name = $m->getName();
            if ($name == '__construct') {
                continue;
            }
            $this->$name = function(...$args) {
                if (empty($args)) {
                    $args = array();
                }
                return call_user_func_array($m->getClosure(), $args);
            };
        }
        return $this;
    }
    
}