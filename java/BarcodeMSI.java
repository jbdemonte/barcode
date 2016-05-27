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

public class BarcodeMSI extends Barcode1D {
	private static String[] encoding = new String[] {
		"100100100100", "100100100110", "100100110100", "100100110110",
        "100110100100", "100110100110", "100110110100", "100110110110",
        "110100100100", "110100100110"};
    private boolean crc;
    
    public BarcodeMSI(String code){
		super(code);
		this.crc = true;
	}
    public BarcodeMSI(String code, boolean crc){
    	super(code);
		this.crc = crc;
	}
    public void setCRC(boolean crc){
    	this.crc = crc;
    }
    public boolean getCRC(){
    	return this.crc;
    }
	
	private static String compute(String code, boolean crc){
	    if (crc){
	    	code = BarcodeMSI.computeMod10(code);
	    }
	    return code;
	}
	
	@SuppressWarnings("unused")
	private static String compute(String code, String[] crc){
		if (crc[0] == "mod10"){
			code = BarcodeMSI.computeMod10(code);
        } else if (crc[0] == "mod11"){
            code = BarcodeMSI.computeMod11(code);
        }
        if (crc[1] == "mod10"){
        	code = BarcodeMSI.computeMod10(code);
        } else if (crc[1] == "mod11"){
	        code = BarcodeMSI.computeMod11(code);
	    }
	    return code;
	}
	  
	private static String computeMod10(String code){
	    int len = code.length();
	    int toPart1 = len % 2;
	    int n1 = 0;
	    int sum = 0;
	    for(int i=0; i<len; i++){
	    	if (toPart1 == 1) {
	    		n1 = 10 * n1 + Integer.parseInt(""+code.charAt(i));
	    	} else {
		        sum += Integer.parseInt(""+code.charAt(i));
	    	}
	    	if (toPart1 == 0)
	    		toPart1 = 1;
	    	else if (toPart1 == 1)
	    		toPart1 = 0;
	    }
	    String s1 = ""+ (2 * n1);
	    len = s1.length();
	    for(int i=0; i<len; i++){
	    	sum += Integer.parseInt(""+s1.charAt(i));
	    }
	    return code + ( ""+ ((10 - sum % 10) % 10));
	}
	  
	private static String computeMod11(String code){
	    int sum = 0;
	    int weight = 2;
	    for(int i=code.length()-1; i>-1; i--){
	    	sum += weight * Integer.parseInt(""+code.charAt(i));
	    	weight = weight == 7 ? 2 : weight + 1;
	    }
	    return code + ( ""+ ((11 - sum % 11) % 11));
	}

	public String getDigit(){
		return this.getDigit(this.crc);
	}
	
	public String getDigit(boolean crc){
    	String code = new String(this.getCode());
	    if (!code.matches("[0-9]*"))	
	    	this.setResult(""); 
	    else
	    {
	    	StringBuilder result = new StringBuilder("");
		    
		    code = BarcodeMSI.compute(code, crc);
		    
		    // start
		    result.append("110");
		    // digits
		    int len = code.length();
		    for(int i=0; i<len; i++){
		    	result.append(BarcodeMSI.encoding[Integer.parseInt(""+code.charAt(i))]);
		    }
		    // stop
		    result.append("1001");
		    
	    	this.setResult(result.toString()); 
	    	this.setComputedCode(code);
	    }
    	return this.getResult();
    }
}






