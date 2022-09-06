<?php
/**
 * BarCode Coder Library : MSI
 *
 * @package Barcode
 * @subpackage Barcode_MSI
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_MSI object.
 *
 * @since 2.0.0
 */
class Barcode_MSI
{
    static private $encoding = array( '100100100100', '100100100110', '100100110100', '100100110110', '100110100100', '100110100110', '100110110100', '100110110110', '110100100100', '110100100110' );

    static public function compute( $code, $crc )
    {
        if ( is_array( $crc ) )
        {
            if ( $crc[ 'crc1' ] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc[ 'crc1' ] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
            if ( $crc[ 'crc2' ] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc[ 'crc2' ] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
        }
        else if ( $crc )
        {
            $code = self::computeMod10( $code );
        }

        return $code;
    }

    static private function computeMod10( $code )
    {
        $len = strlen( $code );

        $toPart1 = $len % 2;

        $n1 = 0;

        $sum = 0;

        for ( $i = 0; $i < $len; $i++ )
        {
            if ( $toPart1 )
            {
                $n1 = 10 * $n1 + intval( $code[ $i ] );
            }
            else
            {
                $sum += intval( $code[ $i ] );
            }

            $toPart1 = ! $toPart1;
        }

        $s1 = (string) ( 2 * $n1 );

        $len = strlen( $s1 );

        for ( $i = 0; $i < $len; $i++ )
        {
            $sum += intval( $s1[ $i ] );
        }

        return $code . ( (string) ( 10 - $sum % 10 ) % 10 );
    }

    static private function computeMod11( $code )
    {
        $sum = 0;

        $weight = 2;

        for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
        {
            $sum += $weight * intval( $code[ $i ] );

            $weight = $weight == 7 ? 2 : $weight + 1;
        }

        return $code . ( (string) ( 11 - $sum % 11 ) % 11 );
    }

    static public function getDigit( $code, $crc )
    {
        if ( preg_match( '`[^0-9]`', $code ) )
        {
            return '';
        }

        $index = 0;

        $result = '';

        $code = self::compute( $code, false );

        // start

        $result = '110';

        // digits

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $result .= self::$encoding[ intval( $code[ $i ] ) ];
        }

        // stop

        $result .= '1001';

        return $result;
    }
}