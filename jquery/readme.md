# jquery-barcode

## Presentation

This plugin allows you to display barcodes on your website using jQuery.

[demo on jsfiddle](https://jsfiddle.net/gh/get/jquery/3.0/jbdemonte/barcode/tree/master/jquery/demo)

## Licence

[GPL v3](http://www.gnu.org/licenses/gpl.html)  
[CeCILL](http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html)

## Features

### Symbologies
 - standard 2 of 5 (std25)
 - interleaved 2 of 5 (int25)
 - ean 8 (ean8)
 - ean 13 (ean13)
 - upc (upc)
 - code 11 (code11)
 - code 39 (code39)
 - code 93 (code93)
 - code 128 (code128)  
 - codabar (codabar)
 - msi (msi)
 - datamatrix (datamatrix)
  
### Output : 
 - CSS (compatible with any browser)
 - SVG inline (not compatible with IE)
 - BMP inline (not compatible with IE)      
 - CANVAS html 5 (not compatible with IE)
 
## Minification

Minified version is built with [uglify-js](https://www.npmjs.com/package/uglify-js).
```bash
uglifyjs --compress --mangle -- jquery-barcode.js > jquery-barcode.min.js
```