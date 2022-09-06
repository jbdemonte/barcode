<?php
/**
 * BarCode Coder Library : 39
 *
 * @package Barcode
 * @subpackage Barcode_39
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_39 object.
 *
 * @since 2.0.0
 */
class Barcode_39
{
    static private $encoding = array( '101001101101', '110100101011', '101100101011', '110110010101', '101001101011', '110100110101', '101100110101', '101001011011', '110100101101', '101100101101', '110101001011', '101101001011', '110110100101', '101011001011', '110101100101', '101101100101', '101010011011', '110101001101', '101101001101', '101011001101', '110101010011', '101101010011', '110110101001', '101011010011', '110101101001', '101101101001', '101010110011', '110101011001', '101101011001', '101011011001', '110010101011', '100110101011', '110011010101', '100101101011', '110010110101', '100110110101', '100101011011', '110010101101', '100110101101', '100100100101', '100100101001', '100101001001', '101001001001', '100101101101' );

    static public function getDigit( $code )
    {
        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*';

        $result = '';

        $intercharacter = '0';

        if ( strpos( $code, '*' ) !== false )
        {
            return '';
        }

        // Add Start and Stop charactere : *

        $code = strtoupper( '*' . $code . '*' );

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[ $i ] );

            if ( $index === false )
            {
                return '';
            }

            if ( $i > 0 )
            {
                $result .= $intercharacter;
            }

            $result .= self::$encoding[ $index ];
        }

        return $result;
    }
}