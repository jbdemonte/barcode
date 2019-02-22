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

public class Barcode39 extends Barcode1D{
	private static String[] encoding = new String[] {
        "101001101101", "110100101011", "101100101011", "110110010101",
        "101001101011", "110100110101", "101100110101", "101001011011",
        "110100101101", "101100101101", "110101001011", "101101001011",
        "110110100101", "101011001011", "110101100101", "101101100101",
        "101010011011", "110101001101", "101101001101", "101011001101",
        "110101010011", "101101010011", "110110101001", "101011010011",
        "110101101001", "101101101001", "101010110011", "110101011001",
        "101101011001", "101011011001", "110010101011", "100110101011",
        "110011010101", "100101101011", "110010110101", "100110110101",
        "100101011011", "110010101101", "100110101101", "100100100101",
        "100100101001", "100101001001", "101001001001", "100101101101"};
    
	public Barcode39(String code){
		super(code);
	}
	
    public String getDigit(){
    	String code = new String(this.getCode().toUpperCase());
    	if (!code.matches("[0-9A-Z\\-\\. \\$/\\+%]*"))
    		this.setResult("");
    	else{
    		StringBuilder result = new StringBuilder("");
	    	String table = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*";
	    	char intercharacter = '0';
	    	
	    	code = '*' + code  + '*';
	
	    	int len = code.length();
	    	for(int i=0; i<len; i++){
	    		int index = table.indexOf(code.charAt(i));
	    		if (index == -1) {
	    			this.setResult("");
	    			return "";
	    		}
	    		if (i > 0) result.append(intercharacter);
	    		result.append(Barcode39.encoding[index]);
	    	}
	    	
	    	this.setResult(result.toString());	    	
			this.setComputedCode(code);
    	}
    	return this.getResult();
    }
}

