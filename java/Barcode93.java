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

public class Barcode93 extends Barcode1D{
	private static String[] encoding = new String[] {
        "100010100", "101001000", "101000100", "101000010",
        "100101000", "100100100", "100100010", "101010000",
        "100010010", "100001010", "110101000", "110100100",
        "110100010", "110010100", "110010010", "110001010",
        "101101000", "101100100", "101100010", "100110100",
        "100011010", "101011000", "101001100", "101000110",
        "100101100", "100010110", "110110100", "110110010",
        "110101100", "110100110", "110010110", "110011010",
        "101101100", "101100110", "100110110", "100111010",
        "100101110", "111010100", "111010010", "111001010",
        "101101110", "101110110", "110101110", "100100110",
        "111011010", "111010110", "100110010", "101011110"};
	
	private boolean crc;
    
    public Barcode93(String code){
		super(code);
		this.crc = false;
	}
    public Barcode93(String code, boolean crc){
    	super(code);
		this.crc = crc;
	}
    public void setCRC(boolean crc){
    	this.crc = crc;
    }
    public boolean getCRC(){
    	return this.crc;
    }
	
    public String getDigit(){
    	String code = new String(this.getCode().toUpperCase());
    	if (!code.matches("[0-9A-Z\\-\\. \\$/\\+%]*"))
    		this.setResult("");
    	else{
    		StringBuilder result = new StringBuilder("");
	    	String table = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%____*"; // _ => ($), (%), (/) et (+)
	      
	    	// start : *
	    	result.append(Barcode93.encoding[47]);
	      
	    	int len = code.length();
	    	for(int i=0; i<len; i++){
	    		char c = code.charAt(i);
	    		int index = table.indexOf(code.charAt(i));
	    		if ((c == '_') || (index == -1)) {
	    			this.setResult("");
	    			return "";
	    		}
	    		result.append(Barcode93.encoding[index]);
	    	}
	      
	    	// checksum
	    	if (crc){
	    		int weightC    = 0;
	    		int weightSumC = 0;
	    		int weightK    = 1; // start at 1 because the right-most character is 'C' checksum
	    		int weightSumK = 0;
	    		for(int i=len-1; i>-1; i--){
	    			weightC = weightC == 20 ? 1 : weightC + 1;
	    			weightK = weightK == 15 ? 1 : weightK + 1;
	          
	    			int index = table.indexOf(code.charAt(i));
	          
	    			weightSumC += weightC * index;
	    			weightSumK += weightK * index;
	    		}
	        
	    		int c = weightSumC % 47;
	    		weightSumK += c;
	    		int k = weightSumK % 47;
	        
	    		result.append(Barcode93.encoding[c]);
	    		result.append(Barcode93.encoding[k]);
	    	}
	      
	    	// stop : *
	    	result.append(Barcode93.encoding[47]);
	      
	    	// Terminaison bar
	    	result.append('1');
	    	
	    	this.setResult(result.toString());	    	
			this.setComputedCode(code);
    	}
    	return this.getResult();
    }
}