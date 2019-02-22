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

public class Barcode128 extends Barcode1D{
	private static String[] encoding = new String[] {
        "11011001100", "11001101100", "11001100110", "10010011000",
        "10010001100", "10001001100", "10011001000", "10011000100",
        "10001100100", "11001001000", "11001000100", "11000100100",
        "10110011100", "10011011100", "10011001110", "10111001100",
        "10011101100", "10011100110", "11001110010", "11001011100",
        "11001001110", "11011100100", "11001110100", "11101101110",
        "11101001100", "11100101100", "11100100110", "11101100100",
        "11100110100", "11100110010", "11011011000", "11011000110",
        "11000110110", "10100011000", "10001011000", "10001000110",
        "10110001000", "10001101000", "10001100010", "11010001000",
        "11000101000", "11000100010", "10110111000", "10110001110",
        "10001101110", "10111011000", "10111000110", "10001110110",
        "11101110110", "11010001110", "11000101110", "11011101000",
        "11011100010", "11011101110", "11101011000", "11101000110",
        "11100010110", "11101101000", "11101100010", "11100011010",
        "11101111010", "11001000010", "11110001010", "10100110000",
        "10100001100", "10010110000", "10010000110", "10000101100",
        "10000100110", "10110010000", "10110000100", "10011010000",
        "10011000010", "10000110100", "10000110010", "11000010010",
        "11001010000", "11110111010", "11000010100", "10001111010",
        "10100111100", "10010111100", "10010011110", "10111100100",
        "10011110100", "10011110010", "11110100100", "11110010100",
        "11110010010", "11011011110", "11011110110", "11110110110",
        "10101111000", "10100011110", "10001011110", "10111101000",
        "10111100010", "11110101000", "11110100010", "10111011110",
        "10111101110", "11101011110", "11110101110", "11010000100",
        "11010010000", "11010011100", "11000111010"};
    
	private boolean crc;
	
	public Barcode128(String code){
		super(code);
		this.crc = false;
	}
    public Barcode128(String code, boolean crc){
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
    	if (!code.matches("[ !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\./0-9:;<=>\\?@A-Z\\[\\\\\\]\\^_`a-z\\{\\|\\}~]*"))
    		this.setResult("");
    	else{
    		StringBuilder result = new StringBuilder("");
	    	String tableB = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~";
	    	int sum = 0;
	    	int isum = 0;
	    	int value = 0;
	      
	    	// check each characters
	    	int len = code.length();
	    	for(int i=0; i<len; i++){
	    		if (! tableB.contains(""+code.charAt(i))){
	    			this.setResult("");
	    			return "";
	    		}
	    	}
	      
	    	// check firsts characters : start with C table only if enought numeric
	    	boolean tableCActivated = len> 1;
	    	
	    	for(int i=0; i<3 && i<len; i++){
	    		tableCActivated &= (""+code.charAt(i)).matches("[0-9]");
	    	}
	    	
	    	sum = tableCActivated ? 105 : 104;
	      
	    	// start : [105] : C table or [104] : B table 
	    	result.append(Barcode128.encoding[sum]);
	      
	    	int i = 0;
	    	while( i < len ){
	    		if (! tableCActivated){
	    			int j = 0;
	    			// check next character to activate C table if interresting
	    			while ((i + j < len) && (""+code.charAt(i+j)).matches("[0-9]")) j++;
	          
	    			tableCActivated = (j > 5) || ((i + j - 1 == len) && (j > 3));
	
	    			if (tableCActivated){
	    				result.append(Barcode128.encoding[99]); // C table
	    				isum ++;
	    				sum += isum * 99;
	    			}
	          // 2 min for table C so need table B
	    		} else if ((i == len - 1) || (""+code.charAt(i)).matches("[^0-9]") || (""+code.charAt(i+1)).matches("[^0-9]") ) { //todo : verifier le JS : len - 1!!! XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
	    			tableCActivated = false;
	    			result.append(Barcode128.encoding[100]); // B table
	    			isum ++;
	    			sum += isum * 100;
	    		}
	        
	    		if (tableCActivated) {
	    			value = Integer.parseInt(code.substring(i, i+2));
	    			i += 2;
	    		} else {
	    			value = tableB.indexOf(code.charAt(i));
	    			i++;
	    		}
	    		result.append(Barcode128.encoding[value]);
	    		isum ++;
				sum += isum * value;
	    	}
	      
	    	// Add CRC
	    	result.append(Barcode128.encoding[sum % 103]);
	      
	    	// Stop
	    	result.append(Barcode128.encoding[106]);
	      
	    	// Termination bar
	    	result.append("11");
	    	
	    	this.setResult(result.toString());
			this.setComputedCode(code);
    	}
    	return this.getResult();
    }
}

