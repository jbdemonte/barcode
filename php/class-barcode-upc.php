<?php
/**
 * BarCode Coder Library : UPC
 *
 * @package Barcode
 * @subpackage Barcode_UPC
 * @since 2.0.0
 */

/**
 * Core class used to implement the Barcode_UPC object.
 *
 * @since 2.0.0
 */
class Barcode_UPC
{
    static public function getDigit( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return BarcodeEAN::getDigit( $code, 'ean13' );
    }

    static public function compute( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return substr( BarcodeEAN::compute( $code, 'ean13' ), 1 );
    }
}