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

public class Barcode11 extends Barcode1D{
	private static String[] encoding = new String[] {
		"101011", "1101011", "1001011", "1100101",
        "1011011", "1101101", "1001101", "1010011",
        "1101001", "110101", "101101" };
    
	public Barcode11(String code){
		super(code);
	}
	
    public String getDigit(){
    	String code = new String(this.getCode());
    	
    	if (!code.matches("[0-9\\-]*"))
    		this.setResult("");
    	else{
	    	StringBuilder result = new StringBuilder("");
	    	char intercharacter = '0';
	
	    	result.append("1011001" + intercharacter);
	
	    	int len = code.length();
	    	for(int i=0; i<len; i++){
	    		int index = code.charAt(i) == '-' ? 10 : Integer.parseInt(""+code.charAt(i));
	    		result.append(Barcode11.encoding[index] + intercharacter);
	    	}
	
	    	int weightC    = 0;
	    	int weightSumC = 0;
	    	int weightK    = 1; // start at 1 because the right-most character is 'C' checksum
	    	int weightSumK = 0;
	    	for(int i=len-1; i>-1; i--){
	    		weightC = weightC == 10 ? 1 : weightC + 1;
	    		weightK = weightK == 10 ? 1 : weightK + 1;
	
	    		int index = code.charAt(i) == '-' ? 10 : Integer.parseInt(""+code.charAt(i));
	
	    		weightSumC += weightC * index;
	    		weightSumK += weightK * index;
	    	}
	
	    	int c = weightSumC % 11;
	    	weightSumK += c;
	    	int k = weightSumK % 11;
	
	    	result.append(Barcode11.encoding[c] + intercharacter);
	
	    	if (len >= 10){
	    		result.append(Barcode11.encoding[k] + intercharacter);
	    	}
	
	    	result.append("1011001");
	    	
	    	this.setResult(result.toString());	    	
			this.setComputedCode(code);
    	}
    	return this.getResult();
    }    
}


