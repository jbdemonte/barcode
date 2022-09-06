BarCode Coder Library (BCC Library)
BCCL Version 2.0
===========
Date    : 2013-01-06
Author  : DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
          HOUREZ Jonathan
===========
Date    : 2013-12-24
Leszek Boroch <borek@borek.net.pl>
Modification in class Barcode128 to enable encoding extended characters
(ASCII above 127). To use barcodes, keypad emulation must be enabled in scanner configuration
(tested with Motorola/Symbol LS2208).
===========
Web site: http://barcode-coder.com/

Presentation
------------

This plugin allows you to create barcodes thanks to php.

Licence
-------
[GPL v3](http://www.gnu.org/licenses/gpl.html)  
[CeCILL](http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html)

Features
--------

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
 - GD
 - FPDF