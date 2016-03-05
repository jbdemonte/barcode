php-barcode
===========

LICENCE
-------
* [GPLv3](http://www.gnu.org/licenses/gpl.html)
* [CeCILL](http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html)

PRESENTATION
------------
This plugin allows you to create barcodes thanks to php.

REQUIREMENTS
------------
* PHP 5.0+

FEATURES / SYMBOLOGIES
----------------------
* Standard 2 of 5 (STD25)
* Interleaved 2 of 5 (INT25)
* European Article Number 8 (EAN 8)
* European Article Number 13 (EAN 13)
* Universal Product Code (UPC)
* Code 11
* Code 39
* Code 93
* Code 128
* Codabar
* Modified Plessey (MSI)
* Data Matrix
* Quick Response Code (QR Code)

OUTPUT
------
* GD
* FPDF

USAGE
-----
```php
try
{
    $barcode = new Barcode( array( 'type' => 'qrcode', 'content' => 'test', 'format' => 'png', 'margin' => 10, 'orientaton' => 'bottom' ) );
    $barcode->image();

    $barcode = new Barcode();
    $barcode->type( 'qrcode' )->content( 'test' )->format( 'jpg' )->margin( 10 )->orientaton( 'right' )->resize( 100, 50, 'mm', 90 )->image();

    $barcode = new Barcode();
    $barcode->type( 'qrcode' );
    $barcode->content( 'test' );
    $barcode->format( 'jpg' );
    $barcode->margin( 50 );
    $barcode->color( 'FF00FF' );
    $barcode->width( 100 );
    $barcode->height( 50 );
    $barcode->scale( 'mm' );
    $barcode->dpi( 90 );
    $barcode->resize();
    $barcode->create();
    $image_resource = $barcode->resource();
    imagettftext( $image_resource, 10, 0, 20, 30, 0x000000, 'font file path', 'text label' );
    $barcode->resource( $image_resource );
    $barcode->orientaton( 'left' );
    $barcode->image();

    $barcode = new Barcode( 'qrcode', 'test' );

    $barcode->image();

    $image_data = $barcode->image( true );

    $barcode->image( false );         // Start a file download.
    $barcode->image( 'barcode.gif' ); 
    $barcode->image( 'barcode' );     // The file extension is added automatically.
    $barcode->image( '' );            // A file name is automatically created.
}
catch ( Exception $Exception )
{
    echo $Exception->getMessage();
}
```