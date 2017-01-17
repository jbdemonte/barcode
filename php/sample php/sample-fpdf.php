<?php

    require_once './php-barcode.php';

    // require_once './fpdf.php';

    require_once './fpdf181.php';

    // -------------------------------------------------- //
    //                      USEFUL
    // -------------------------------------------------- //

    class eFPDF extends FPDF
    {
        static public function digit_to_fpdf_renderer( $pdf, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null )
        {
            $digit = '';

            $hri = '';

            list( $digit, $hri ) = Barcode::raw( $type, $datas );

            $type = strtolower( $type );

            if ( $digit == '' )
            {
            	return false;
            }

            if ( $type == 'datamatrix' )
            {
                $width = is_null( $width ) ? 5 : $width;

                $height = $width;
            }
            else
            {
                $width = is_null( $width ) ? 1 : $width;

                $height = is_null( $height ) ? 50 : $height;

                $digit = Barcode::bitStringTo2DArray( $digit );
            }

            if ( ! is_array( $color ) )
            {
                if ( preg_match( '`([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})`i', $color, $m ) )
                {
                    $color = array( hexdec( $m[ 1 ] ), hexdec( $m[ 2 ] ), hexdec( $m[ 3 ] ) );
                }
                else
                {
                    $color = array( 0, 0, 0 );
                }
            }

            $color = array_values( $color );

            $pdf->SetDrawColor( $color[ 0 ], $color[ 1 ], $color[ 2 ] );

            $pdf->SetFillColor( $color[ 0 ], $color[ 1 ], $color[ 2 ] );

            $fn = function( $points ) use ( $pdf )
            {
                $op = 'f';

                $h = $pdf->h;

                $k = $pdf->k;

                $points_string = '';

                for ( $i = 0; $i < 8; $i += 2 )
                {
                    $points_string .= sprintf( '%.2F %.2F', $points[ $i ] * $k, ( $h - $points[ $i + 1 ] ) * $k );

                    $points_string .= $i ? ' l ' : ' m ';
                }

                $pdf->_out( $points_string . $op );
            };

            $result = Barcode::digitToRenderer( $fn, $x, $y, $angle, $width, $height, $digit );

            $result[ 'hri' ] = $hri;

            return $result;
        }

        function TextWithRotation( $x, $y, $txt, $txt_angle, $font_angle = 0 )
        {
            $font_angle += 90 + $txt_angle;

            $txt_angle *= M_PI / 180;

            $font_angle *= M_PI / 180;

            $txt_dx = cos( $txt_angle );

            $txt_dy = sin( $txt_angle );

            $font_dx = cos( $font_angle );

            $font_dy = sin( $font_angle );

            $s = sprintf( 'BT %.2F %.2F %.2F %.2F %.2F %.2F Tm ( %s ) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x * $this->k, ( $this->h - $y ) * $this->k, $this->_escape( $txt ) );

            if ( $this->ColorFlag )
            {
                $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
            }

            $this->_out( $s );
        }
    }

    // -------------------------------------------------- //
    //                  PROPERTIES
    // -------------------------------------------------- //

    $fontSize = 10;

    $marge = 10; // between barcode and hri in pixel

    $x = 200; // barcode center

    $y = 200; // barcode center

    $height = 50; // barcode height in 1D ; module size in 2D

    $width = 2; // barcode height in 1D ; not use in 2D

    $angle = 45; // rotation in degrees

    $code = '123456789012'; // barcode, of course ; )

    $type = 'ean13';

    $black = '000000'; // color in hexa

    // -------------------------------------------------- //
    //            ALLOCATE FPDF RESSOURCE
    // -------------------------------------------------- //

    $pdf = new eFPDF( 'P', 'pt' );

    $pdf->AddPage();

    $data = $pdf->digit_to_fpdf_renderer( $pdf, $black, $x, $y, $angle, $type, array( 'code' => $code ), $width, $height );

    // -------------------------------------------------- //
    //                      HRI
    // -------------------------------------------------- //

    $pdf->SetFont( 'Arial', '', $fontSize );

    $pdf->SetTextColor( 0, 0, 0 );

    $len = $pdf->GetStringWidth( $data[ 'hri' ] );

    Barcode::rotate( - $len / 2, ( $data[ 'height' ] / 2 ) + $fontSize + $marge, $angle, $xt, $yt );

    $pdf->TextWithRotation( $x + $xt, $y + $yt, $data[ 'hri' ], $angle );

    // header( 'Content-Type:text/plain' );

    // echo $pdf->Output( 'TEST.PDF.pdf', 'S' );

    $pdf->Output( 'TEST.PDF.' . sprintf( '%04d', rand( 1, 1000 ) ) . '.pdf', 'I' );

?>