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

public class BarcodeDatamatrix extends Barcode {

	private static int lengthRows[] = {10, 12, 14, 16, 18, 20, 22, 24, 26, 
		32, 36, 40, 44, 48, 52, 64, 72, 80,  88, 96, 104, 120, 132, 144,
    	8, 8, 12, 12, 16, 16 }; 

	private static int lengthCols[] = {10, 12, 14, 16, 18, 20, 22, 24, 26, 
		32, 36, 40, 44, 48, 52, 64, 72, 80, 88, 96, 104, 120, 132, 144,
        18, 32, 26, 36, 36, 48 }; 

	private static int dataCWCount[] = {3, 5, 8, 12,  18,  22,  30,  36,  
		44, 62, 86, 114, 144, 174, 204, 280, 368, 456, 576, 696, 816, 1050, 
		1304, 1558, 5, 10, 16, 22, 32, 49 }; 	
	
	private static int solomonCWCount[] = {5, 7, 10, 12, 14, 18, 20, 24, 28,
        36, 42, 48, 56, 68, 84, 112, 144, 192, 224, 272, 336, 408, 496, 620,
        7, 11, 14, 18, 24, 28 };
	
	private static int dataRegionRows[] = { 8, 10, 12, 14, 16, 18, 20, 22, 
		24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
		6,  6, 10, 10, 14, 14 };

	private static int dataRegionCols[] = { 8, 10, 12, 14, 16, 18, 20, 22, 
		24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
        16, 14, 24, 16, 16, 22 };
	
	private static int regionRows[] = { 1, 1, 1, 1, 1, 1, 1, 1, 
		1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 1, 1, 1, 1, 1 };
	
	private static int regionCols[] = { 1, 1, 1, 1, 1, 1, 1, 1, 
		1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 2, 1, 2, 2, 2 };
	
	private static int interleavedBlocks[] = { 1, 1, 1, 1, 1, 1, 1, 1, 
		1, 1, 1, 1, 1, 1, 2, 2, 4, 4, 4, 4, 6, 6, 8, 8,
        1, 1, 1, 1, 1, 1 };
	
	private int[] logTab = new int[]{-255, 255, 1, 240, 2, 225, 241, 53, 3, 
		38, 226, 133, 242, 43, 54, 210, 4, 195, 39, 114, 227, 106, 134, 28, 
		243, 140, 44, 23, 55, 118, 211, 234, 5, 219, 196, 96, 40, 222, 115, 
		103, 228, 78, 107, 125, 135, 8, 29, 162, 244, 186, 141, 180, 45, 99, 
		24, 49, 56, 13, 119, 153, 212, 199, 235, 91, 6, 76, 220, 217, 197, 
		11, 97, 184, 41, 36, 223, 253, 116, 138, 104, 193, 229, 86, 79, 171, 
		108, 165, 126, 145, 136, 34, 9, 74, 30, 32, 163, 84, 245, 173, 187, 
		204, 142, 81, 181, 190, 46, 88, 100, 159, 25, 231, 50, 207, 57, 147, 
		14, 67, 120, 128, 154, 248, 213, 167, 200, 63, 236, 110, 92, 176, 7, 
		161, 77, 124, 221, 102, 218, 95, 198, 90, 12, 152, 98, 48, 185, 179, 
		42, 209, 37, 132, 224, 52, 254, 239, 117, 233, 139, 22, 105, 27, 194, 
		113, 230, 206, 87, 158, 80, 189, 172, 203, 109, 175, 166, 62, 127, 
		247, 146, 66, 137, 192, 35, 252, 10, 183, 75, 216, 31, 83, 33, 73, 
		164, 144, 85, 170, 246, 65, 174, 61, 188, 202, 205, 157, 143, 169, 82, 
		72, 182, 215, 191, 251, 47, 178, 89, 151, 101, 94, 160, 123, 26, 112, 
		232, 21, 51, 238, 208, 131, 58, 69, 148, 18, 15, 16, 68, 17, 121, 149, 
		129, 19, 155, 59, 249, 70, 214, 250, 168, 71, 201, 156, 64, 60, 237, 
		130, 111, 20, 93, 122, 177, 150};

	private int[] aLogTab = new int[]{1, 2, 4, 8, 16, 32, 64, 128, 45, 90, 
		180, 69, 138, 57, 114, 228, 229, 231, 227, 235, 251, 219, 155, 27, 54, 
		108, 216, 157, 23, 46, 92, 184, 93, 186, 89, 178, 73, 146, 9, 18, 36, 
		72, 144, 13, 26, 52, 104, 208, 141, 55, 110, 220, 149, 7, 14, 28, 56, 
		112, 224, 237, 247, 195, 171, 123, 246, 193, 175, 115, 230, 225, 239, 
		243, 203, 187, 91, 182, 65, 130, 41, 82, 164, 101, 202, 185, 95, 190, 
		81, 162, 105, 210, 137, 63, 126, 252, 213, 135, 35, 70, 140, 53, 106, 
		212, 133, 39, 78, 156, 21, 42, 84, 168, 125, 250, 217, 159, 19, 38, 76, 
		152, 29, 58, 116, 232, 253, 215, 131, 43, 86, 172, 117, 234, 249, 223, 
		147, 11, 22, 44, 88, 176, 77, 154, 25, 50, 100, 200, 189, 87, 174, 113, 
		226, 233, 255, 211, 139, 59, 118, 236, 245, 199, 163, 107, 214, 129, 
		47, 94, 188, 85, 170, 121, 242, 201, 191, 83, 166, 97, 194, 169, 127, 
		254, 209, 143, 51, 102, 204, 181, 71, 142, 49, 98, 196, 165, 103, 206, 
		177, 79, 158, 17, 34, 68, 136, 61, 122, 244, 197, 167, 99, 198, 161, 
		111, 222, 145, 15, 30, 60, 120, 240, 205, 183, 67, 134, 33, 66, 132, 
		37, 74, 148, 5, 10, 20, 40, 80, 160, 109, 218, 153, 31, 62, 124, 248, 
		221, 151, 3, 6, 12, 24, 48, 96, 192, 173, 119, 238, 241, 207, 179, 75, 
		150, 1};	
	
	private boolean square;
	private int width;
	
	public BarcodeDatamatrix(String code, boolean square){
		super(code);
		this.square = square;
	}
	
	public BarcodeDatamatrix(String code){
		super(code);
		this.square = true;
	}
	
	public boolean is2D(){
		return true;
	}
	public int getWidth(){
		return this.width;
	}
	
	public String getDigit(){
		String code = this.getCode();
		byte[][] matrix = this.getDigit(code);
		StringBuilder result = new StringBuilder("");
		if (matrix != null){
			for (int i=0; i<matrix.length; i++)//{
				for (int j=0; j<matrix[0].length; j++)
					result.append(matrix[i][j]);
				//result.append("\n");
			//}
		}
		this.setResult(result.toString());	    	
		this.setComputedCode(code);
		return result.toString();
	}
	
	public byte[][] getDigit(String text){
		int[] dataCodeWords = encodeDataCodeWordsASCII(text);
		int dataCWCount = dataCodeWords.length;
		int index = selectIndex(dataCWCount, square);
		if (index < 0)
			return null;
		int totalDataCWCount = BarcodeDatamatrix.dataCWCount[index]; 
		int solomonCWCount = BarcodeDatamatrix.solomonCWCount[index];
		int totalCWCount = totalDataCWCount + solomonCWCount;
		int rowsTotal = BarcodeDatamatrix.lengthRows[index];
		int colsTotal = BarcodeDatamatrix.lengthCols[index];
		this.width = BarcodeDatamatrix.lengthCols[index] + 2;
		int rowsRegion = BarcodeDatamatrix.regionRows[index];
		int colsRegion = BarcodeDatamatrix.regionCols[index];
	    int rowsRegionCW = BarcodeDatamatrix.dataRegionRows[index];
	    int colsRegionCW = BarcodeDatamatrix.dataRegionCols[index];
		short rowsLengthMatrice = (short) (rowsTotal-2*rowsRegion);
		short colsLengthMatrice = (short) (colsTotal-2*colsRegion);
		int blocks = interleavedBlocks[index];
		int errorBlocks = (solomonCWCount / blocks);
			
		int[] codeWords = new int[totalCWCount];
		System.arraycopy(dataCodeWords, 0, codeWords, 0, dataCWCount);
			
		// Add the CW pads 
		addPadCW(codeWords, dataCWCount, totalDataCWCount);
			
		// Calculate the correction CW 
		int[] g = calculSolFactorTable(errorBlocks);
		addReedSolomonCW(solomonCWCount, g, totalDataCWCount, codeWords, blocks);
			
		// Create bits
		byte[][] codeWordsBits = new byte[totalCWCount][];
		for (int i=0; i<totalCWCount; i++){
			codeWordsBits[i] = getBits(codeWords[i]);
		}
					
		// Put the bits in the matrix	
		byte[][] datamatrix = new byte[rowsLengthMatrice][colsLengthMatrice];
		byte[][] assigned = new byte[rowsLengthMatrice][colsLengthMatrice];
			
		if ( ((rowsLengthMatrice * colsLengthMatrice) % 8) == 4)
		{
			datamatrix[rowsLengthMatrice-2][colsLengthMatrice-2] = 1;
			datamatrix[rowsLengthMatrice-1][colsLengthMatrice-1] = 1;
			datamatrix[rowsLengthMatrice-1][colsLengthMatrice-2] = 0;
			datamatrix[rowsLengthMatrice-2][colsLengthMatrice-1] = 0;
			assigned[rowsLengthMatrice-2][colsLengthMatrice-2] = 1;
			assigned[rowsLengthMatrice-1][colsLengthMatrice-1] = 1;
			assigned[rowsLengthMatrice-1][colsLengthMatrice-2] = 1;
			assigned[rowsLengthMatrice-2][colsLengthMatrice-1] = 1;
		}
		
		next(rowsLengthMatrice, colsLengthMatrice, codeWordsBits, datamatrix, assigned);
		
		// Add the finder pattern
		datamatrix = addFinderPattern(datamatrix, rowsRegion, colsRegion, rowsRegionCW, colsRegionCW);
		
		return datamatrix;
	}

	private byte[] getBits(int entier)
	{
		byte[] bits = new byte[8];
		byte bTemp;
		int exp = 128;
		for (int i=0; i<=7; i++){
			bTemp = (byte) (entier / exp);
			bits[i] = bTemp;
			if (bTemp==1) entier -= exp;
			exp /= 2;
		}
		return bits;
	}
	
	private void next(short totalRows, short totalCols, byte[][] codeWordsBits, byte[][] datamatrix, byte[][] assigned){
	      
		// Place of the 8st bit from the first character to [4][0]
		short chr = 0;
		short row = 4;
		short col = 0;
		
		do {
			// Check for for the special cases of a corner
			if((row == totalRows) && (col == 0)){
				PatternShapeSpecial1(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);	
				chr++;
			}
			else if((row == totalRows-2) && (col == 0) && (totalCols%4 != 0)){
				PatternShapeSpecial2(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
				chr++;
			}
			else if((row == totalRows-2) && (col == 0) && (totalCols%8 == 4)){
				PatternShapeSpecial3(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
				chr++;
			}
			else if((row == totalRows+4) && (col == 2) && (totalCols%8 == 0)){
				PatternShapeSpecial4(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
				chr++;
			}

			// Go up and right in the datamatrix
			do {
				if((row < totalRows) && (col >= 0) && (assigned[row][col]!=1)){
					PatternShapeStandard(datamatrix, assigned, codeWordsBits[chr], row, col, totalRows, totalCols);
					chr++;
				}
				row -= 2;
				col += 2;
			} while ((row >= 0) && (col < totalCols));
			
			row += 1;
			col += 3;
			
			// Go down and left in the datamatrix
			do {
				if((row >= 0) && (col < totalCols) && (assigned[row][col]!=1)){
					PatternShapeStandard(datamatrix, assigned, codeWordsBits[chr], row, col, totalRows, totalCols);
					chr++;
				}
				
				row += 2;
				col -= 2;
				
			} while ((row < totalRows) && (col >=0));
			
			row += 3;
			col += 1;
			
		} while ((row < totalRows) || (col < totalCols));
	}

	private void PatternShapeStandard(byte[][] datamatrix, 
			  						  byte[][] assigned, 
			  						  byte[] bits, 
			  						  short row,  
			  						  short col,
			  						  short totalRows, 
			  						  short totalCols){
		placeBitInDatamatrix(datamatrix, assigned, bits[0], (byte) 1, (short)(row-2), (short)(col-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[1], (byte) 2, (short)(row-2), (short)(col-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[2], (byte) 3, (short)(row-1), (short)(col-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[3], (byte) 4, (short)(row-1), (short)(col-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[4], (byte) 5, (short)(row-1), (short)(col), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[5], (byte) 6, (short) row, (short)(col-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[6], (byte) 7, (short) row, (short)(col-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[7], (byte) 8, (short) row, (short) col, totalRows, totalCols);
}	
	
	private void PatternShapeSpecial1(byte[][] datamatrix, 
									  byte[][] assigned, 
									  byte[] bits, 
									  short totalRows, 
									  short totalCols){
		placeBitInDatamatrix(datamatrix, assigned, bits[0], (byte) 1, (short)(totalRows-1), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[1], (byte) 2, (short)(totalRows-1), (short) 1, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[2], (byte) 3, (short)(totalRows-1), (short) 2, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[3], (byte) 4, (short) 0, (short)(totalCols-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[4], (byte) 5, (short) 0, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[5], (byte) 6, (short) 1, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[6], (byte) 7, (short) 2, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[7], (byte) 8, (short) 3, (short)(totalCols-1), totalRows, totalCols);
	}

	private void PatternShapeSpecial2(byte[][] datamatrix, 
									  byte[][] assigned, 
									  byte[] bits, 
									  short totalRows, 
									  short totalCols){
		placeBitInDatamatrix(datamatrix, assigned, bits[0], (byte) 1, (short)(totalRows-3), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[1], (byte) 2, (short)(totalRows-2), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[2], (byte) 3, (short)(totalRows-1), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[3], (byte) 4, (short) 0, (short)(totalCols-4), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[4], (byte) 5, (short) 0, (short)(totalCols-3), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[5], (byte) 6, (short) 0, (short)(totalCols-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[6], (byte) 7, (short) 0, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[7], (byte) 8, (short) 1, (short)(totalCols-1), totalRows, totalCols);
	}
	
	private void PatternShapeSpecial3(byte[][] datamatrix, 
									  byte[][] assigned, 
									  byte[] bits, 
									  short totalRows, 
									  short totalCols){
		placeBitInDatamatrix(datamatrix, assigned, bits[0], (byte) 1, (short)(totalRows-3), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[1], (byte) 2, (short)(totalRows-2), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[2], (byte) 3, (short)(totalRows-1), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[3], (byte) 4, (short) 0, (short)(totalCols-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[4], (byte) 5, (short) 0, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[5], (byte) 6, (short) 1, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[6], (byte) 7, (short) 2, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[7], (byte) 8, (short) 3, (short)(totalCols-1), totalRows, totalCols);
	}
	
	private void PatternShapeSpecial4(byte[][] datamatrix, 
									  byte[][] assigned, 
									  byte[] bits, 
									  short totalRows, 
									  short totalCols){
		placeBitInDatamatrix(datamatrix, assigned, bits[0], (byte) 1, (short)(totalRows-1), (short) 0, totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[1], (byte) 2, (short)(totalRows-1), (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[2], (byte) 3, (short) 0, (short)(totalCols-3), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[3], (byte) 4, (short) 0, (short)(totalCols-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[4], (byte) 5, (short) 0, (short)(totalCols-1), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[5], (byte) 6, (short) 1, (short)(totalCols-3), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[6], (byte) 7, (short) 1, (short)(totalCols-2), totalRows, totalCols);
		placeBitInDatamatrix(datamatrix, assigned, bits[7], (byte) 8, (short) 1, (short)(totalCols-1), totalRows, totalCols);
	}
	
	private void placeBitInDatamatrix(byte[][] datamatrix,
									  byte[][] assigned,
									  byte bit,
									  byte position,
									  short row, 
									  short col, 
									  short totalRows, 
									  short totalCols){
		
		if (row < 0) {
			row += totalRows;
			col += 4 - ((totalRows+4)%8);
		}
		if (col < 0) {
			col += totalCols;
			row += 4 - ((totalCols+4)%8);
		}		
		
		if (assigned[row][col] != 1) {
		      datamatrix[row][col] = bit;
		      assigned[row][col] = 1;
		}
	}

	
	private int[] calculSolFactorTable(int solomonCWCount){
		int[] g = new int[solomonCWCount+1];
		
		for (int i=0; i<=solomonCWCount; i++){
			g[i] = 1;
		}
	
		for(int i = 1; i <= solomonCWCount; i++) { 
			for(int j = i - 1; j >= 0; j--) {
				g[j] = champGaloisDoub(g[j], i);    
				if(j > 0){
					g[j] = champGaloisSum(g[j], g[j-1]); 
				}
			}
		} 
				
		return g;
	}
	

	private void addReedSolomonCW(int nSolomonCW, 
								 int[] coeffTab, 
								 int nDataCW,
								 int[] dataTab,
								 int blocks){
		
		int temp = 0;		
		int errorBlocks = nSolomonCW / blocks;
		int[] correctionCW = new int[errorBlocks];

		for(int k = 0; k < blocks; k++) {          
			for (int i=0; i<errorBlocks; i++)
				correctionCW[i] = 0;
			
			for (int i=k; i<nDataCW; i=i+blocks){    		
				temp = champGaloisSum(dataTab[i], correctionCW[errorBlocks-1]);
				for (int j=errorBlocks-1; j>=0; j--){    
				
					if (temp == 0) correctionCW[j] = 0;
					else{
						correctionCW[j] = champGaloisMult(temp, coeffTab[j]);
					}
						
					if (j>0) {
						correctionCW[j] = champGaloisSum(correctionCW[j-1], correctionCW[j]);
					}						
				}	
			}
			
			int j = nDataCW + k;
			for (int i=errorBlocks-1; i>=0; i--){
				dataTab[j] = correctionCW[i];
				j=j+blocks;
			} 
		}
	}
	
	
	private int champGaloisMult(int a, int b){
		if(a == 0 || b == 0)
			return 0;
		else
			return aLogTab[(logTab[a] + logTab[b]) % 255];    
	}

	
	private int champGaloisDoub(int a, int b)
	{
		if (a == 0) 
			return 0;
		else if (b == 0)
		    return a;
		else
			return aLogTab[(logTab[a] + b) % 255];
	}
	
	
	private int champGaloisSum(int a, int b)
	{
		return a ^ b;
	}

	
	private void addPadCW(int[] tab, int from, int to){		
		if (from >= to) return;
		tab[from] = 129; 
		
		int r;
		for (int i=from+1; i<to; i++){
			r = ((149 * (i+1)) % 253) + 1;
			tab[i] = (129 + r) % 254;
		}
	}
	
	
	
	private int selectIndex(int dataCodeWordsCount, boolean square) {
		if ((dataCodeWordsCount<1 || dataCodeWordsCount>1558) && square)
			return -1;
		if ((dataCodeWordsCount<1 || dataCodeWordsCount>49) && !square)
			return -1;
		int n=0;
		if (!square) n = 24;
		while (dataCWCount[n] < dataCodeWordsCount){
			n++;
		}
		return n;
	}
	
	
	private int[] encodeDataCodeWordsASCII(String text) {
		int textLength = text.length();
		int[] dataCodeWords = new int[2000]; // 2000 ?
		int n = 0;
				
		for (int i=0; i<textLength; i++){
			int c = (int) text.charAt(i);
			
			if (c >= 128) {	
				dataCodeWords[n] = 235;
				c = c - 127;
				n++;
			}
			else if ((c>=48 && c<=57) && (i+1<textLength) && (text.charAt(i+1)>=48 && text.charAt(i+1)<=57)) {
				c = ((c - 48) * 10) + (((int) text.charAt(i+1))-48);
				c += 130;
				i++;
			}
			else c++; 
		
			dataCodeWords[n] = c;
			n++;
		}
		
		int[] toReturn = new int[n];
		System.arraycopy(dataCodeWords, 0, toReturn, 0, n);
		
		return toReturn;
	}
	
    private byte[][] addFinderPattern(byte[][] datamatrix, int rowsRegion, int colsRegion, int rowsRegionCW, int colsRegionCW){ // Add the finder pattern
        int totalRowsCW = (rowsRegionCW+2) * rowsRegion;
        int totalColsCW = (colsRegionCW+2) * colsRegion;
        
        byte[][] datamatrixTemp = new byte[totalRowsCW+2][totalColsCW+2];
        
        for (int i=0; i<totalRowsCW; i++){
          datamatrixTemp[i+1][0] = 0;
          datamatrixTemp[i+1][totalColsCW+1] = 0;
          for (int j=0; j<totalColsCW; j++){
            if (i%(rowsRegionCW+2) == 0){
              if (j%2 == 0){
                datamatrixTemp[i+1][j+1] = 1;
              } else { 
                datamatrixTemp[i+1][j+1] = 0;
              }
            } else if (i%(rowsRegionCW+2) == rowsRegionCW+1){ 
              datamatrixTemp[i+1][j+1] = 1;
            } else if (j%(colsRegionCW+2) == colsRegionCW+1){
              if (i%2 == 0){
                datamatrixTemp[i+1][j+1] = 0;
              } else {
                datamatrixTemp[i+1][j+1] = 1;
              }
            } else if (j%(colsRegionCW+2) == 0){ 
              datamatrixTemp[i+1][j+1] = 1;
            } else{
              datamatrixTemp[i+1][j+1] = 0;
              datamatrixTemp[i+1][j+1] = datamatrix[i-1-(2*(Math.round(i/(rowsRegionCW+2))))][j-1-(2*(Math.round(j/(colsRegionCW+2))))]; // todo : parseInt => ?
            }
          }
        }
        for (int j=0; j<totalColsCW+2; j++){
          datamatrixTemp[totalRowsCW+1][j] = 0;
        }
        return datamatrixTemp;
      }
}