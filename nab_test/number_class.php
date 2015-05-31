<?php

class RomanNumeral
{
   
   /**
    * Store the characters to display for certain numbers.
    * 
    * @var array
    * @access private
    */
   private $char_map = array(
      1    => 'I',
      4    => 'IV',
      5    => 'V',
      9    => 'IX',
      10   => 'X',
      40   => 'XV',
      50   => 'L',
      90   => 'XC',
      100  => 'C',
      400  => 'CD',
      500  => 'D',
      900  => 'CM',
      1000 => 'M'
   );
   
   /**
    * Store the actual value of the number.
    * 
    * (default value: 0)
    * 
    * @var int
    * @access private
    */
   private $value = 0;
   
   /**
    * Store the formatted string of the number.
    * 
    * @var string
    * @access private
    */
   private $formatted_string = '0';
   
   public function __construct($value)
   {
      $this->value = intval($value);
   }
   
   /**
    * Swap out the character of a specific number.
    * 
    * @access public
    * @param mixed $number
    * @param mixed $character
    * @return void
    */
   public function change_character($number, $character)
   {
      if (array_key_exists($number, $this->char_map))
      {
         $this->char_map[$number] = $character;
      }
   }
   
   /**
    * Build and return the roman numeral version of the current number value.
    * 
    * @access public
    * @return string
    */
   public function formatted()
   {
      $int_value = $this->value;
      krsort($this->char_map)
      while ($int_value > 0)
      {
         foreach ($this->char_map as $num => $char)
         {
            if ($int_value >= $num)
            {
               $int_value -= $num;
               $this->formatted_string .= $char;
            }
         }
      }
      return $this->formatted_string;
   }
   
}

$romnum = new RomanNumeral(1234);
//$romnum->change_character(1, 'P');
//$romnum->change_character(5, 'Z');
echo "\n";
echo str_repeat('=', 15);
$romnum->change_character(5, 'Z');
echo "\n";
echo $romnum->formatted();
$romnum->change_character(5, 'Z');
echo "\n";
echo str_repeat('=', 15);
$romnum->change_character(5, 'Z');
echo "\n";