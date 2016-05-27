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

public class BarcodeEAN extends Barcode1D{
	public final static String[] types = new String[]{"ean8","ean13"};
    private static String[][] encoding = new String[][]{
    	      {"0001101", "0100111", "1110010"},
    	      {"0011001", "0110011", "1100110"},
    	      {"0010011", "0011011", "1101100"},
    	      {"0111101", "0100001", "1000010"},
    	      {"0100011", "0011101", "1011100"},
    	      {"0110001", "0111001", "1001110"},
    	      {"0101111", "0000101", "1010000"},
    	      {"0111011", "0010001", "1000100"},
    	      {"0110111", "0001001", "1001000"},
    	      {"0001011", "0010111", "1110100"}};
    
    private static String[] first = new String[]{"000000","001011","001101","001110","010011",
    											 "011001","011100","010101","010110","011010"};
    private String type;
    
    public BarcodeEAN(String code){
		super(code);
		this.type = "ean8";
	}
    public BarcodeEAN(String code, String type){
		super(code);
		this.type = type;
	}
    
    public String getType(){
    	return this.type;
    }
    public void setType(String type){
    	this.type = type;
    }
    
    public static String compute(String code, String type){
    	int len = type.equals("ean13") ? 12 : 7;
        if (code.length() < len)
      	  return "";
    	code = code.substring(0, len);
        if (!code.matches("[0-9]{"+len+"}"))
  		  return "";    	
        int sum = 0;
    	boolean odd = true;
    	for(int i=len-1; i>-1; i--){
    		sum += (odd ? 3 : 1) * Integer.parseInt(""+code.charAt(i));
    		odd = ! odd;
    	}
    	return code + (((10 - sum % 10) % 10));
    }


    public String getDigit(){
      String code = new String(this.getCode());

      // Check len (12 for ean13, 7 for ean8)
      int len = (type.equals("ean8")) ? 7 : 12;
      
      if (code.length() < len || !code.matches("[0-9]*") || !(this.type.equals("ean8") || this.type.equals("ean13")))
    	  this.setResult("");
      else
      {    	  
	      StringBuilder result = new StringBuilder("");
	      // get checksum
	      code = code.substring(0, len);

	      code = BarcodeEAN.compute(code, this.type);
	      
	      
	      // process analyse
	      result.append("101"); // start
	      
	      if (type.equals("ean8")){
	        // process left part
	        for(int i=0; i<4; i++){
	        	result.append(BarcodeEAN.encoding[Integer.parseInt(""+code.charAt(i))][0]);
	        }
	            
	        // center guard bars
	        result.append("01010");
	            
	        // process right part
	        for(int i=4; i<8; i++){
	        	result.append(BarcodeEAN.encoding[Integer.parseInt(""+code.charAt(i))][2]);
	        }
	            
	      } else { // ean13
	        // extract first digit and get sequence
	        String seg = BarcodeEAN.first[ Integer.parseInt(""+code.charAt(0)) ];
	        
	        // process left part
	        for(int i=1; i<7; i++){
	        	result.append(BarcodeEAN.encoding[Integer.parseInt(""+code.charAt(i))][Integer.parseInt(""+seg.charAt(i-1))]);
	        }
	        
	        // center guard bars
	        result.append("01010");
	            
	        // process right part
	        for(int i=7; i<13; i++){
	        	result.append(BarcodeEAN.encoding[Integer.parseInt(""+code.charAt(i))][2]);
	        }
	      } // ean13
	      
	      result.append("101"); // stop
	      this.setResult(result.toString()); 
	  	  this.setComputedCode(code);
      }
  	  
      return this.getResult();
    }
    
}




