/*
 *  BarCode Coder Library (BCC Library)
 *  BCCL Version 2.0.1
 *  Porting : Barcode Java
 *            HOUREZ Jonathan 
 *  Date    : January 8, 2013
 *  
 *  
 *  Author  : DEMONTE Jean-Baptiste (firejocker)
 *            HOUREZ Jonathan
 *  Contact : jbdemonte @ gmail.com
 *  Web site: http://barcode-coder.com/
 *  dual licence :  http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 *                  http://www.gnu.org/licenses/gpl.html
 *
 *  Managed :
 *     
 *    standard 2 of 5 (std25)
 *    interleaved 2 of 5 (int25)
 *    ean 8 (ean8)
 *    ean 13 (ean13)   
 *    code 11 (code11)
 *    code 39 (code39)
 *    code 93 (code93)
 *    code 128 (code128)  
 *    codabar (codabar)
 *    msi (msi)
 *    datamatrix (datamatrix)
 *  
 */

package com.barcode_coder.java_barcode;

public class  BarcodeFactory {

	private BarcodeFactory(){}
	
    public static Barcode createBarcode(BarcodeType barcodeType, String code) {          
        return createBarcode(barcodeType, code, true);
    }  

    public static Barcode createBarcode(BarcodeType barcodeType, String code, boolean crc) {
        Barcode barcode = null;

        switch (barcodeType) {
           case EAN8:
            	barcode = new BarcodeEAN(code, "ean8");
            	break;
           case EAN13:
            	barcode = new BarcodeEAN(code, "ean13");
            	break;
           case Standard2of5:
           		barcode = new Barcode2of5(code, "std25", crc);
           		break;
           case Interleaved2of5:
          		barcode = new Barcode2of5(code, "int25", crc);
          		break;
           case Code11:
          		barcode = new Barcode11(code);
          		break;
           case Code39:
          		barcode = new Barcode39(code);
          		break;
           case Code93:
          		barcode = new Barcode93(code, crc);
          		break;
           case Code128:
          		barcode = new Barcode128(code, crc);
          		break;
           case Codabar:
          		barcode = new BarcodeCodabar(code);
          		break;
           case MSI:
        		barcode = new BarcodeMSI(code, crc);
        		break;
           case Datamatrix:
        		barcode = new BarcodeDatamatrix(code);
        		break;		
        }
          
        return barcode;
    }  
}
