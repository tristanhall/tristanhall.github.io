<?php

/**
 * Class: HTML
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */
class HTML {
   
   /**
    * Create a <link> element for displaying a favicon/shortcut icon.
    * 
    * @param type $href
    * @param type $type
    * @return string
    */
   public static function favicon($href, $type = 'png') {
       $html = '<link rel="shortcut icon"';
       switch($type) {
           case 'png':
               $html .= ' type="image/png"';
               break;
           case 'jpeg':
               $html .= ' type="image/jpeg"';
               break;
           case 'gif':
               $html .= ' type="image/gif"';
           case 'icon':
               $html .= ' type="image/vnd.microsoft.icon"';
               break;
       }
       $html .=  ' href="'.str_replace(' ','%20',$href).'" />';
       return $html;
   }
   
   /**
   * Create a <link> element for stylesheets.
   * 
   * @param type $href
   * @param type $attr
   * @param type $echo
   * @return string
   */
   public static function style($href, $attr = array(), $echo = FALSE) {
      $element = "<link rel='stylesheet' type='text/css' href='".str_replace(' ','%20',$href)."'";
      $element .= self::cattr($attr);
      $element .= ">";
      if($echo===FALSE) {
         return $element;
      } else {
         echo $element;
      }
   }
   
   /**
   * Create a <script> element for script files.
   * 
   * @param type $src
   * @param type $attr
   * @param type $echo
   * @return string
   */
   public static function script($src, $attr = array(), $echo = FALSE) {
      $element = "<script type='text/javascript' src='".str_replace(' ','%20',$src)."'";
      if(array_key_exists('defer', $attr) && $defer === TRUE) {
         $element .= ' defer';
      }
      $element .= self::cattr($attr);
      $element .= "></script>";
      if($echo===FALSE) {
         return $element;
      } else {
         echo $element;
      }
   }
   
   /**
   * Create an <img> element.
   * 
   * @param type $src
   * @param type $alt
   * @param type $attr
   * @param type $echo
   * @return string
   */
   public static function image($src, $alt = "", $attr = array(), $echo = FALSE) {
      $element = "<img src='".str_replace(' ','%20',$src)."' alt='".$alt."'";
      $element .= self::cattr($attr);
      $element .= ">";
      if($echo===FALSE) {
         return $element;
      } else {
         echo $element;
      }
   }
   
   /**
   * Create an <a> element for links.
   * 
   * @param type $href
   * @param type $text
   * @param type $attr
   * @return string
   */
   public static function link($href, $text, $attr) {
      $element = "<a href='".str_replace(' ','%20$',$href)."' ".self::cattr($attr).">".$text."</a>";
      return $element;
   }
   
   /**
   * Concatenate attributes for an element from an array.
   * 
   * @param type $attr
   * @return string
   */
   private static function cattr($attr = array()) {
      $html = '';
      if(!empty($attr)) {
         foreach($attr as $k=>$v) {
            $html .= " ".$k.'="'.$v.'"';
         }
      }
      return $html;
   }
            
}