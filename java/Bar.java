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

public class Bar {
	private int[] modules;
	
	public Bar(int[] modules){
		this.modules = modules;
	}
	
	public Bar(String modules){
		this.modules = new int[modules.length()];
		for (int i=0; i<modules.length(); i++){
			this.modules[i] = Integer.parseInt(String.valueOf(modules.charAt(i)));
		}
	}
	
	public int[] getModules(){
		return this.modules;
	}
	
	public void addModules(String modules){ // A vŽrifier
		if (this.modules != null){
			int[] modulesTemp = new int[modules.length() + this.modules.length];
			System.arraycopy(this.modules, 0, modulesTemp, 0, this.modules.length);
			for (int i=0; i<modules.length(); i++){
				modulesTemp[i+this.modules.length] = Integer.parseInt(String.valueOf(modules.charAt(i)));
			}
			this.modules = modulesTemp;
		}
		else{
			this.modules = new int[modules.length()];
			for (int i=0; i<modules.length(); i++){
				this.modules[i] = Integer.parseInt(String.valueOf(modules.charAt(i)));
			}
		}
	}
	
	public void addModules(int[] modules){ // A vŽrifier
		if (this.modules != null){
			int[] modulesTemp = new int[modules.length + this.modules.length];
			System.arraycopy(this.modules, 0, modulesTemp, 0, this.modules.length);
			System.arraycopy(modules, 0, modulesTemp, this.modules.length, modules.length);
			this.modules = modulesTemp;
		}
		else{
			this.modules = new int[modules.length];
			System.arraycopy(modules, 0, this.modules, 0, this.modules.length);
		}
	}
	
	public void setModules(int[] modules){
		this.modules = modules;
	}
	
	public int getWidth(){
		return this.modules.length;
	}
	
	public int getModule(int pos){
		return this.modules[pos];
	}
	
	public void setModule(int pos, int value){
		this.modules[pos] = value;
	}
}
