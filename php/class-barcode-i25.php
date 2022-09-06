<?php
/**
 * BarCode Coder Library : I25
 *
 * @package Barcode
 * @subpackage Barcode_I25
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_I25 object.
 *
 * @since 2.0.0
 */
class Barcode_I25
{
    static private $encoding = array( 'NNWWN', 'WNNNW', 'NWNNW', 'WWNNN', 'NNWNW', 'WNWNN', 'NWWNN', 'NNNWW', 'WNNWN','NWNWN' );

    static public function compute( $code, $crc, $type )
    {
        if ( ! $crc )
        {
            if ( strlen( $code ) % 2 )
            {
                $code = '0' . $code;
            }
        }
        else
        {
            if ( ( $type == 'int25' ) && ( strlen( $code ) % 2 == 0 ) )
            {
                $code = '0' . $code;
            }

            $odd = true;

            $sum = 0;

            for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
            {
                $v = intval( $code[ $i ] );

                $sum += $odd ? 3 * $v : $v;

                $odd = ! $odd;
            }

            $code .= (string) ( ( 10 - $sum % 10 ) % 10 );
        }

        return $code;
    }

    static public function getDigit( $code, $crc, $type )
    {
        $code = self::compute( $code, $crc, $type );

        if ( $code == '' )
        {
            return $code;
        }

        $result = '';

        // Interleaved 2 of 5

        if ( $type == 'int25' )
        {
            // start

            $result .= '1010';

            // digits + CRC

            $end = strlen( $code ) / 2;

            for ( $i = 0; $i < $end; $i++ )
            {
                $c1 = $code[ 2 * $i ];

                $c2 = $code[ 2 * $i + 1 ];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[ $c1 ][ $j ] == 'W' )
                    {
                        $result .= '1';
                    }

                    $result .= '0';

                    if ( self::$encoding[ $c2 ][ $j ] == 'W' )
                    {
                        $result .= '0';
                    }
                }
            }

            // stop

            $result .= '1101';
        }
        else if ( $type == 'std25' )
        {
            // Standard 2 of 5 is a numeric-only barcode that has been in use a long time.
            // Unlike Interleaved 2 of 5, all of the information is encoded in the bars; the spaces are fixed width and are used only to separate the bars.
            // The code is self-checking and does not include a checksum.

            // start

            $result .= '11011010';

            // digits + CRC

            $end = strlen( $code );

            for ( $i = 0; $i < $end; $i++ )
            {
                $c = $code[ $i ];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[ $c ][ $j ] == 'W' )
                    {
                        $result .= '11';
                    }

                    $result .= '0';
                }
            }

            // stop

            $result .= '11010110';
        }

        return $result;
    }
}