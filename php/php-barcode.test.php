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

        try
        {
            $barcode = new Barcode( $type, $code );
            $barcode->margin( 10 );
            $barcode->image();
        }
        catch ( Exception $Exception )
        {
            // echo $Exception->getMessage();
        }

        exit;
    }

    //-------------------------------------------------
    // DISPLAY HTML
    //-------------------------------------------------
?>
<!DOCTYPE html>
<html lang="de">
<title>BarCode Coder Library Test</title>
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

<h1>BarCode Coder Library Test</h1>

<table>

<?php $code = '111222333'; ?>
<tr><th>STD25</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=std25&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>INT25</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=int25&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '65833254'; ?>
<tr><th>EAN8</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=ean8&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '5901234123457'; ?>
<tr><th>EAN13</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=ean13&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333444'; ?>
<tr><th>UPC</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=upc&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>CODE11</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=code11&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>CODE39</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=code39&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = 'ABC-1234-/+'; ?>
<tr><th>CODE93</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=code93&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = 'AABBCCDDEE 128-B'; ?>
<tr><th>CODE128</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=code128&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '123456789'; ?>
<tr><th>CODABAR</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=codabar&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = '111222333'; ?>
<tr><th>MSI</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=msi&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = md5( time() ); ?>
<tr><th>DATAMATRIX</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=datamatrix&code=<?php echo urlencode( $code ); ?>"></td></tr>

<?php $code = md5( time() ); ?>
<tr><th>QRCODE</th><th><?php echo $code; ?></th></tr>
<tr><td colspan="2"><img src="?type=qrcode&code=<?php echo urlencode( $code ); ?>"></td></tr>

</table>
