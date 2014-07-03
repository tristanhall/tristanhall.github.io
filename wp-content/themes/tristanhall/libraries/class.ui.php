<?php

/**
 * Class: UI
 * Author: Tristan Hall
 * Copyright 2013 Tristan Hall
 */

class UI {
   
   /**
    * Concatenates the attributes of an element
    * @param mixed $attrs
    * @return string
    */
   private static function cattr($attrs = array()) {
      $output = '';
      foreach($attrs as $k => $v) {
        $output .= ' '.$k.'="'.$v.'"';
      }
      return $output;
   }
   /**
    * Creates a button element.
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function button($atts = array(), $content = 'Lorem Ipsum') {
      $atts['class'] .= ' button';
      $output = '<button '.self::cattr($atts).'>'.$content.'</button>';
      return $output;
   }
   /**
    * Creates a 1 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function one($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-1 columns';
      } else {
         $atts['class'] .= ' large-1 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 2 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function two($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-2 columns';
      } else {
         $atts['class'] .= ' large-2 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 3 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function three($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-3 columns';
      } else {
         $atts['class'] .= ' large-3 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 4 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function four($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-4 columns';
      } else {
         $atts['class'] .= ' large-4 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 5 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function five($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-5 columns';
      } else {
         $atts['class'] .= ' large-5 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 6 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function six($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-6 columns';
      } else {
         $atts['class'] .= ' large-6 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 7 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function seven($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-7 columns';
      } else {
         $atts['class'] .= ' large-7 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 8 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function eight($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-8 columns';
      } else {
         $atts['class'] .= ' large-8 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 9 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function nine($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-9 columns';
      } else {
         $atts['class'] .= ' large-9 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 10 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function ten($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-10 columns';
      } else {
         $atts['class'] .= ' large-10 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 11 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function eleven($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-11 columns';
      } else {
         $atts['class'] .= ' large-11 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a 12 column div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function twelve($atts = array(), $content = 'Lorem Ipsum') {
      if($atts['small'] === true) {
         $atts['class'] .= ' small-12 columns';
      } else {
         $atts['class'] .= ' large-12 columns';
      }
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a panel div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function panel($atts = array(), $content = 'Lorem Ipsum') {
      $atts['class'] .= ' panel';
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a callout div
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function callout($atts = array(), $content = 'Lorem Ipsum') {
      $atts['class'] .= ' panel callout';
      $output = '<div '.self::cattr($atts).'>'.$content.'</div>';
      return $output;
   }
   /**
    * Creates a progress bar.
    * @param array $atts
    * @return string
    */
   public static function progress($atts = array()) {
      $atts['class'] .= ' progress';
      $amount = $atts['amount'];
      unset($atts['amount']);
      $output = '<div '.self::cattr($atts).'><span class="meter" style="width:'.number_format($amount, 1).'%"></span></div>';
      return $output;
   }
   /**
    * Creates an alert box div.
    * @param array $atts
    * @param string $content
    * @return string
    */
   public static function alert($atts = array(), $content = 'Lorem Ipsum') {
      if(isset($atts['type']) && $atts['type'] != '') {
         $atts['class'] .= ' alert-box '.$atts['type'];
         unset($atts['type']);
      } else {
         $atts['class'] .= ' alert-box';
      }
      $output = '<div data-alert '.self::cattr($atts).'>'.$content;
      if(!isset($atts['close']) || $atts['close'] != FALSE) {
         $output .= '<a href="#" class="close">&times;</a>';
      }
      $output .= '</div>';
      return $output;
   }
   
}