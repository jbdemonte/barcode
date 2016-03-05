<?php

    error_reporting( -1 );

    ini_set( 'html_errors', 1 );

    ini_set( 'display_errors', 1 );

    define( 'CORE_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );

    require_once CORE_DIR . 'php-barcode.php';

    //-------------------------------------------------
    // GET BARCODE IMAGE
    //-------------------------------------------------

    if ( count( $_GET ) )
    {
        $INPUT_BARCODE_TYPE = $INPUT_BARCODE_CONTENT = $INPUT_BARCODE_MARGIN_TOP = $INPUT_BARCODE_MARGIN_RIGHT = $INPUT_BARCODE_MARGIN_BOTTOM = $INPUT_BARCODE_MARGIN_LEFT = $INPUT_IMAGE_RESIZE_WIDTH = $INPUT_IMAGE_RESIZE_HEIGHT = $INPUT_IMAGE_RESIZE_SCALE = $INPUT_IMAGE_RESIZE_DPI = $INPUT_IMAGE_ORIENTATON = $INPUT_IMAGE_QUALITY = $INPUT_IMAGE_FORMAT = $INPUT_IMAGE_OUTPUT = $INPUT_IMAGE_FILE_NAME = null;

        if ( isset( $_REQUEST['INPUT_BARCODE_TYPE'] ) ): $INPUT_BARCODE_TYPE = $_REQUEST['INPUT_BARCODE_TYPE']; endif;
        if ( isset( $_REQUEST['INPUT_BARCODE_CONTENT'] ) ): $INPUT_BARCODE_CONTENT = htmlentities( stripslashes( urldecode( trim( $_REQUEST['INPUT_BARCODE_CONTENT'] ) ) ), ENT_QUOTES, 'UTF-8' ); endif;
        if ( isset( $_REQUEST['INPUT_BARCODE_MARGIN_TOP'] ) ): $INPUT_BARCODE_MARGIN_TOP = intval( $_REQUEST['INPUT_BARCODE_MARGIN_TOP'] ); endif;
        if ( isset( $_REQUEST['INPUT_BARCODE_MARGIN_RIGHT'] ) ): $INPUT_BARCODE_MARGIN_RIGHT = intval( $_REQUEST['INPUT_BARCODE_MARGIN_RIGHT'] ); endif;
        if ( isset( $_REQUEST['INPUT_BARCODE_MARGIN_BOTTOM'] ) ): $INPUT_BARCODE_MARGIN_BOTTOM = intval( $_REQUEST['INPUT_BARCODE_MARGIN_BOTTOM'] ); endif;
        if ( isset( $_REQUEST['INPUT_BARCODE_MARGIN_LEFT'] ) ): $INPUT_BARCODE_MARGIN_LEFT = intval( $_REQUEST['INPUT_BARCODE_MARGIN_LEFT'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_RESIZE_WIDTH'] ) ): $INPUT_IMAGE_RESIZE_WIDTH = intval( $_REQUEST['INPUT_IMAGE_RESIZE_WIDTH'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_RESIZE_HEIGHT'] ) ): $INPUT_IMAGE_RESIZE_HEIGHT = intval( $_REQUEST['INPUT_IMAGE_RESIZE_HEIGHT'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_RESIZE_SCALE'] ) ): $INPUT_IMAGE_RESIZE_SCALE = intval( $_REQUEST['INPUT_IMAGE_RESIZE_SCALE'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_RESIZE_DPI'] ) ): $INPUT_IMAGE_RESIZE_DPI = intval( $_REQUEST['INPUT_IMAGE_RESIZE_DPI'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_ORIENTATON'] ) ): $INPUT_IMAGE_ORIENTATON = intval( $_REQUEST['INPUT_IMAGE_ORIENTATON'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_QUALITY'] ) ): $INPUT_IMAGE_QUALITY = intval( $_REQUEST['INPUT_IMAGE_QUALITY'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_FORMAT'] ) ): $INPUT_IMAGE_FORMAT = intval( $_REQUEST['INPUT_IMAGE_FORMAT'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_OUTPUT'] ) ): $INPUT_IMAGE_OUTPUT = intval( $_REQUEST['INPUT_IMAGE_OUTPUT'] ); endif;
        if ( isset( $_REQUEST['INPUT_IMAGE_FILE_NAME'] ) ): $INPUT_IMAGE_FILE_NAME = htmlentities( stripslashes( urldecode( trim( $_REQUEST['INPUT_IMAGE_FILE_NAME'] ) ) ), ENT_QUOTES, 'UTF-8' ); endif;

        try
        {
            $barcode = new Barcode();

            switch ( $INPUT_BARCODE_TYPE )
            {
                case 1: $barcode->type( 'STD25' ); break;
                case 2: $barcode->type( 'INT25' ); break;
                case 3: $barcode->type( 'EAN8' ); break;
                case 4: $barcode->type( 'EAN13' ); break;
                case 5: $barcode->type( 'UPC' ); break;
                case 6: $barcode->type( 'CODE11' ); break;
                case 7: $barcode->type( 'CODE39' ); break;
                case 8: $barcode->type( 'CODE93' ); break;
                case 9: $barcode->type( 'CODE128' ); break;
                case 10: $barcode->type( 'CODABAR' ); break;
                case 11: $barcode->type( 'MSI' ); break;
                case 12: $barcode->type( 'DATAMATRIX' ); break;
                case 13: $barcode->type( 'QRCODE' ); break;
            }

            $barcode->content( $INPUT_BARCODE_CONTENT );

            $barcode->margin( $INPUT_BARCODE_MARGIN_TOP, $INPUT_BARCODE_MARGIN_RIGHT, $INPUT_BARCODE_MARGIN_BOTTOM, $INPUT_BARCODE_MARGIN_LEFT );
            $barcode->width( $INPUT_IMAGE_RESIZE_WIDTH );
            $barcode->height( $INPUT_IMAGE_RESIZE_HEIGHT );

            switch ( $INPUT_IMAGE_RESIZE_SCALE )
            {
                case 1: $barcode->scale( 'in' ); break;
                case 2: $barcode->scale( 'cm' ); break;
                case 3: $barcode->scale( 'mm' ); break;
                default:
                case 4: $barcode->scale( 'px' ); break;
            }

            $barcode->dpi( $INPUT_IMAGE_RESIZE_DPI );
            $barcode->resize();

            switch ( $INPUT_IMAGE_ORIENTATON )
            {
                default:
                case 1: $barcode->orientaton( 'top' ); break;
                case 2: $barcode->orientaton( 'right' ); break;
                case 3: $barcode->orientaton( 'bottom' ); break;
                case 4: $barcode->orientaton( 'left' ); break;
            }

            $barcode->quality( $INPUT_IMAGE_QUALITY );

            switch ( $INPUT_IMAGE_FORMAT )
            {
                default:
                case 1: $barcode->format( 'gif' ); break;
                case 2: $barcode->format( 'png' ); break;
                case 3: $barcode->format( 'jpg' ); break;
            }

            switch ( $INPUT_IMAGE_OUTPUT )
            {
                default:
                case 1: $barcode->image(); break;
                case 2: $barcode->image( false ); break;
                case 3: $barcode->image( $INPUT_IMAGE_FILE_NAME ); break;
            }
        }
        catch ( Exception $Exception )
        {
            echo $Exception->getMessage();
        }

        exit;
    }

    //-------------------------------------------------
    // DISPLAY HTML
    //-------------------------------------------------
?>
<!DOCTYPE html>
<html lang="de">
<title>BarCode Coder Library -> Barcode Test Area</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<link href="./favicon.ico" rel="shortcut icon">
<style type="text/css" media="all">

    *
    {
        margin:0;
        padding:0;
    }
    body
    {
        font-family:monospace;
        padding:20px;
    }
    table
    {
        border-collapse:collapse;
        width:100%;
        border-top:1px solid black;
        text-align:left;
    }
    th
    {
        padding:4px;
        border-left:1px solid black;
        border-bottom:1px solid black;
        border-right:1px solid black;
        font-weight:normal;
    }
    td
    {
        vertical-align:top;
        border-left:1px solid black;
        border-bottom:1px solid black;
        border-right:1px solid black;
        padding:4px;
    }

</style>

<h1>BarCode Coder Library -> Barcode Test Area</h1>
<br>
<table>

<?php $code = '111222333'; ?>
<tr><th>STD25</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=1&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>INT25</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=2&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '65833254'; ?>
<tr><th>EAN8</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=3&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '5901234123457'; ?>
<tr><th>EAN13</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=4&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333444'; ?>
<tr><th>UPC</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=5&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>CODE11</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=6&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>CODE39</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=7&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = 'ABC-1234-/+'; ?>
<tr><th>CODE93</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=8&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = 'AABBCCDDEE 128-B'; ?>
<tr><th>CODE128</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=9&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '123456789'; ?>
<tr><th>CODABAR</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=10&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>MSI</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=11&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = md5( time() ); ?>
<tr><th>DATAMATRIX</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=12&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = md5( time() ); ?>
<tr><th>QRCODE</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?INPUT_BARCODE_TYPE=13&INPUT_BARCODE_CONTENT=<?php echo urlencode( $code ); ?>"></td></tr>

</table>
