<?php
/**
 * BarCode Coder Library : 93
 *
 * @package Barcode
 * @subpackage Barcode_93
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_93 object.
 *
 * @since 2.0.0
 */
class Barcode_93
{
    static private $encoding = array( '100010100', '101001000', '101000100', '101000010', '100101000', '100100100', '100100010', '101010000', '100010010', '100001010', '110101000', '110100100', '110100010', '110010100', '110010010', '110001010', '101101000', '101100100', '101100010', '100110100', '100011010', '101011000', '101001100', '101000110', '100101100', '100010110', '110110100', '110110010', '110101100', '110100110', '110010110', '110011010', '101101100', '101100110', '100110110', '100111010', '100101110', '111010100', '111010010', '111001010', '101101110', '101110110', '110101110', '100100110', '111011010', '111010110', '100110010', '101011110' );

    static public function getDigit( $code, $crc )
    {
        // _ => ( $ ), ( % ), ( / ) et ( + )

        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%____*';

        $result = '';

        if ( strpos( $code, '*' ) !== false )
        {
            return '';
        }

        $code = strtoupper( $code );

        // start : *

        $result  .= self::$encoding[ 47 ];

        // digits

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $c = $code[ $i ];

            $index = strpos( $table, $c );

            if ( ( $c == '_' ) || ( $index === false ) )
            {
                return '';
            }

            $result .= self::$encoding[ $index ];
        }

        // checksum

        if ( $crc )
        {
            $weightC = 0;

            $weightSumC = 0;

            // start at 1 because the right-most character is 'C' checksum

            $weightK = 1;

            $weightSumK = 0;

            for ( $i = $len - 1; $i >- 1; $i-- )
            {
                $weightC = $weightC == 20 ? 1 : $weightC + 1;

                $weightK = $weightK == 15 ? 1 : $weightK + 1;

                $index = strpos( $table, $code[ $i ] );

                $weightSumC += $weightC * $index;

                $weightSumK += $weightK * $index;
            }

            $c = $weightSumC % 47;

            $weightSumK += $c;

            $k = $weightSumK % 47;

            $result .= self::$encoding[ $c ];

            $result .= self::$encoding[ $k ];
        }

        // stop : *

        $result  .= self::$encoding[ 47 ];

        // Terminaison bar

        $result  .= '1';

        return $result;
    }
}