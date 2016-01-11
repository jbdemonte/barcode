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
        $type = $code = null;

        if ( isset( $_REQUEST['type'] ) ): $type = urldecode( $_REQUEST['type'] ); endif;
        if ( isset( $_REQUEST['code'] ) ): $code = urldecode( $_REQUEST['code'] ); endif;

        $x = 100;
        $y = 100;

        $width = 2;
        $height = null;

        $angle = 0;   

        $IMAGE_RESOURCE = imagecreatetruecolor( 200, 200 );

        $black  = imagecolorallocate( $IMAGE_RESOURCE, 0x00, 0x00, 0x00 );
        $white  = imagecolorallocate( $IMAGE_RESOURCE, 0xff, 0xff, 0xff );

        imagefilledrectangle( $IMAGE_RESOURCE, 0, 0, 200, 200, $white );

        $data = Barcode::gd( $IMAGE_RESOURCE, $black, $x, $y, $angle, $type, array( 'code' => $code ), $width, $height );

        header( 'Content-type: image/gif' );

        imagegif( $IMAGE_RESOURCE );

        imagedestroy( $IMAGE_RESOURCE );

        exit;
    }

    //-------------------------------------------------
    // DISPLAY HTML
    //-------------------------------------------------

    $code = '111222333';
    echo '<h1>STD25 -> ' . $code . '</h1>';
    echo '<img src="?type=std25&code=' . urlencode( $code ) . '">';

    $code = '111222333';
    echo '<h1>INT25 -> ' . $code . '</h1>';
    echo '<img src="?type=int25&code=' . urlencode( $code ) . '">';

    $code = '65833254';
    echo '<h1>EAN8 -> ' . $code . '</h1>';
    echo '<img src="?type=ean8&code=' . urlencode( $code ) . '">';

    $code = '5901234123457';
    echo '<h1>EAN13 -> ' . $code . '</h1>';
    echo '<img src="?type=ean13&code=' . urlencode( $code ) . '">';

    $code = '111222333444';
    echo '<h1>UPC -> ' . $code . '</h1>';
    echo '<img src="?type=upc&code=' . urlencode( $code ) . '">';

    $code = '111222333';
    echo '<h1>CODE11 -> ' . $code . '</h1>';
    echo '<img src="?type=code11&code=' . urlencode( $code ) . '">';

    $code = '111222333';
    echo '<h1>CODE39 -> ' . $code . '</h1>';
    echo '<img src="?type=code39&code=' . urlencode( $code ) . '">';

    $code = '111222333';
    echo '<h1>CODE93 -> ' . $code . '</h1>';
    echo '<img src="?type=code93&code=' . urlencode( $code ) . '">';

    $code = 'AABBCCDDEE 128-B';
    echo '<h1>CODE128 -> ' . $code . '</h1>';
    echo '<img src="?type=code128&code=' . urlencode( $code ) . '">';

    $code = '0123456789-$:/.+';
    echo '<h1>CODABAR -> ' . $code . '</h1>';
    echo '<img src="?type=codabar&code=' . urlencode( $code ) . '">';

    $code = '111222333';
    echo '<h1>MSI -> ' . $code . '</h1>';
    echo '<img src="?type=msi&code=' . urlencode( $code ) . '">';

    $code = md5( time() );
    echo '<h1>DATAMATRIX -> ' . $code . '</h1>';
    echo '<img src="?type=datamatrix&code=' . urlencode( $code ) . '">';

    echo '<style> * { margin:0; padding:0; }</style>';

?>