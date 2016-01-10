<?php
/**
 * Application: BarCode Coder Library (BCCL)
 *
 * @package BCCL
 * @version 2.0.5
 * @porting PHP
 *
 * @date    2013-01-06
 * @author  DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
 * @author  HOUREZ Jonathan
 *
 * @date    2013-12-24
 *          Leszek Boroch <borek@borek.net.pl>
 *          Modification in class Barcode128 to enable encoding extended characters
 *          (ASCII above 127). To use barcodes, keypad emulation must be enabled in scanner configuration
 *          (tested with Motorola/Symbol LS2208).
 *
 * @website http://barcode-coder.com/
 *
 * @licence http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 * @licence http://www.gnu.org/licenses/gpl.html
 */

/**
 * Barcode Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class Barcode
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function gd( $image_resource, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null )
    {
        return self::_draw( __FUNCTION__, $image_resource, $color, $x, $y, $angle, $type, $datas, $width, $height );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function fpdf( $image_resource, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null )
    {
        return self::_draw( __FUNCTION__, $image_resource, $color, $x, $y, $angle, $type, $datas, $width, $height );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function raw( $type, $datas )
    {
        $digit = '';
        $hri   = '';
        $code  = '';
        $crc   = true;
        $rect  = false;

        if ( is_array( $datas ) )
        {
            foreach ( array( 'code' => '', 'crc' => true, 'rect' => false ) as $v => $def )
            {
                $$v = isset( $datas[$v] ) ? $datas[$v] : $def;
            }

            $code = $code;
        }
        else
        {
            $code = $datas;
        }

        if ( $code == '' ) return false;

        $code = (string) $code;

        $type = strtolower( $type );

        switch( $type )
        {
            case 'std25':
            case 'int25':
            $digit = BarcodeI25::getDigit( $code, $crc, $type );
            $hri = BarcodeI25::compute( $code, $crc, $type );
            break;
            case 'ean8':
            case 'ean13':
            $digit = BarcodeEAN::getDigit( $code, $type );
            $hri = BarcodeEAN::compute( $code, $type );
            break;
            case 'upc':
            $digit = BarcodeUPC::getDigit( $code );
            $hri = BarcodeUPC::compute( $code );
            break;
            case 'code11':
            $digit = Barcode11::getDigit( $code );
            $hri = $code;
            break;
            case 'code39':
            $digit = Barcode39::getDigit( $code );
            $hri = $code;
            break;
            case 'code93':
            $digit = Barcode93::getDigit( $code, $crc );
            $hri = $code;
            break;
            case 'code128':
            $digit = Barcode128::getDigit( $code );
            $hri = $code;
            break;
            case 'codabar':
            $digit = BarcodeCodabar::getDigit( $code );
            $hri = $code;
            break;
            case 'msi':
            $digit = BarcodeMSI::getDigit( $code, $crc );
            $hri = BarcodeMSI::compute( $code, $crc );
            break;
            case 'datamatrix':
            $digit = BarcodeDatamatrix::getDigit( $code, $rect );
            $hri = $code;
            break;
        }

        return array( $digit, $hri );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.4
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    static private function _draw( $call, $res, $color, $x, $y, $angle, $type, $datas, $width, $height )
    {
        $digit = '';
        $hri   = '';

        list( $digit, $hri ) = self::raw( $type, $datas );

        $type = strtolower( $type );

        if ( $digit == '' ) return false;

        if ( $type == 'datamatrix' )
        {
            $width = is_null( $width ) ? 5 : $width;
            $height = $width;
        }
        else
        {
            $width = is_null( $width ) ? 1 : $width;
            $height = is_null( $height ) ? 50 : $height;

            $digit = self::bitStringTo2DArray($digit);
        }

        if ( $call == 'gd' )
        {
            $result = self::digitToGDRenderer( $res, $color, $x, $y, $angle, $width, $height, $digit );
        }
        else if ( $call == 'fpdf' )
        {
            $result = self::digitToFPDFRenderer( $res, $color, $x, $y, $angle, $width, $height, $digit );
        }

        $result['hri'] = $hri;

        return $result;
    }

    /**
     * Convert a bit string to an array of array of bit char
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function bitStringTo2DArray( $digit )
    {
        $d = array();

        $len = strlen( $digit );

        for ( $i = 0; $i < $len; $i++ )
        {
            $d[$i] = $digit[$i];
        }

        return ( array( $d ) );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        $lines = count( $digit );

        $columns = count( $digit[0] );

        $angle = deg2rad( -$angle );

        $cos = cos( $angle );

        $sin = sin( $angle );

        self::_rotate( $columns * $mw / 2, $lines * $mh / 2, $cos, $sin , $x, $y );

        $xi -= $x;
        $yi -= $y;

        foreach ( $digit as $y_index => $y_value )
        {
            foreach ( $y_value as $x_index => $x_value )
            {
                if ( $digit[$y_index][$x_index] == '1' )
                {
                    $x1 = $x_index * $mw;
                    $y1 = $y_index * $mh;

                    $x2 = ( $x_index + 1 ) * $mw;
                    $y2 = ( $y_index + 1 ) * $mh;

                    self::_rotate( $x1, $y1, $cos, $sin, $xA, $yA );
                    self::_rotate( $x2, $y1, $cos, $sin, $xB, $yB );
                    self::_rotate( $x2, $y2, $cos, $sin, $xC, $yC );
                    self::_rotate( $x1, $y2, $cos, $sin, $xD, $yD );

                    $fn( array( $xA + $xi, $yA + $yi, $xB + $xi, $yB + $yi, $xC + $xi, $yC + $yi, $xD + $xi, $yD + $yi ) );
                }

            }
        }

        return self::result( $xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin );
    }

    /**
     * GD barcode renderer
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToGDRenderer( $image_resource, $color, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        $fn = function( $points ) use ( $image_resource, $color )
        {
            imagefilledpolygon( $image_resource, $points, 4, $color );
        };

        return self::digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit );
    }

    /**
     * FPDF barcode renderer
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToFPDFRenderer( $pdf, $color, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        if ( ! is_array( $color ) )
        {
            if ( preg_match( '`([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})`i', $color, $m ) )
            {
                $color = array( hexdec( $m[1] ), hexdec( $m[2] ), hexdec( $m[3] ) );
            }
            else
            {
                $color = array( 0, 0, 0 );
            }
        }

        $color = array_values( $color );

        $pdf->SetDrawColor( $color[0], $color[1], $color[2] );
        $pdf->SetFillColor( $color[0], $color[1], $color[2] );

        $fn = function( $points ) use ( $pdf )
        {
            $op = 'f';

            $h = $pdf->h;
            $k = $pdf->k;

            $points_string = '';

            for( $i = 0; $i < 8; $i += 2 )
            {
                $points_string .= sprintf( '%.2F %.2F', $points[$i] * $k, ( $h - $points[$i+1] ) * $k );
                $points_string .= $i ? ' l ' : ' m ';
            }

            $pdf->_out( $points_string . $op );
        };

        return self::digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function result( $xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin )
    {
        self::_rotate( 0, 0, $cos, $sin , $x1, $y1 );
        self::_rotate( $columns * $mw, 0, $cos, $sin , $x2, $y2 );
        self::_rotate( $columns * $mw, $lines * $mh, $cos, $sin , $x3, $y3 );
        self::_rotate( 0, $lines * $mh, $cos, $sin , $x4, $y4 );

        return array( 'width' => $columns * $mw, 'height'=> $lines * $mh, 'p1' => array( 'x' => $xi + $x1, 'y' => $yi + $y1 ), 'p2' => array( 'x' => $xi + $x2, 'y' => $yi + $y2 ), 'p3' => array( 'x' => $xi + $x3, 'y' => $yi + $y3 ), 'p4' => array( 'x' => $xi + $x4, 'y' => $yi + $y4 ) );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function _rotate( $x1, $y1, $cos, $sin , &$x, &$y )
    {
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function rotate( $x1, $y1, $angle , &$x, &$y )
    {
        $angle = deg2rad( -$angle );

        $cos = cos( $angle );
        $sin = sin( $angle );

        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }
}

/**
 * BarcodeI25 Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeI25
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( 'NNWWN', 'WNNNW', 'NWNNW', 'WWNNN', 'NNWNW', 'WNWNN', 'NWWNN', 'NNNWW', 'WNNWN', 'NWNWN' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $crc, $type )
    {
        if ( ! $crc )
        {
            if ( strlen( $code ) % 2 ) $code = '0' . $code;
        }
        else
        {
            if ( ( $type == 'int25' ) && ( strlen( $code ) % 2 == 0 ) ) $code = '0' . $code;

            $odd = true;

            $sum = 0;

            for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
            {
                $v = intval( $code[$i] );

                $sum += $odd ? 3 * $v : $v;

                $odd = ! $odd;
            }

            $code .= (string) ( ( 10 - $sum % 10 ) % 10 );
        }

        return ( $code );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc, $type )
    {
        $code = self::compute( $code, $crc, $type );

        if ( $code == '' ) return ( $code );

        $result = '';

        if ( $type == 'int25' )
        {
            //-------------------------------------------------
            // Interleaved 2 of 5
            //-------------------------------------------------

            //-------------------------------------------------
            // start
            //-------------------------------------------------

            $result .= '1010';

            //-------------------------------------------------
            // digits + CRC
            //-------------------------------------------------

            $end = strlen( $code ) / 2;

            for ( $i = 0; $i < $end; $i++ )
            {
                $c1 = $code[2*$i];
                $c2 = $code[2*$i+1];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[$c1][$j] == 'W' ) $result .= '1';

                    $result .= '0';

                    if ( self::$encoding[$c2][$j] == 'W' ) $result .= '0';
                }
            }

            //-------------------------------------------------
            // stop
            //-------------------------------------------------

            $result .= '1101';
        }
        else if ( $type == 'std25' )
        {
            // Standard 2 of 5 is a numeric-only barcode that has been in use a long time.
            // Unlike Interleaved 2 of 5, all of the information is encoded in the bars; the spaces are fixed width and are used only to separate the bars.
            // The code is self-checking and does not include a checksum.

            //-------------------------------------------------
            // start
            //-------------------------------------------------

            $result .= '11011010';

            //-------------------------------------------------
            // digits + CRC
            //-------------------------------------------------

            $end = strlen( $code );

            for ( $i = 0; $i < $end; $i++ )
            {
                $c = $code[$i];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[$c][$j] == 'W' ) $result .= '11';

                    $result .= '0';
                }
            }

            //-------------------------------------------------
            // stop
            //-------------------------------------------------

            $result .= '11010110';
        }

        return ( $result );
    }
}

/**
 * BarcodeEAN Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeEAN
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( array( '0001101', '0100111', '1110010' ), array( '0011001', '0110011', '1100110' ), array( '0010011', '0011011', '1101100' ), array( '0111101', '0100001', '1000010' ), array( '0100011', '0011101', '1011100' ), array( '0110001', '0111001', '1001110' ), array( '0101111', '0000101', '1010000' ), array( '0111011', '0010001', '1000100' ), array( '0110111', '0001001', '1001000' ), array( '0001011', '0010111', '1110100' ) );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $first = array( '000000', '001011', '001101', '001110', '010011', '011001', '011100', '010101', '010110', '011010' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $type )
    {
        //-------------------------------------------------
        // Check len ( 12 for ean13, 7 for ean8 )
        //-------------------------------------------------

        $len = $type == 'ean8' ? 7 : 12;

        $code = substr( $code, 0, $len );

        if ( !preg_match( '`[0-9]{'.$len.'}`', $code ) ) return ( '' );

        //-------------------------------------------------
        // get checksum
        //-------------------------------------------------

        $code = self::compute( $code, $type );

        //-------------------------------------------------
        // process analyse
        //-------------------------------------------------

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '101';

        if ( $type == 'ean8' )
        {
            //-------------------------------------------------
            // process left part
            //-------------------------------------------------

            for ( $i = 0; $i < 4; $i++ )
            {
                $result .= self::$encoding[ intval( $code[$i] ) ][0];
            }

            //-------------------------------------------------
            // center guard bars
            //-------------------------------------------------

            $result .= '01010';

            //-------------------------------------------------
            // process right part
            //-------------------------------------------------

            for ( $i = 4; $i < 8; $i++ )
            {
                $result .= self::$encoding[ intval( $code[$i] ) ][2];
            }
        }
        else
        {
            //-------------------------------------------------
            // ean13
            //-------------------------------------------------

            //-------------------------------------------------
            // extract first digit and get sequence
            //-------------------------------------------------

            $seq = self::$first[ intval( $code[0] ) ];

            //-------------------------------------------------
            // process left part
            //-------------------------------------------------

            for ( $i = 1; $i < 7; $i++ )
            {
                $result .= self::$encoding[ intval( $code[$i] ) ][ intval( $seq[$i-1] ) ];
            }

            //-------------------------------------------------
            // center guard bars
            //-------------------------------------------------

            $result .= '01010';

            //-------------------------------------------------
            // process right part
            //-------------------------------------------------

            for ( $i = 7; $i < 13; $i++ )
            {
                $result .= self::$encoding[ intval( $code[$i] ) ][2];
            }
        }

        //-------------------------------------------------
        // ean13
        //-------------------------------------------------

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '101';

        return ( $result );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $type )
    {
        $len = $type == 'ean13' ? 12 : 7;

        $code = substr( $code, 0, $len );

        if ( !preg_match( '`[0-9]{'.$len.'}`', $code ) ) return ( '' );

        $sum = 0;

        $odd = true;

        for ( $i = $len - 1; $i >- 1; $i-- )
        {
            $sum += ( $odd ? 3 : 1 ) * intval( $code[$i] );

            $odd = ! $odd;
        }

        return ( $code . ( (string) ( ( 10 - $sum % 10 ) % 10 ) ) );
    }
}

/**
 * BarcodeUPC Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeUPC
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return BarcodeEAN::getDigit( $code, 'ean13' );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return substr( BarcodeEAN::compute( $code, 'ean13' ), 1 );
    }
}

/**
 * BarcodeMSI Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeMSI
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( '100100100100', '100100100110', '100100110100', '100100110110', '100110100100', '100110100110', '100110110100', '100110110110', '110100100100', '110100100110' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $crc )
    {
        if ( is_array( $crc ) )
        {
            if ( $crc['crc1'] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc['crc1'] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
            if ( $crc['crc2'] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc['crc2'] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
        }
        else if ( $crc )
        {
            $code = self::computeMod10( $code );
        }
        return ( $code );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function computeMod10( $code )
    {
        $len = strlen( $code );

        $toPart1 = $len % 2;

        $n1 = 0;

        $sum = 0;

        for ( $i = 0; $i < $len; $i++ )
        {
            if ( $toPart1 )
            {
                $n1 = 10 * $n1 + intval( $code[$i] );
            }
            else
            {
                $sum += intval( $code[$i] );
            }

            $toPart1 = ! $toPart1;
        }

        $s1 = (string) ( 2 * $n1 );

        $len = strlen( $s1 );

        for ( $i = 0; $i < $len; $i++ )
        {
            $sum += intval( $s1[$i] );
        }

        return ( $code . ( (string) ( 10 - $sum % 10 ) % 10 ) );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function computeMod11( $code )
    {
        $sum = 0;

        $weight = 2;

        for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
        {
            $sum += $weight * intval( $code[$i] );

            $weight = $weight == 7 ? 2 : $weight + 1;
        }

        return ( $code . ( (string) ( 11 - $sum % 11 ) % 11 ) );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc )
    {
        if ( preg_match( '`[^0-9]`', $code ) ) return '';

        $index = 0;

        $result = '';

        $code = self::compute( $code, false );

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '110';

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $result .= self::$encoding[ intval( $code[$i] ) ];
        }

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '1001';

        return ( $result );
    }
}

/**
 * Barcode11 Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class Barcode11
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( '101011', '1101011', '1001011', '1100101', '1011011', '1101101', '1001101', '1010011', '1101001', '110101', '101101' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        if ( preg_match( '`[^0-9\-]`', $code ) ) return '';

        $result = '';

        $intercharacter = '0';

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '1011001' . $intercharacter;

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = $code[$i] == '-' ? 10 : intval( $code[$i] );

            $result .= self::$encoding[$index] . $intercharacter;
        }

        //-------------------------------------------------
        // checksum
        //-------------------------------------------------

        $weightC = 0;

        $weightSumC = 0;

        $weightK = 1; // start at 1 because the right-most character is 'C' checksum

        $weightSumK = 0;

        for ( $i = $len - 1; $i >- 1; $i-- )
        {
            $weightC = $weightC == 10 ? 1 : $weightC + 1;
            $weightK = $weightK == 10 ? 1 : $weightK + 1;

            $index = $code[$i] == '-' ? 10 : intval( $code[$i] );

            $weightSumC += $weightC * $index;
            $weightSumK += $weightK * $index;
        }

        $c = $weightSumC % 11;

        $weightSumK += $c;

        $k = $weightSumK % 11;

        $result .= self::$encoding[$c] . $intercharacter;

        if ( $len >= 10 )
        {
            $result .= self::$encoding[$k] . $intercharacter;
        }

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '1011001';

        return ( $result );
    }
}

/**
 * Barcode39 Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class Barcode39
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( '101001101101', '110100101011', '101100101011', '110110010101', '101001101011', '110100110101', '101100110101', '101001011011', '110100101101', '101100101101', '110101001011', '101101001011', '110110100101', '101011001011', '110101100101', '101101100101', '101010011011', '110101001101', '101101001101', '101011001101', '110101010011', '101101010011', '110110101001', '101011010011', '110101101001', '101101101001', '101010110011', '110101011001', '101101011001', '101011011001', '110010101011', '100110101011', '110011010101', '100101101011', '110010110101', '100110110101', '100101011011', '110010101101', '100110101101', '100100100101', '100100101001', '100101001001', '101001001001', '100101101101' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*';

        $result = '';

        $intercharacter = '0';

        if ( strpos( $code, '*' ) !== false ) return ( '' );

        //-------------------------------------------------
        // Add Start and Stop charactere : *
        //-------------------------------------------------

        $code = strtoupper( '*' . $code . '*' );

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[$i] );

            if ( $index === false ) return ( '' );

            if ( $i > 0 ) $result .= $intercharacter;

            $result .= self::$encoding[$index];
        }

        return ( $result );
    }
}

/**
 * Barcode93 Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class Barcode93
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( '100010100', '101001000', '101000100', '101000010', '100101000', '100100100', '100100010', '101010000', '100010010', '100001010', '110101000', '110100100', '110100010', '110010100', '110010010', '110001010', '101101000', '101100100', '101100010', '100110100', '100011010', '101011000', '101001100', '101000110', '100101100', '100010110', '110110100', '110110010', '110101100', '110100110', '110010110', '110011010', '101101100', '101100110', '100110110', '100111010', '100101110', '111010100', '111010010', '111001010', '101101110', '101110110', '110101110', '100100110', '111011010', '111010110', '100110010', '101011110' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc )
    {
        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%____*'; // _ => ( $ ), ( % ), ( / ) et ( + )

        $result = '';

        if ( strpos( $code, '*' ) !== false ) return ( '' );

        $code = strtoupper( $code );

        //-------------------------------------------------
        // start : *
        //-------------------------------------------------

        $result .= self::$encoding[47];

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $c = $code[$i];

            $index = strpos( $table, $c );

            if ( ( $c == '_' ) || ( $index === false ) ) return ( '' );

            $result .= self::$encoding[$index];
        }

        //-------------------------------------------------
        // checksum
        //-------------------------------------------------

        if ( $crc )
        {
            $weightC = 0;

            $weightSumC = 0;

            $weightK = 1; // start at 1 because the right-most character is 'C' checksum

            $weightSumK = 0;

            for ( $i = $len - 1; $i >- 1; $i-- )
            {
                $weightC = $weightC == 20 ? 1 : $weightC + 1;
                $weightK = $weightK == 15 ? 1 : $weightK + 1;

                $index = strpos( $table, $code[$i] );

                $weightSumC += $weightC * $index;
                $weightSumK += $weightK * $index;
            }

            $c = $weightSumC % 47;

            $weightSumK += $c;

            $k = $weightSumK % 47;

            $result .= self::$encoding[$c];
            $result .= self::$encoding[$k];
        }

        //-------------------------------------------------
        // stop : *
        //-------------------------------------------------

        $result .= self::$encoding[47];

        //-------------------------------------------------
        // Terminaison bar
        //-------------------------------------------------

        $result .= '1';

        return ( $result );
    }
}

/**
 * Barcode128 Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class Barcode128
{
    /**
     * DEFAULT
     *
     * descriptive encoding array, helpful when debugging
     * Value Table A Table B Table C ASCII Code  Character   Pattern
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array(
        '11011001100', //  0    Space   Space   00  0032 or 0212    Space or O  11011001100
        '11001101100', //  1    !   !   01  0033    !   11001101100
        '11001100110', //  2    "   "   02  0034    "   11001100110
        '10010011000', //  3    #   #   03  0035    #   10010011000
        '10010001100', //  4    $   $   04  0036    $   10010001100
        '10001001100', //  5    %   %   05  0037    %   10001001100
        '10011001000', //  6    &   &   06  0038    &   10011001000
        '10011000100', //  7    '   '   07  0039    '   10011000100
        '10001100100', //  8    (   (   08  0040    (   10001100100
        '11001001000', //  9    )   )   09  0041    )   11001001000
        '11001000100', //  10   *   *   10  0042    *   11001000100
        '11000100100', //  11   +   +   11  0043    +   11000100100
        '10110011100', //  12   ,   ,   12  0044    ,   10110011100
        '10011011100', //  13   -   -   13  0045    -   10011011100
        '10011001110', //  14   .   .   14  0046    .   10011001110
        '10111001100', //  15   /   /   15  0047    /   10111001100
        '10011101100', //  16   0   0   16  0048    0   10011101100
        '10011100110', //  17   1   1   17  0049    1   10011100110
        '11001110010', //  18   2   2   18  0050    2   11001110010
        '11001011100', //  19   3   3   19  0051    3   11001011100
        '11001001110', //  20   4   4   20  0052    4   11001001110
        '11011100100', //  21   5   5   21  0053    5   11011100100
        '11001110100', //  22   6   6   22  0054    6   11001110100
        '11101101110', //  23   7   7   23  0055    7   11101101110
        '11101001100', //  24   8   8   24  0056    8   11101001100
        '11100101100', //  25   9   9   25  0057    9   11100101100
        '11100100110', //  26   :   :   26  0058    :   11100100110
        '11101100100', //  27   ;   ;   27  0059    ;   11101100100
        '11100110100', //  28   <   <   28  0060    <   11100110100
        '11100110010', //  29   =   =   29  0061    =   11100110010
        '11011011000', //  30   >   >   30  0062    >   11011011000
        '11011000110', //  31   ?   ?   31  0063    ?   11011000110
        '11000110110', //  32   @   @   32  0064    @   11000110110
        '10100011000', //  33   A   A   33  0065    A   10100011000
        '10001011000', //  34   B   B   34  0066    B   10001011000
        '10001000110', //  35   C   C   35  0067    C   10001000110
        '10110001000', //  36   D   D   36  0068    D   10110001000
        '10001101000', //  37   E   E   37  0069    E   10001101000
        '10001100010', //  38   F   F   38  0070    F   10001100010
        '11010001000', //  39   G   G   39  0071    G   11010001000
        '11000101000', //  40   H   H   40  0072    H   11000101000
        '11000100010', //  41   I   I   41  0073    I   11000100010
        '10110111000', //  42   J   J   42  0074    J   10110111000
        '10110001110', //  43   K   K   43  0075    K   10110001110
        '10001101110', //  44   L   L   44  0076    L   10001101110
        '10111011000', //  45   M   M   45  0077    M   10111011000
        '10111000110', //  46   N   N   46  0078    N   10111000110
        '10001110110', //  47   O   O   47  0079    O   10001110110
        '11101110110', //  48   P   P   48  0080    P   11101110110
        '11010001110', //  49   Q   Q   49  0081    Q   11010001110
        '11000101110', //  50   R   R   50  0082    R   11000101110
        '11011101000', //  51   S   S   51  0083    S   11011101000
        '11011100010', //  52   T   T   52  0084    T   11011100010
        '11011101110', //  53   U   U   53  0085    U   11011101110
        '11101011000', //  54   V   V   54  0086    V   11101011000
        '11101000110', //  55   W   W   55  0087    W   11101000110
        '11100010110', //  56   X   X   56  0088    X   11100010110
        '11101101000', //  57   Y   Y   57  0089    Y   11101101000
        '11101100010', //  58   Z   Z   58  0090    Z   11101100010
        '11100011010', //  59   [   [   59  0091    [   11100011010
        '11101111010', //  60   \   \   60  0092    \   11101111010
        '11001000010', //  61   ]   ]   61  0093    ]   11001000010
        '11110001010', //  62   ^   ^   62  0094    ^   11110001010
        '10100110000', //  63   _   _   63  0095    _   10100110000
        '10100001100', //  64   nul `   64  0096    `   10100001100
        '10010110000', //  65   soh a   65  0097    a   10010110000
        '10010000110', //  66   stx b   66  0098    b   10010000110
        '10000101100', //  67   etx c   67  0099    c   10000101100
        '10000100110', //  68   eot d   68  0100    d   10000100110
        '10110010000', //  69   eno e   69  0101    e   10110010000
        '10110000100', //  70   ack f   70  0102    f   10110000100
        '10011010000', //  71   bel g   71  0103    g   10011010000
        '10011000010', //  72   bs  h   72  0104    h   10011000010
        '10000110100', //  73   ht  i   73  0105    i   10000110100
        '10000110010', //  74   lf  j   74  0106    j   10000110010
        '11000010010', //  75   vt  k   75  0107    k   11000010010
        '11001010000', //  76   ff  l   76  0108    l   11001010000
        '11110111010', //  77   cr  m   77  0109    m   11110111010
        '11000010100', //  78   s0  n   78  0110    n   11000010100
        '10001111010', //  79   s1  o   79  0111    o   10001111010
        '10100111100', //  80   dle p   80  0112    p   10100111100
        '10010111100', //  81   dc1 q   81  0113    q   10010111100
        '10010011110', //  82   dc2 r   82  0114    r   10010011110
        '10111100100', //  83   dc3 s   83  0115    s   10111100100
        '10011110100', //  84   dc4 t   84  0116    t   10011110100
        '10011110010', //  85   nak u   85  0117    u   10011110010
        '11110100100', //  86   syn v   86  0118    v   11110100100
        '11110010100', //  87   etb w   87  0119    w   11110010100
        '11110010010', //  88   can x   88  0120    x   11110010010
        '11011011110', //  89   em  y   89  0121    y   11011011110
        '11011110110', //  90   sub z   90  0122    z   11011110110
        '11110110110', //  91   esc {   91  0123    {   11110110110
        '10101111000', //  92   fs  |   92  0124    |   10101111000
        '10100011110', //  93   gs  }   93  0125    }   10100011110
        '10001011110', //  94   rs  ~   94  0126    ~   10001011110
        '10111101000', //  95   us  del 95  0200    E   10111101000
        '10111100010', //  96   Fnc 3   Fnc 3   96  0201    E   10111100010
        '11110101000', //  97   Fnc 2   Fnc2    97  0202    E   11110101000
        '11110100010', //  98   Shift   Shift   98  0203    E   11110100010
        '10111011110', //  99   Code C  Code C  99  0204    I   10111011110
        '10111101110', //  100  Code B  Fnc 4   Code B  0205    I   10111101110
        '11101011110', //  101  Fnc 4   Code A  Code A  0206    I   11101011110
        '11110101110', //  102  Fnc 1   Fnc 1   Fnc 1   0207    I   11110101110
        '11010000100', //  103  Start A Start A Start A 0208    D   11010000100
        '11010010000', //  104  Start B Start B Start B 0209    N   11010010000
        '11010011100', //  105  Start C Start C Start C 0210    O   11010011100
        '11000111010'  //  106  Stop    Stop    Stop    0211    O   1100011101011
    );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $tableB = " !\"#$%&'()*+, -./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~";
        $result = '';
        $sum = 0;
        $isum = 0;
        $i = 0;
        $j = 0;
        $value = 0;

        //-------------------------------------------------
        // check each characters
        //-------------------------------------------------

        $len = strlen( $code );

        // we allow now extended ASCII so no need to check against table B

        // for ( $i = 0; $i < $len; $i++ )
        // {
        //     if ( strpos( $tableB, $code[$i] ) === false ) return ( '' );
        // }

        //-------------------------------------------------
        // check firsts characters
        // start with C table only if enought numeric
        //-------------------------------------------------

        $tableCActivated = $len> 1;

        $c = '';

        for ( $i = 0; $i < 3 && $i < $len; $i++ )
        {
            $tableCActivated &= preg_match( '`[0-9]`', $code[$i] );
        }

        $sum = $tableCActivated ? 105 : 104;

        //-------------------------------------------------
        // start : [105] : C table or [104] : B table
        //-------------------------------------------------

        $result = self::$encoding[$sum];

        $i = 0;

        while ( $i < $len )
        {
            if ( ! $tableCActivated )
            {
                $j = 0;

                //-------------------------------------------------
                // check next character to activate C table
                // if interresting
                //-------------------------------------------------

                while ( ( $i + $j < $len ) && preg_match( '`[0-9]`', $code[$i+$j] ) ) $j++;

                //-------------------------------------------------
                // 6 min everywhere or 4 mini at the end
                //-------------------------------------------------

                $tableCActivated = ( $j > 5 ) || ( ( $i + $j - 1 == $len ) && ( $j > 3 ) );

                if ( $tableCActivated )
                {
                    //-------------------------------------------------
                    // C table
                    //-------------------------------------------------

                    $result .= self::$encoding[99];

                    $sum += ++$isum * 99;
                }

                //-------------------------------------------------
                // 2 min for table C so need table B
                //-------------------------------------------------
            }
            else if ( ( $i == $len - 1 ) || ( preg_match( '`[^0-9]`', $code[$i] ) ) || ( preg_match( '`[^0-9]`', $code[$i+1] ) ) )
            {
                //-------------------------------------------------
                // todo : verifier le JS : len - 1!
                //-------------------------------------------------

                $tableCActivated = false;

                //-------------------------------------------------
                // B table
                //-------------------------------------------------

                $result .= self::$encoding[100];

                $sum += ++$isum * 100;
            }

            if ( $tableCActivated )
            {
                //-------------------------------------------------
                // Add two characters ( numeric )
                //-------------------------------------------------

                $value = intval( substr( $code, $i, 2 ) );

                $i += 2;
            }
            else
            {
                //-------------------------------------------------
                // take care of extended characters
                // (ASCII above 127)
                //-------------------------------------------------

                if ( ord( $code[$i] ) > 126 )
                {
                    $result .= self::$encoding[ 100 ];
                    $sum += ++$isum * 100;

                    //-------------------------------------------------
                    // Add one character
                    //-------------------------------------------------

                    $value = strpos( $tableB, chr( ord( $code[$i] ) - 128 ) );
                }
                else
                {
                    //-------------------------------------------------
                    // Add one character
                    //-------------------------------------------------

                    $value = strpos( $tableB, $code[$i] );
                }

                $i++;
            }

            $result .= self::$encoding[$value];

            $sum += ++$isum * $value;
        }

        //-------------------------------------------------
        // Add CRC
        //-------------------------------------------------

        $result .= self::$encoding[$sum % 103];

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= self::$encoding[106];

        //-------------------------------------------------
        // Termination bar
        //-------------------------------------------------

        $result .= '11';

        return ( $result );
    }
}

/**
 * BarcodeCodabar Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeCodabar
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $encoding = array( '101010011', '101011001', '101001011', '110010101', '101101001', '110101001', '100101011', '100101101', '100110101', '110100101', '101001101', '101100101', '1101011011', '1101101011', '1101101101', '1011011011', '1011001001', '1010010011', '1001001011', '1010011001' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $table = '0123456789-$:/.+';
        $result = '';
        $intercharacter = '0';

        //-------------------------------------------------
        // add start : A->D : arbitrary choose A
        //-------------------------------------------------

        $result .= self::$encoding[16] . $intercharacter;

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[$i] );

            if ( $index === false ) return ( '' );

            $result .= self::$encoding[$index] . $intercharacter;
        }

        //-------------------------------------------------
        // add stop : A->D : arbitrary choose A
        //-------------------------------------------------

        $result .= self::$encoding[16];

        return ( $result );
    }
}

/**
 * BarcodeDatamatrix Class
 *
 * @package BCCL
 * @since   2.0.3
 */
class BarcodeDatamatrix
{
    /**
     * 24 squares et 6 rectangular
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $lengthRows = array( 10, 12, 14, 16, 18, 20, 22, 24, 26, 32, 36, 40, 44, 48, 52, 64, 72, 80,  88, 96, 104, 120, 132, 144, 8, 8, 12, 12, 16, 16 );

    /**
     * Number of columns for the entire datamatrix
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $lengthCols = array( 10, 12, 14, 16, 18, 20, 22, 24, 26, 32, 36, 40, 44, 48, 52, 64, 72, 80, 88, 96, 104, 120, 132, 144, 18, 32, 26, 36, 36, 48 );

    /**
     * Number of data codewords for the datamatrix
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $dataCWCount = array( 3, 5, 8, 12, 18, 22, 30, 36, 44, 62, 86, 114, 144, 174, 204, 280, 368, 456, 576, 696, 816, 1050, 1304, 1558, 5, 10, 16, 22, 32, 49 );

    /**
     * Number of Reed-Solomon codewords for the datamatrix
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $solomonCWCount = array( 5, 7, 10, 12, 14, 18, 20, 24, 28, 36, 42, 48, 56, 68, 84, 112, 144, 192, 224, 272, 336, 408, 496, 620, 7, 11, 14, 18, 24, 28 );

    /**
     * Number of rows per region
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $dataRegionRows = array( 8, 10, 12, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22, 6,  6, 10, 10, 14, 14 );

    /**
     * Number of columns per region
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $dataRegionCols = array( 8, 10, 12, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22, 16, 14, 24, 16, 16, 22 );

    /**
     * Number of regions per row
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $regionRows = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6, 1, 1, 1, 1, 1, 1 );

    /**
     * Number of regions per column
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $regionCols = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6, 1, 2, 1, 2, 2, 2 );

    /**
     * Number of blocks
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $interleavedBlocks = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 4, 4, 4, 4, 6, 6, 8, 8, 1, 1, 1, 1, 1, 1 );

    /**
     * Table of log for the Galois field
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $logTab = array( -255, 255, 1, 240, 2, 225, 241, 53, 3, 38, 226, 133, 242, 43, 54, 210, 4, 195, 39, 114, 227, 106, 134, 28, 243, 140, 44, 23, 55, 118, 211, 234, 5, 219, 196, 96, 40, 222, 115, 103, 228, 78, 107, 125, 135, 8, 29, 162, 244, 186, 141, 180, 45, 99, 24, 49, 56, 13, 119, 153, 212, 199, 235, 91, 6, 76, 220, 217, 197, 11, 97, 184, 41, 36, 223, 253, 116, 138, 104, 193, 229, 86, 79, 171, 108, 165, 126, 145, 136, 34, 9, 74, 30, 32, 163, 84, 245, 173, 187, 204, 142, 81, 181, 190, 46, 88, 100, 159, 25, 231, 50, 207, 57, 147, 14, 67, 120, 128, 154, 248, 213, 167, 200, 63, 236, 110, 92, 176, 7, 161, 77, 124, 221, 102, 218, 95, 198, 90, 12, 152, 98, 48, 185, 179, 42, 209, 37, 132, 224, 52, 254, 239, 117, 233, 139, 22, 105, 27, 194, 113, 230, 206, 87, 158, 80, 189, 172, 203, 109, 175, 166, 62, 127, 247, 146, 66, 137, 192, 35, 252, 10, 183, 75, 216, 31, 83, 33, 73, 164, 144, 85, 170, 246, 65, 174, 61, 188, 202, 205, 157, 143, 169, 82, 72, 182, 215, 191, 251, 47, 178, 89, 151, 101, 94, 160, 123, 26, 112, 232, 21, 51, 238, 208, 131, 58, 69, 148, 18, 15, 16, 68, 17, 121, 149, 129, 19, 155, 59, 249, 70, 214, 250, 168, 71, 201, 156, 64, 60, 237, 130, 111, 20, 93, 122, 177, 150 );

    /**
     * Table of aLog for the Galois field
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @var     array
     */
    private static $aLogTab = array( 1, 2, 4, 8, 16, 32, 64, 128, 45, 90, 180, 69, 138, 57, 114, 228, 229, 231, 227, 235, 251, 219, 155, 27, 54, 108, 216, 157, 23, 46, 92, 184, 93, 186, 89, 178, 73, 146, 9, 18, 36, 72, 144, 13, 26, 52, 104, 208, 141, 55, 110, 220, 149, 7, 14, 28, 56, 112, 224, 237, 247, 195, 171, 123, 246, 193, 175, 115, 230, 225, 239, 243, 203, 187, 91, 182, 65, 130, 41, 82, 164, 101, 202, 185, 95, 190, 81, 162, 105, 210, 137, 63, 126, 252, 213, 135, 35, 70, 140, 53, 106, 212, 133, 39, 78, 156, 21, 42, 84, 168, 125, 250, 217, 159, 19, 38, 76, 152, 29, 58, 116, 232, 253, 215, 131, 43, 86, 172, 117, 234, 249, 223, 147, 11, 22, 44, 88, 176, 77, 154, 25, 50, 100, 200, 189, 87, 174, 113, 226, 233, 255, 211, 139, 59, 118, 236, 245, 199, 163, 107, 214, 129, 47, 94, 188, 85, 170, 121, 242, 201, 191, 83, 166, 97, 194, 169, 127, 254, 209, 143, 51, 102, 204, 181, 71, 142, 49, 98, 196, 165, 103, 206, 177, 79, 158, 17, 34, 68, 136, 61, 122, 244, 197, 167, 99, 198, 161, 111, 222, 145, 15, 30, 60, 120, 240, 205, 183, 67, 134, 33, 66, 132, 37, 74, 148, 5, 10, 20, 40, 80, 160, 109, 218, 153, 31, 62, 124, 248, 221, 151, 3, 6, 12, 24, 48, 96, 192, 173, 119, 238, 241, 207, 179, 75, 150, 1 );

    /**
     * Multiplication in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisMult( $a, $b )
    {
        if ( ! $a || ! $b ) return 0;

        return self::$aLogTab[( self::$logTab[$a] + self::$logTab[$b] ) % 255];
    }

    /**
     * The operation a * 2^b in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisDoub( $a, $b )
    {
        if ( ! $a ) return 0;

        if ( ! $b ) return $a;

        return self::$aLogTab[( self::$logTab[$a] + $b ) % 255];
    }

    /**
     * Sum in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisSum( $a, $b )
    {
        return $a ^ $b;
    }

    /**
     * Choose the good index for tables
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function selectIndex( $dataCodeWordsCount, $rectangular )
    {
        if ( ( $dataCodeWordsCount < 1 || $dataCodeWordsCount > 1558 ) && ! $rectangular ) return ( -1 );

        if ( ( $dataCodeWordsCount < 1 || $dataCodeWordsCount > 49 ) && $rectangular )  return ( -1 );

        $n = $rectangular ? 24 : 0;

        while ( self::$dataCWCount[$n] < $dataCodeWordsCount ) $n++;

        return $n;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function encodeDataCodeWordsASCII( $text )
    {
        $dataCodeWords = array();
        $n = 0;
        $len = strlen( $text );

        for ( $i = 0; $i < $len; $i++ )
        {
            $c = ord( $text[$i] );

            if ( $c > 127 )
            {
                $dataCodeWords[$n] = 235;

                $c -= 127;

                $n++;
            }
            else if ( ( $c >= 48 && $c <= 57 ) && ( $i + 1 < $len ) && ( preg_match( '`[0-9]`', $text[$i+1] ) ) )
            {
                $c = ( ( $c - 48 ) * 10 ) + intval( $text[$i+1] );

                $c += 130;

                $i++;
            }
            else
            {
                $c++;
            }

            $dataCodeWords[$n] = $c;

            $n++;
        }

        return $dataCodeWords;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addPadCW( &$tab, $from, $to )
    {
        if ( $from >= $to ) return ;

        $tab[$from] = 129;

        for ( $i = $from + 1; $i < $to; $i++ )
        {
            $r = ( ( 149 * ( $i+1 ) ) % 253 ) + 1;

            $tab[$i] = ( 129 + $r ) % 254;
        }
    }

    /**
     * Calculate the reed solomon factors
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function calculSolFactorTable( $solomonCWCount )
    {
        $g = array_fill( 0, $solomonCWCount + 1, 1 );

        for ( $i = 1; $i <= $solomonCWCount; $i++ )
        {
            for ( $j = $i - 1; $j >= 0; $j-- )
            {
                $g[$j] = self::champGaloisDoub( $g[$j], $i );

                if ( $j > 0 ) $g[$j] = self::champGaloisSum( $g[$j], $g[$j - 1 ] );
            }
        }

        return $g;
    }

    /**
     * Add the Reed Solomon codewords
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addReedSolomonCW( $nSolomonCW, $coeffTab, $nDataCW, &$dataTab, $blocks )
    {
        $errorBlocks = $nSolomonCW / $blocks;
        $correctionCW = array();

        for ( $k = 0; $k < $blocks; $k++ )
        {
            for ( $i = 0; $i < $errorBlocks; $i++ )
            {
                $correctionCW[$i] = 0;
            }

            for ( $i = $k; $i < $nDataCW; $i += $blocks )
            {
                $temp = self::champGaloisSum( $dataTab[$i], $correctionCW[ $errorBlocks - 1 ] );

                for ( $j = $errorBlocks - 1; $j >= 0; $j-- )
                {
                    if ( ! $temp )
                    {
                        $correctionCW[$j] = 0;
                    }
                    else
                    {
                        $correctionCW[$j] = self::champGaloisMult( $temp, $coeffTab[$j] );
                    }

                    if ( $j>0 )
                    {
                        $correctionCW[$j] = self::champGaloisSum( $correctionCW[ $j - 1 ], $correctionCW[$j] );
                    }
                }
            }

            //-------------------------------------------------
            // Renversement des blocs calcules
            //-------------------------------------------------

            $j = $nDataCW + $k;

            for ( $i = $errorBlocks - 1; $i >= 0; $i-- )
            {
                $dataTab[$j] = $correctionCW[$i];

                $j = $j + $blocks;
            }
        }

        return $dataTab;
    }

    /**
     * Transform integer to tab of bits
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function getBits( $entier )
    {
        $bits = array();

        for ( $i = 0; $i < 8; $i++ )
        {
            $bits[$i] = $entier & ( 128 >> $i ) ? 1 : 0;
        }

        return $bits;
    }

    /**
     * Place codewords into the matrix
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function next( $etape, $totalRows, $totalCols, $codeWordsBits, &$datamatrix, &$assigned )
    {
        //-------------------------------------------------
        // Place of the 8st bit from the first
        // character to [4][0]
        //-------------------------------------------------

        $chr = 0;
        $row = 4;
        $col = 0;

        do
        {
            //-------------------------------------------------
            // Check for a special case of corner
            //-------------------------------------------------

            if ( ( $row == $totalRows ) && ( $col == 0 ) )
            {
                self::patternShapeSpecial1( $datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols );
                $chr++;
            }
            else if ( ( $etape < 3 ) && ( $row == $totalRows-2 ) && ( $col == 0 ) && ( $totalCols%4 != 0 ) )
            {
                self::patternShapeSpecial2( $datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols );
                $chr++;
            }
            else if ( ( $row == $totalRows - 2 ) && ( $col == 0 ) && ( $totalCols%8 == 4 ) )
            {
                self::patternShapeSpecial3( $datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols );
                $chr++;
            }
            else if ( ( $row == $totalRows + 4 ) && ( $col == 2 ) && ( $totalCols%8 == 0 ) )
            {
                self::patternShapeSpecial4( $datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols );
                $chr++;
            }

            //-------------------------------------------------
            // Go up and right in the datamatrix
            //-------------------------------------------------

            do
            {
                if ( ( $row < $totalRows ) && ( $col >= 0 ) && ( !isset( $assigned[$row][$col] ) || $assigned[$row][$col]!=1 ) )
                {
                    self::patternShapeStandard( $datamatrix, $assigned, $codeWordsBits[$chr], $row, $col, $totalRows, $totalCols );
                    $chr++;
                }

                $row -= 2;
                $col += 2;
            }
            while ( ( $row >= 0 ) && ( $col < $totalCols ) );

            $row += 1;
            $col += 3;

            //-------------------------------------------------
            // Go down and left in the datamatrix
            //-------------------------------------------------

            do
            {
                if ( ( $row >= 0 ) && ( $col < $totalCols ) && ( !isset( $assigned[$row][$col] ) || $assigned[$row][$col]!=1 ) )
                {
                    self::patternShapeStandard( $datamatrix, $assigned, $codeWordsBits[$chr], $row, $col, $totalRows, $totalCols );
                    $chr++;
                }

                $row += 2;
                $col -= 2;
            }
            while ( ( $row < $totalRows ) && ( $col >=0 ) );

            $row += 3;
            $col += 1;
        }
        while ( ( $row < $totalRows ) || ( $col < $totalCols ) );
    }

    /**
     * Place bits in the matrix ( standard or special case )
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeStandard( &$datamatrix, &$assigned, $bits, $row, $col, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[0], $row-2, $col-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[1], $row-2, $col-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[2], $row-1, $col-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[3], $row-1, $col-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[4], $row-1, $col, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[5], $row, $col-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[6], $row, $col-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[7], $row, $col, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial1( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[0], $totalRows-1,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[1], $totalRows-1,  1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[2], $totalRows-1,  2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[5], 1, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[6], 2, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[7], 3, $totalCols-1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial2( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[0], $totalRows-3,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[1], $totalRows-2,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[2], $totalRows-1,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[3], 0, $totalCols-4, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[4], 0, $totalCols-3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[5], 0, $totalCols-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[6], 0, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[7], 1, $totalCols-1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial3( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[0], $totalRows-3,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[1], $totalRows-2,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[2], $totalRows-1,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[5], 1, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[6], 2, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[7], 3, $totalCols-1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial4( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[0], $totalRows-1,  0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[1], $totalRows-1, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[2], 0, $totalCols-3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[5], 1, $totalCols-3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[6], 1, $totalCols-2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[7], 1, $totalCols-1, $totalRows, $totalCols );
    }

    /**
     * Put a bit into the matrix
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function placeBitInDatamatrix( &$datamatrix, &$assigned, $bit, $row, $col, $totalRows, $totalCols )
    {
        if ( $row < 0 )
        {
            $row += $totalRows;

            $col += 4 - ( ( $totalRows+4 )%8 );
        }

        if ( $col < 0 )
        {
            $col += $totalCols;

            $row += 4 - ( ( $totalCols+4 )%8 );
        }

        if ( !isset( $assigned[$row][$col] ) || $assigned[$row][$col] != 1 )
        {
            $datamatrix[$row][$col] = $bit;

            $assigned[$row][$col] = 1;
        }
    }

    /**
     * Add the finder pattern
     *
     * @since   2.0.3
     * @access  private
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addFinderPattern( $datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW )
    {
        $totalRowsCW = ( $rowsRegionCW + 2 ) * $rowsRegion;

        $totalColsCW = ( $colsRegionCW + 2 ) * $colsRegion;

        $datamatrixTemp = array();

        $datamatrixTemp[0] = array_fill( 0, $totalColsCW + 2, 0 );

        for ( $i = 0; $i < $totalRowsCW; $i++ )
        {
            $datamatrixTemp[$i+1] = array();

            $datamatrixTemp[$i+1][0] = 0;

            $datamatrixTemp[$i+1][$totalColsCW+1] = 0;

            for ( $j = 0; $j < $totalColsCW; $j++ )
            {
                if ( $i % ( $rowsRegionCW + 2 ) == 0 )
                {
                    if ( $j % 2 == 0 )
                    {
                        $datamatrixTemp[$i+1][$j+1] = 1;
                    }
                    else
                    {
                        $datamatrixTemp[$i+1][$j+1] = 0;
                    }
                }
                else if ( $i % ( $rowsRegionCW + 2 ) == $rowsRegionCW + 1 )
                {
                    $datamatrixTemp[$i+1][$j+1] = 1;
                }
                else if ( $j % ( $colsRegionCW + 2 ) == $colsRegionCW + 1 )
                {
                    if ( $i % 2 == 0 )
                    {
                        $datamatrixTemp[$i+1][$j+1] = 0;
                    }
                    else
                    {
                        $datamatrixTemp[$i+1][$j+1] = 1;
                    }
                }
                else if ( $j % ( $colsRegionCW + 2 ) == 0 )
                {
                    $datamatrixTemp[$i+1][$j+1] = 1;
                }
                else
                {
                    $datamatrixTemp[$i+1][$j+1] = 0;

                    $datamatrixTemp[$i+1][$j+1] = $datamatrix[$i-1-( 2*( floor( $i/( $rowsRegionCW+2 ) ) ) )][$j-1-( 2*( floor( $j/( $colsRegionCW+2 ) ) ) )]; // todo : parseInt => ?
                }
            }
        }

        $datamatrixTemp[$totalRowsCW+1] = array();

        for ( $j = 0; $j < $totalColsCW + 2; $j++ )
        {
            $datamatrixTemp[$totalRowsCW+1][$j] = 0;
        }

        return $datamatrixTemp;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $text, $rectangular )
    {
        //-------------------------------------------------
        // Code the text in the ASCII mode
        //-------------------------------------------------

        $dataCodeWords = self::encodeDataCodeWordsASCII( $text );

        $dataCWCount = count( $dataCodeWords );

        //-------------------------------------------------
        // Select the index for the data tables
        //-------------------------------------------------

        $index = self::selectIndex( $dataCWCount, $rectangular );

        //-------------------------------------------------
        // Number of data CW
        //-------------------------------------------------

        $totalDataCWCount = self::$dataCWCount[$index];

        //-------------------------------------------------
        // Number of Reed Solomon CW
        //-------------------------------------------------

        $solomonCWCount = self::$solomonCWCount[$index];

        //-------------------------------------------------
        // Number of CW
        //-------------------------------------------------

        $totalCWCount = $totalDataCWCount + $solomonCWCount;

        //-------------------------------------------------
        // Size of symbol
        //-------------------------------------------------

        $rowsTotal = self::$lengthRows[$index];

        $colsTotal = self::$lengthCols[$index];

        //-------------------------------------------------
        // Number of region
        //-------------------------------------------------

        $rowsRegion = self::$regionRows[$index];

        $colsRegion = self::$regionCols[$index];

        $rowsRegionCW = self::$dataRegionRows[$index];

        $colsRegionCW = self::$dataRegionCols[$index];

        //-------------------------------------------------
        // Size of matrice data
        //-------------------------------------------------

        $rowsLengthMatrice = $rowsTotal - 2 * $rowsRegion;

        $colsLengthMatrice = $colsTotal - 2 * $colsRegion;

        //-------------------------------------------------
        // Number of Reed Solomon blocks
        //-------------------------------------------------

        $blocks = self::$interleavedBlocks[$index];

        $errorBlocks = $solomonCWCount / $blocks;

        //-------------------------------------------------
        // Add codewords pads
        //-------------------------------------------------

        self::addPadCW( $dataCodeWords, $dataCWCount, $totalDataCWCount );

        //-------------------------------------------------
        // Calculate correction coefficients
        //-------------------------------------------------

        $g = self::calculSolFactorTable( $errorBlocks );

        //-------------------------------------------------
        // Add Reed Solomon codewords
        //-------------------------------------------------

        self::addReedSolomonCW( $solomonCWCount, $g, $totalDataCWCount, $dataCodeWords, $blocks );

        //-------------------------------------------------
        // Calculte bits from codewords
        //-------------------------------------------------

        $codeWordsBits = array();

        for ( $i = 0; $i < $totalCWCount; $i++ )
        {
            $codeWordsBits[$i] = self::getBits( $dataCodeWords[$i] );
        }

        $datamatrix = array_fill( 0, $colsLengthMatrice, array() );

        $assigned = array_fill( 0, $colsLengthMatrice, array() );

        //-------------------------------------------------
        // Add the bottom-right corner if needed
        //-------------------------------------------------

        if ( ( ( $rowsLengthMatrice * $colsLengthMatrice ) % 8 ) == 4 )
        {
            $datamatrix[$rowsLengthMatrice-2][$colsLengthMatrice-2] = 1;
            $datamatrix[$rowsLengthMatrice-1][$colsLengthMatrice-1] = 1;
            $datamatrix[$rowsLengthMatrice-1][$colsLengthMatrice-2] = 0;
            $datamatrix[$rowsLengthMatrice-2][$colsLengthMatrice-1] = 0;

            $assigned[$rowsLengthMatrice-2][$colsLengthMatrice-2] = 1;
            $assigned[$rowsLengthMatrice-1][$colsLengthMatrice-1] = 1;
            $assigned[$rowsLengthMatrice-1][$colsLengthMatrice-2] = 1;
            $assigned[$rowsLengthMatrice-2][$colsLengthMatrice-1] = 1;
        }

        //-------------------------------------------------
        // Put the codewords into the matrix
        //-------------------------------------------------

        self::next( 0, $rowsLengthMatrice, $colsLengthMatrice, $codeWordsBits, $datamatrix, $assigned );

        //-------------------------------------------------
        // Add the finder pattern
        //-------------------------------------------------

        $datamatrix = self::addFinderPattern( $datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW );

        return $datamatrix;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.4
     * @access  public
     * @static
     * @param   integer/string/array $DEFAULT DEFAULT
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getLenghtColumn( $text )
    {
        $dataCodeWords = self::encodeDataCodeWordsASCII( $text );

        $dataCWCount = count( $dataCodeWords );

        $index = self::selectIndex( $dataCWCount, false );

        return self::$lengthCols[$index];
    }
}
?>
