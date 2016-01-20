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

    .BARCODE_CONTAINER
    {
        display:inline-block;
        margin-top:10px;
        margin-left:10px;
        padding:10px;
        border:1px solid black;
        text-align:center;
    }

    .BARCODE_CONTAINER img
    {
        border:1px dotted #000;
    }

</style>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333'; ?>
<h1>STD25 -> <?php echo $code; ?></h1>
<img src="?type=std25&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333'; ?>
<h1>INT25 -> <?php echo $code; ?></h1>
<img src="?type=int25&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '65833254'; ?>
<h1>EAN8 -> <?php echo $code; ?></h1>
<img src="?type=ean8&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '5901234123457'; ?>
<h1>EAN13 -> <?php echo $code; ?></h1>
<img src="?type=ean13&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333444'; ?>
<h1>UPC -> <?php echo $code; ?></h1>
<img src="?type=upc&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333'; ?>
<h1>CODE11 -> <?php echo $code; ?></h1>
<img src="?type=code11&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333'; ?>
<h1>CODE39 -> <?php echo $code; ?></h1>
<img src="?type=code39&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = 'ABC-1234-/+'; ?>
<h1>CODE93 -> <?php echo $code; ?></h1>
<img src="?type=code93&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = 'AABBCCDDEE 128-B'; ?>
<h1>CODE128 -> <?php echo $code; ?></h1>
<img src="?type=code128&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '123456789'; ?>
<h1>CODABAR -> <?php echo $code; ?></h1>
<img src="?type=codabar&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = '111222333'; ?>
<h1>MSI -> <?php echo $code; ?></h1>
<img src="?type=msi&code=<?php echo urlencode( $code ); ?>">
</div>

<div class="BARCODE_CONTAINER">
<?php $code = md5( time() ); ?>
<h1>DATAMATRIX -> <?php echo $code; ?></h1>
<img src="?type=datamatrix&code=<?php echo urlencode( $code ); ?>">
</div>
