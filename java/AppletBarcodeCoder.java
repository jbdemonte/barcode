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


/*
 * This is an example of Applet
 */

package com.barcode_coder.java_barcode;

import java.awt.*; 
import java.applet.*;  
import java.awt.event.*;
import javax.swing.JPanel;

public class AppletBarcodeCoder extends Applet implements ActionListener 
{
	 private static final long serialVersionUID = 1L;
	
	 private Button generateButton; 
	 private TextField codeField; 
	 private CheckboxGroup radioGroup; 
	 private Checkbox radioEAN8, radioEAN13; 
	 private Checkbox radioStandard2of5, radioInterleaved2of5;
	 private Checkbox radioCode11, radioCode39, radioCode93, radioCode128;
	 private Checkbox radioCodabar, radioMSI;
	 private Checkbox radioDatamatrix;
     
	 private String hri = "", digit = "";
	 private boolean barcode2D = true;
	 private int width = 0;
	 
     public void init()  
     { 
          setLayout(new BorderLayout());
          
          generateButton = new Button("Generate"); 
          codeField = new TextField("12345670",10);
          BorderLayout bl1 = new BorderLayout();    
          JPanel jp1 = new JPanel();
          jp1.setLayout(bl1);
          jp1.add(new Label("Veuillez saisir le code : "), BorderLayout.WEST);
          jp1.add(codeField, BorderLayout.CENTER);
          jp1.add(generateButton, BorderLayout.EAST);
	      add(jp1, BorderLayout.NORTH);

          radioGroup = new CheckboxGroup(); 
          radioEAN8 = new BarcodeCheckBox("EAN8", radioGroup, true, BarcodeType.EAN8); 
          radioEAN13 = new BarcodeCheckBox("EAN13", radioGroup, false, BarcodeType.EAN13); 
          radioStandard2of5 = new BarcodeCheckBox("Standard 2 of 5", radioGroup, false, BarcodeType.Standard2of5); 
          radioInterleaved2of5 = new BarcodeCheckBox("Interleaved 2 of 5", radioGroup, false, BarcodeType.Interleaved2of5);
          radioCode11 = new BarcodeCheckBox("Code 11", radioGroup, false, BarcodeType.Code11); 
          radioCode39 = new BarcodeCheckBox("Code 39", radioGroup, false, BarcodeType.Code39); 
          radioCode93 = new BarcodeCheckBox("Code 93", radioGroup, false, BarcodeType.Code93); 
          radioCode128 = new BarcodeCheckBox("Code 128", radioGroup, false, BarcodeType.Code128); 
          radioCodabar = new BarcodeCheckBox("Codabar", radioGroup, false, BarcodeType.Codabar); 
          radioMSI = new BarcodeCheckBox("MSI", radioGroup, false, BarcodeType.MSI); 
          radioDatamatrix = new BarcodeCheckBox("Datamatrix", radioGroup, false, BarcodeType.Datamatrix);  
          GridLayout gl2 = new GridLayout(12,1);    
          JPanel jp2 = new JPanel();
          jp2.setLayout(gl2);
          jp2.add(new Label("Type de code-barres :"));
          jp2.add(radioEAN8);
          jp2.add(radioEAN13);
          jp2.add(radioStandard2of5);
          jp2.add(radioInterleaved2of5);
          jp2.add(radioCode11);
          jp2.add(radioCode39);
          jp2.add(radioCode93);
          jp2.add(radioCode128);
          jp2.add(radioCodabar);
          jp2.add(radioMSI);
          jp2.add(radioDatamatrix);
	      add(jp2, BorderLayout.SOUTH);
          
          generateButton.addActionListener(this); 
      }

      public void paint(Graphics g) 
      {     	
    	  System.out.println("Repaint");
    	  if (!barcode2D){
    		  for (int i = 0; i<this.digit.length(); i++){
    		  	  if (this.digit.charAt(i) == '1')
    		  		  g.fillRect(20+i, 100, 1, 50);
    	  		  g.drawString(this.hri,20,180);
    	  	  }
      	  }
    	  else{
    		  int i = 0;
    		  int j = 0;
    		  for (int k=0; k<this.digit.length(); k++){
    			  if (this.digit.charAt(k) == '1')
    				  g.fillRect(20+(i*5), 100+(j*5), 5, 5);
    			  System.out.println(i+" "+j);
    			  
    		  	  i += 1;
    		  	  if (i == this.width){
    		  		  i = 0;
    		  		  j += 1;
    		  	  }
    		  }
    		  g.drawString(this.hri,20,100+(j*5)+20);
    	  }
    	  	  
      }

      
      private void calculateBarcode(){
    	  Barcode barcode = BarcodeFactory.createBarcode(((BarcodeCheckBox)this.radioGroup.getSelectedCheckbox()).getType(),
    			  codeField.getText());
    	  
    	  if (barcode == null){
    		  this.digit = "";
    		  this.hri = "";
    	  }
    	  else{
    		  this.digit = barcode.getDigit();
    		  this.hri = barcode.getComputedCode();
    		  this.barcode2D = barcode.is2D();
    		  this.width = barcode.getWidth();
    	  }
      }
      
      public void actionPerformed(ActionEvent evt) { 
    	  if (evt.getSource() == generateButton){
    		  calculateBarcode();  
    		  repaint();
    	  }
      } 

      public class BarcodeCheckBox extends Checkbox{
		private static final long serialVersionUID = 1L;
		private BarcodeType type;
    	  public BarcodeCheckBox(String label, CheckboxGroup group, boolean state, BarcodeType type){
    		  super(label, group, state);
    		  this.type = type;
    	  }
    	  public BarcodeType getType(){
    		  return this.type;
    	  }
    }      
      
} 
 
