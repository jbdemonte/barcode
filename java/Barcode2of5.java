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

public class Barcode2of5 extends Barcode1D{
	public final static String[] types = new String[]{"int25","std25"};
	private static String[] encoding = new String[] {
		"NNWWN", "WNNNW", "NWNNW", "WWNNN", "NNWNW", 
		"WNWNN", "NWWNN", "NNNWW", "WNNWN", "NWNWN" };
    private String type;
    private boolean crc;
    
    public Barcode2of5(String code){
		super(code);
		this.type = "int25";
	}
    public Barcode2of5(String code, String type){
		super(code);
		this.type = type;
		this.crc = false;
	}
    public Barcode2of5(String code, boolean crc){
    	super(code);
    	this.type = "int25";
		this.crc = crc;
	}
    public Barcode2of5(String code, String type, boolean crc){
    	super(code);
    	this.type = type;
		this.crc = crc;
	}
    
    public String getType(){
    	return this.type;
    }
    public void setType(String type){
    	this.type = type;
    }
    public void setCRC(boolean crc){
    	this.crc = crc;
    }
    public boolean getCRC(){
    	return this.crc;
    }
    
    
    public static String compute(String code, boolean crc, String type){
    	if (! crc) {
    		if ((code.length()) % 2 == 1) code = "0" + code;
    	} else {
    		if ( (type.equals("int25")) && (code.length() % 2 == 0) ) 
    			code = "0" + code;
    		boolean odd = true;
    		int sum = 0;
    		for(int i=code.length()-1; i>-1; i--){
    			int v = Integer.parseInt(""+code.charAt(i));
    			sum += (odd ? 3 * v : v);
    			odd = ! odd;
    		}
    		code += ""+ ((10 - sum % 10) % 10);
    	}
    	return code;
    }
    
    public String getDigit(){
      String code = new String(this.getCode());
      code = Barcode2of5.compute(code, crc, type);
      if (!code.matches("[0-9]*") || !(this.type.equals("int25") || this.type.equals("std25"))) 
    	  this.setResult("");
      else{
    	  StringBuilder result = new StringBuilder("");
	      
	      if (type.equals("int25")) { // Interleaved 2 of 5
	        // start
	    	  result.append("1010");
	        
	        // digits + CRC
	        int end = code.length() / 2;
	        for(int i=0; i<end; i++){
	          int c1 = Integer.parseInt(""+code.charAt(2*i));
	          int c2 = Integer.parseInt(""+code.charAt(2*i+1));
	          for(int j=0; j<5; j++){
	        	result.append("1");
	            if (Barcode2of5.encoding[c1].charAt(j) == 'W') result.append("1");
	            result.append("0");
	            if (Barcode2of5.encoding[c2].charAt(j) == 'W') result.append("0");
	          }
	        }
	        // stop
	        result.append("1101");
	      } else if (type.equals("std25")) {
	        // Standard 2 of 5 is a numeric-only barcode that has been in use a long time. 
	        // Unlike Interleaved 2 of 5, all of the information is encoded in the bars; the spaces are fixed width and are used only to separate the bars.
	        // The code is self-checking and does not include a checksum.
	        
	        // start
	    	result.append("11011010");
	        
	        // digits + CRC
	        int end = code.length();
	        for(int i=0; i<end; i++){
	          int c = Integer.parseInt(""+code.charAt(i));
	          for(int j=0; j<5; j++){
	        	result.append("1");
	            if (Barcode2of5.encoding[c].charAt(j) == 'W') result.append("11");
	            result.append("0");
	          }
	        }
	        // stop
	        result.append("11010110");
	      }
	      this.setResult(result.toString()); 
	  	  this.setComputedCode(code);
      }
      return this.getResult();
    }
    
}




