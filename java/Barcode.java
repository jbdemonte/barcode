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

import java.awt.Color;
import java.awt.FontMetrics;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.File;

import javax.imageio.ImageIO;

public abstract class Barcode {
	private String code;
	private String computedCode;
	private String result;

	public Barcode(String code){
		this.code = code;
		this.computedCode = "";
		this.result = null;
	}
	public String getCode(){
		return this.code;
	}
	public void setCode(String code){
		this.code = code;
		this.computedCode = "";
		this.result = null;
	}
	public String getComputedCode(){
		return this.computedCode;
	}
	protected void setComputedCode(String computedCode){
		this.computedCode = computedCode;
	}
	public String getResult(){
		return this.result;
	}
	protected void setResult(String result){
		this.result = result;
	}
	public boolean export(String res, int width, int height, boolean hri, String file){
		if (this.result == null)
			this.getDigit();
			
		if (this.result != null){
			BufferedImage img = new BufferedImage(1000,1000, BufferedImage.TYPE_INT_RGB);
			Graphics2D g = img.createGraphics();
			
			g.setColor (Color.white);
			g.fillRect(0, 0, 1000, 1000);

			int barcodeWidth = 0;
			int barcodeHeight = 0;
			
			g.setColor (Color.black);
			if (!is2D()){
				  barcodeWidth = result.length() * width + 10;
				  barcodeHeight = 25 + height;
	    		  for (int i = 0; i<this.result.length(); i++){
	    		  	  if (this.result.charAt(i) == '1')
	    		  		  g.fillRect(5+i, 5, width, height);
	    	  		  if (hri)
	    	  			  g.drawString(this.computedCode,5,20+height);
	    	  	  }
	      	}
	    	else{
	    		  int i = 0;
	    		  int j = 0;
	    		  barcodeWidth = this.getWidth() * width;
	    		  barcodeHeight = 25 + (this.getWidth() * width);
	    		  for (int k=0; k<this.result.length(); k++){
	    			  if (this.result.charAt(k) == '1')
	    				  g.fillRect((i*width), (j*width), width, width);
	    		  	  i += 1;
	    		  	  if (i == this.getWidth()){
	    		  		  i = 0;
	    		  		  j += 1;
	    		  	  }
	    		  }
	    		  if (hri)
	    			  g.drawString(this.computedCode,width,20+(this.getWidth()*width));
	    	}
			
			if (hri){
				FontMetrics metrics = g.getFontMetrics();
				int stringW = metrics.stringWidth(this.computedCode) + 2*width;
				barcodeWidth = stringW > barcodeWidth ? stringW : barcodeWidth;
			}
			
			img = img.getSubimage(0, 0, barcodeWidth, barcodeHeight); 
			
			try{
				if ((res.equals("png") || res.equals("jpg") || res.equals("gif")) && file.endsWith(res))
					ImageIO.write(img,res,new File(file));
				else
					return false;

				return true;
			}
			catch (Exception e) { return false; }
			
		}
		return false;
	}
	
	public abstract boolean is2D();
	public abstract int getWidth();
	public abstract String getDigit();
	
}
