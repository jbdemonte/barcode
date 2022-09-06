<?php
/**
 * BarCode Coder Library : Codabar
 *
 * @package Barcode
 * @subpackage Barcode_Codabar
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_Codabar object.
 *
 * @since 2.0.0
 */
class Barcode_Codabar
{
    static private $encoding = array( '101010011', '101011001', '101001011', '110010101', '101101001', '110101001', '100101011', '100101101', '100110101', '110100101', '101001101', '101100101', '1101011011', '1101101011', '1101101101', '1011011011', '1011001001', '1010010011', '1001001011', '1010011001' );

    static public function getDigit( $code )
    {
        $table = '0123456789-$:/.+';

        $result = '';

        $intercharacter = '0';

        // add start : A->D : arbitrary choose A

        $result .= self::$encoding[ 16 ] . $intercharacter;

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[ $i ] );

            if ( $index === false )
            {
                return '';
            }

            $result .= self::$encoding[ $index ] . $intercharacter;
        }

        // add stop : A->D : arbitrary choose A

        $result .= self::$encoding[ 16 ];

        return $result;
    }
}