<?php
/**
 * Generate a random string using base conversion?
 * @param int $number
 * @param int $fromBase
 * @param int $toBase
 * @return string
 */
if( !function_exists( 'base_convert_arbitrary' ) ) {
   function base_convert_arbitrary($number, $fromBase, $toBase) {
       $digits = '0123456789abcdefghijklmnopqrstuvwxyz';
       $length = strlen($number);
       $result = '';

       $nibbles = array();
       for ($i = 0; $i < $length; ++$i) {
           $nibbles[$i] = strpos($digits, $number[$i]);
       }

       do {
           $value = 0;
           $newlen = 0;
           for ($i = 0; $i < $length; ++$i) {
               $value = $value * $fromBase + $nibbles[$i];
               if ($value >= $toBase) {
                   $nibbles[$newlen++] = (int)($value / $toBase);
                   $value %= $toBase;
               } else if ($newlen > 0) {
                   $nibbles[$newlen++] = 0;
               }
           }
           $length = $newlen;
           $result = $digits[$value].$result;
       }
       while ($newlen != 0);
       return $result;
   }
}
   
/**
 * Counts how many bits are needed to represent $value
 * @param int $value
 * @return int
 */
if( !function_exists( 'count_bits' ) ) {
   function count_bits($value) {
       for($count = 0; $value != 0; $value >>= 1) {
           ++$count;
       }
       return $count;
   }
}
   
/**
 * Returns a base16 random string of at least $bits bits
 * Actual bits returned will be a multiple of 4 (1 hex digit)
 * @param string $bits
 * @return string
 */
if( !function_exists( 'random_bits' ) ) {
   function random_bits($bits) {
       $result = '';
       $accumulated_bits = 0;
       $total_bits = count_bits(mt_getrandmax());
       $usable_bits = intval($total_bits / 8) * 8;

       while ($accumulated_bits < $bits) {
           $bits_to_add = min($total_bits - $usable_bits, $bits - $accumulated_bits);
           if ($bits_to_add % 4 != 0) {
               // add bits in whole increments of 4
               $bits_to_add += 4 - $bits_to_add % 4;
           }

           // isolate leftmost $bits_to_add from mt_rand() result
           $more_bits = mt_rand() & ((1 << $bits_to_add) - 1);

           // format as hex (this will be safe)
           $format_string = '%0'.($bits_to_add / 4).'x';
           $result .= printf($format_string, $more_bits);
           $accumulated_bits += $bits_to_add;
       }

       return $result;
   }
}