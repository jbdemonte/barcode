/*
 *  BarCode Coder Library (BCC Library)
 *  BCCL Version 2.0.1
 *  Porting : Barcode Java
 *            HOUREZ Jonathan 
 *  Date    : June 5, 2011
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

public class BarcodeCodabar extends Barcode1D{
	private static String[] encoding = new String[] {
		"101010011", "101011001", "101001011", "110010101",
        "101101001", "110101001", "100101011", "100101101",
        "100110101", "110100101", "101001101", "101100101",
        "1101011011", "1101101011", "1101101101", "1011011011",
        "1011001001", "1010010011", "1001001011", "1010011001"};
    
	public BarcodeCodabar(String code){
		super(code);
	}
	
    public String getDigit(){
    	String code = new String(this.getCode());
    	
    	if (!code.matches("[0-9\\-\\$:/\\.\\+]*"))
    		this.setResult("");
    	else{
    		StringBuilder result = new StringBuilder("");
			String table = "0123456789-$:/.+";
			char intercharacter = '0';
	
			// add start : A->D : arbitrary choose A
			result.append(BarcodeCodabar.encoding[16] + intercharacter);
	
			int len = code.length();
			for(int i=0; i<len; i++){
				int index = table.indexOf(code.charAt(i));
				if (index == -1) {
					this.setResult("");
					return "";
				}
				result.append(BarcodeCodabar.encoding[index] + intercharacter);
			}
	
			// add stop : A->D : arbitrary choose A
			result.append(BarcodeCodabar.encoding[16]);
			
			this.setResult(result.toString());	    	
			this.setComputedCode(code);
    	}
    	return this.getResult();
	}
}

