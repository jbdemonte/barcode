php-barcode
===========

PRESENTATION
------------
This plugin allows you to create barcodes thanks to php.

LICENCE
-------
[GPLv3](http://www.gnu.org/licenses/gpl.html)
[CeCILL](http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html)

FEATURES / SYMBOLOGIES
----------------------
* Standard 2 of 5 (STD25)
* Interleaved 2 of 5 (INT25)
* EAN 8
* EAN 13
* UPC
* CODE 11
* CODE 39
* CODE 93
* CODE 128
* CODABAR
* MSI
* Data Matrix

OUTPUT
------
* GD
* FPDF

REQUIREMENTS
------------
* PHP 5.0+

USAGE
-----
```php
try
{
    $barcode = new Barcode( array( 'type' => 'datamatrix', 'content' => 'test', 'format' => 'png', 'margin' => 10 ) );
    $barcode->image();

    $barcode = new Barcode();
    $barcode->type( 'datamatrix' )->content( 'test' )->format( 'jpg' )->margin( 10 )->image();

    $barcode = new Barcode();
    $barcode->type( 'datamatrix' );
    $barcode->content( 'test' );
    $barcode->format( 'jpg' );
    $barcode->margin( 50 );
    $barcode->create();
    $image_resource = $barcode->resource();
    imagettftext( $image_resource, 10, 0, 20, 30, 0x000000, 'font file path', 'text label' );
    $barcode->resource( $image_resource );
    $barcode->image();

    $barcode = new Barcode( 'datamatrix', 'test' );
    $barcode->image();

    $barcode = new Barcode( 'datamatrix', 'test' );
    $image_data = $barcode->image( true );

    $barcode = new Barcode( 'datamatrix', 'test' );
    $barcode->image( './barcode.gif' );
}
catch ( Exception $Exception )
{
    echo $Exception->getMessage();
}
```