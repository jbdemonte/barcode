<?php
/**
 * BarCode Coder Library : EAN
 *
 * @package Barcode
 * @subpackage Barcode_EAN
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_EAN object.
 *
 * @since 2.0.0
 */
class Barcode_EAN
{
    static private $encoding = array( array( '0001101', '0100111', '1110010' ), array( '0011001', '0110011', '1100110' ), array( '0010011', '0011011', '1101100' ), array( '0111101', '0100001', '1000010' ), array( '0100011', '0011101', '1011100' ), array( '0110001', '0111001', '1001110' ), array( '0101111', '0000101', '1010000' ), array( '0111011', '0010001', '1000100' ), array( '0110111', '0001001', '1001000' ), array( '0001011', '0010111', '1110100' ) );

    static private $first = array( '000000','001011','001101','001110','010011','011001','011100','010101','010110','011010' );

    static public function getDigit( $code, $type )
    {
        // Check len ( 12 for ean13, 7 for ean8 )

        $len = $type == 'ean8' ? 7 : 12;

        $code = substr( $code, 0, $len );

        if ( ! preg_match( '`[0-9]{' . $len . '}`', $code ) )
        {
            return '';
        }

        // get checksum

        $code = self::compute( $code, $type );

        // process analyse

        // start

        $result = '101';

        if ( $type == 'ean8' )
        {
            // process left part

            for ( $i = 0; $i < 4; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 0 ];
            }

            // center guard bars

            $result .= '01010';

            // process right part

            for ( $i = 4; $i < 8; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 2 ];
            }

        }
        else
        {
            // ean13

            // extract first digit and get sequence

            $seq = self::$first[ intval( $code[ 0 ] ) ];

            // process left part

            for ( $i = 1; $i < 7; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ intval( $seq[ $i-1 ] ) ];
            }

            // center guard bars

            $result .= '01010';

            // process right part

            for ( $i = 7; $i < 13; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 2 ];
            }
        }

        // stop

        $result .= '101';

        return $result;
    }

    static public function compute( $code, $type )
    {
        $len = $type == 'ean13' ? 12 : 7;

        $code = substr( $code, 0, $len );

        if ( ! preg_match( '`[0-9]{' . $len . '}`', $code ) )
        {
            return '';
        }

        $sum = 0;

        $odd = true;

        for ( $i = $len - 1; $i >- 1; $i-- )
        {
            $sum += ( $odd ? 3 : 1 ) * intval( $code[ $i ] );

            $odd = ! $odd;
        }

        return $code . ( (string) ( ( 10 - $sum % 10 ) % 10 ) );
    }
}